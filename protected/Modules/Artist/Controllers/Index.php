<?php

namespace App\Modules\Artist\Controllers;

use App\Models\Artist;
use T4\Core\Exception;
use T4\Mvc\Controller;
use T4\Http\E404Exception;
use T4\Dbal\QueryBuilder;
use T4\Mvc\Route;
use T4\Mvc\Router;

class Index extends Controller
{
    const PAGE_SIZE = 40;

    public function actionDefault($page = 1)
    {
        $artists = Artist::findAllSortedBash()->toArray();
        $artists = array_slice($artists, self::PAGE_SIZE * ($page - 1), self::PAGE_SIZE);

        $this->data->itemsCount = Artist::countAll();
        $this->data->pageSize = self::PAGE_SIZE;
        $this->data->activePage = $page;

        if (!empty($artists)) {
            $this->data->items = $artists;
        } else {
            $this->data->error = 'Бер башҡарыусы ла табылманы';
        }
    }

    public function actionFind($letter = 'А%')
    {
        $artists = Artist::findAllByQuery ('SELECT * FROM artists WHERE name LIKE :name',
                ['name' => $letter])->toArray();

        $letter = trim($letter, "%");
        if(!empty($artists)){
            $this->data->items = $artists;
        } else {
            $this->data->error = 'Ҡыҙғанысҡа күрә ' . $letter .  ' хәрефенә башҡарыусылар юҡ';
        }
        $this->data->letter = $letter;
    }

    public function actionOne($id)
    {
        if (empty($artist = $this->data->item = Artist::findByPK($id))) {
            throw new E404Exception('Башҡарыусылар табылманы');
        }
        $this->data->songs = $artist->songs;
    }

    public function actionFindByLetters()
    {
        if (!empty ($_POST['firstLetters'])) {
            $firstLetters = $_POST['firstLetters'];
            $artists = Artist::findAllByQuery(
                (new QueryBuilder())
                    ->select('*')
                    ->from(Artist::getTableName())
                    ->where('name LIKE :name')
                    ->params([':name' => '%' . $firstLetters . '%'])
            );
            if (!empty($artists->toArray())) {
                $this->data->artists = $artists;
            } else {
                $this->data->error = 'Ҡыҙғанысҡа күрә һеҙҙең запросығыҙ буйынса ' . $firstLetters . ' башҡарыусылар табылманы';
            }
            $this->data->firstLetters = $firstLetters;

        } else {
            $this->redirect('/');
        }
    }
}
