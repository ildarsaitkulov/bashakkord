<?php
/**
 * Created by PhpStorm.
 * User: Ильдар
 * Date: 05.03.2016
 * Time: 12:23
 */

namespace App\Modules\Artist\Controllers;

use App\Models\Artist;
use T4\Mvc\Controller;
use T4\Dbal\QueryBuilder;

class Admin extends Controller
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
            $this->data->artists = $artists;
        } else {
            $this->data->error = 'Бер башҡарыусы ла табылманы';
        }
    }

    public function actionAdd()
    {
        if (!empty($this->app->request->post->id)) {
            $artist = Artist::findByPK($this->app->request->post->id);
        } else {
            $artist = new Artist();
        }
        $artist
            ->fill($this->app->request->post)
            ->uploadImage('image');
        $artist->save();
        $this->redirect('/admin/artist/');
    }

    public function actionEdit($id)
    {
        if (null === $id || 'new' == $id) {
            $this->data->artist = new Artist();
        } else {
            $this->data->artist = Artist::findByPK($id);
        }
    }

    public function actionDelete($id)
    {
        $artist = Artist::findByPK($id);
        $artist->delete();
        $this->redirect('/admin/artist/');
    }

    public function actionDeleteImage($id)
    {
        $item = Artist::findByPK($id);
        if ($item) {
            $item->deleteImage();
            $item->save();
            $this->data->result = true;
        } else {
            $this->data->result = false;
        }
    }

    public function actionFind($firstLetters)
    {
        $cities = Artist::findAllByQuery(
            (new QueryBuilder())
                ->select('*')
                ->from(Artist::getTableName())
                ->where('name LIKE :name')
                ->params([':name' => $firstLetters . '%'])
        );
        $result = array_combine($cities->collect('__id'), $cities->collect('name'));
        $this->data->items = $result;
    }

    public function actionFindAlph($letter = 'А%')
    {
        $artists = Artist::findAllByQuery('SELECT * FROM artists WHERE name LIKE :name',
            ['name' => $letter])->toArray();

        $letter = trim($letter, "%");
        if (!empty($artists)) {
            $this->data->artists = $artists;
        } else {
            $this->data->error = 'Ҡыҙғанысҡа күрә ' . $letter . ' хәрефенә башҡарыусылар юҡ';
        }
        $this->data->letter = $letter;
    }
}
