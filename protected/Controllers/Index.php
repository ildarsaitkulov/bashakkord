<?php

namespace App\Controllers;

use T4\Mvc\Controller;
use T4\Mvc\Router;
use T4\Mvc\Route;

class Index extends Controller
{

    public function actionDefault()
    {

        $this->app->runRoute(
            new Route('/News/Index/Default/'),
            Router::getInstance()->getFormatByExtension($this->app->request->extension)
        );
        die;
    }

    public function action404()
    {
    }

    public function action403()
    {
    }
}
