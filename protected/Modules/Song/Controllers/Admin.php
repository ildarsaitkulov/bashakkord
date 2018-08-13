<?php

namespace App\Modules\Song\Controllers;

use T4\Mvc\Controller;
use App\Models\Song;
use App\Models\Service;

class Admin extends Controller
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
            $this->data->songs = $songs;
        } else {
            $this->data->error = 'Бер йыр ҙа табылманы';
        }
    }

    public function actionAdd()
    {

        if (!empty($this->app->request->post->id)) {
            $song = Song::findByPK($this->app->request->post->id);
        } else {
            $song = new Song();
        }

        $song
            ->fill($this->app->request->post)
            ->uploadAudio('audio');
        $song->save();
        $this->redirect('/admin/song/');
    }

    public function actionEdit($id, $service = null)
    {
        if (isset($service)) {
            $this->data->service = Service::findByPK($id);
        } elseif (null === $id || 'new' == $id) {
            $this->data->song = new Song();
        } else {
            $this->data->song = Song::findByPK($id);
        }
    }

    public function actionDeleteAudio($id)
    {
        $item = Song::findByPK($id);
        if ($item) {
            $item->deleteAudio();
            $item->save();
            $this->data->result = true;
        } else {
            $this->data->result = false;
        }
    }

    public function actionDelete($id)
    {
        $song = Song::findByPK($id);
        $song->delete();
        $this->redirect('/admin/song/');
    }

    public function actionFind($letter = 'А%')
    {
        $songs = Song::findAllByQuery('SELECT * FROM songs WHERE title LIKE :title',
            ['title' => $letter])->toArray();

        $letter = trim($letter, "%");
        if (!empty($songs)) {
            $this->data->songs = $songs;
        } else {
            $this->data->error = 'Ҡыҙғанысҡа күрә ' . $letter . ' хәрефенә йырҙар юҡ';
        }

        $this->data->letter = $letter;
    }

}