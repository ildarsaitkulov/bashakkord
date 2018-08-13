<?php
/**
 * Created by PhpStorm.
 * User: Ильдар
 * Date: 07.03.2016
 * Time: 17:40
 */

namespace App\Controllers;

use App\Components\Auth\Identity;
use T4\Core\MultiException;
use T4\Core\Std;
use T4\Mvc\Controller;

class User extends Controller
{

    public function actionLogin()
    {
        if (!empty($this->app->request->post->data)) {
            $login = $this->app->request->post;

            try {
                $identity = new Identity();
                $user = $identity->authenticate($login);
                $this->app->flash->message = 'Рәхим итегеҙ, ' . $user->email . '!';
                $this->redirect('/');
            } catch (MultiException $e) {
                $this->data->errors = $e;
            }
            $this->data->email = $login->email;
        }
    }


    public function actionLogout()
    {
        $identity = new Identity();
        $identity->logout();
        $this->redirect('/');
    }

    public function actionRegister()
    {
        if ($this->app->request->post->data) {
            $register = $this->app->request->post;
            try {
                $identity = new Identity();
                $user = $identity->register($register);
                $identity->login($user);
                $this->app->flash->message = 'Рәхим итегеҙ, ' . $user->email . '!';
                $this->redirect('/');
            } catch (MultiException $e) {
                $this->data->errors = $e;
            }
            $this->data->email = $register->email;
        }
    }
}
