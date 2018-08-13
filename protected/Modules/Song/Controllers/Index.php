<?php
namespace App\Modules\Song\Controllers;

use App\Models\Song;
use T4\Mvc\Controller;
use T4\Http\E404Exception;
use T4\Dbal\QueryBuilder;

class Index extends Controller
{
    const PAGE_SIZE = 40;

    public function actionDefault($page = 1)
    {
        $songs = Song::findAllSortedBash()->toArray();
        $songs = array_slice($songs, self::PAGE_SIZE * ($page - 1), self::PAGE_SIZE);

        $this->data->itemsCount = Song::countAll();
        $this->data->pageSize = self::PAGE_SIZE;
        $this->data->activePage = $page;

        if (!empty($songs)) {
            $this->data->items = $songs;
        } else {
            $this->data->error = 'Бер йыр ҙа табылманы';
        }
    }

    public function actionOne($id)
    {
        if (empty($song = $this->data->item = Song::findByPK($id))) {
            throw new E404Exception('Йыр табылманы');
        }

        if (null === $song->visits) {
            $song->visits = 1;
        } else {
            $song->visits += 1;
        }
        $song->save();
    }

    public function actionFamous()
    {
        $songs = Song::findAll();
        $sorted = $songs->sort(

            function ($a, $b) {
                return (int)$b->visits <=> (int)$a->visits;
            }
        );

        $songs = array_slice($sorted->toArray(), 0, 20);

        $this->data->items = $songs;

    }

    public function actionFind($letter = 'А%')
    {
        $songs = Song::findAllByQuery('SELECT * FROM songs WHERE title LIKE :title',
            ['title' => $letter])->toArray();
        $letter = trim($letter, "%");
        if (!empty($songs)) {
            $this->data->items = $songs;
        } else {
            $this->data->error = 'Ҡыҙғанысҡа күрә ' . $letter . ' хәрефенә йырҙар юҡ';
        }
        $this->data->letter = $letter;
    }

    public function actionFindByLetters()
    {
        if (!empty ($_POST['firstLetters'])) {
            $firstLetters = $_POST['firstLetters'];
            $songs = Song::findAllByQuery(
                (new QueryBuilder())
                    ->select('*')
                    ->from(Song::getTableName())
                    ->where('title LIKE :title')
                    ->params([':title' => '%' . $firstLetters . '%'])
            );
            if (!empty($songs->toArray())) {
                $this->data->items = $songs;
            } else {
                $this->data->error = 'Жаль, но нет композиций по вашему запросу ' . $firstLetters;
            }

        } else {
            $this->redirect('/');
        }
    }
}
