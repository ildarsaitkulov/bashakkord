<?php

namespace App\Modules\Service\Controllers;

use T4\Mvc\Controller;
use App\Models\Service;

class Admin extends Controller
{
    public function actionDefault()
    {
        $this->data->songs = Service::findAll();
    }

    public function actionDelete($id)
    {
        $song = Service::findByPK($id);
        $song->delete();
        $this->redirect('/admin/');
    }
}
