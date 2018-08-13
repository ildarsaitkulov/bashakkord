<?php

namespace App\Modules\Service\Controllers;


use App\Models\Service;
use App\Models\Song;
use T4\Core\MultiException;
use T4\Mvc\Controller;

class Index extends Controller
{
    public function actionDefault()
    {

    }
    public function actionAbout()
    {

    }

    public function actionOrder()
    {
        if (!empty($this->app->request->post->toArray())) {
            try {
                $service = new Service();
                $service->fill($this->app->request->post->toArray());
                $res = $service->save();
                if (false != $res) {
                    $this->data->success = 'һеҙҙең мәғлүмәттәр ебәрелде';
                }
            } catch (MultiException $error) {
                $this->data->errors = $error;
            }
        }
    }
    public function actionChords()
    {
        $chords = [];
        foreach ($_GET as $k => $v) {
            $chords[] = strtr($v, '#', '1');
        }
        $chords = array_unique($chords);

        $this->data->chords = $chords;
    }

}