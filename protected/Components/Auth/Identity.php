<?php

namespace App\Components\Auth;

use App\Models\User;
use App\Models\UserSession;
use T4\Core\MultiException;
use T4\Mvc\Application;
use App\Components\Mailer;
use T4\Core\Session;

class Identity extends \T4\Auth\Identity
{
    const  ERROR_INVALID_CAPTCHA = 102;
    const ERROR_INVALID_CODE = 103;
    const ERROR_INVALID_TIME = 104;
    const AUTH_COOKIE_NAME = 'T4auth';

    public function authenticate($data)
    {
        $errors = new MultiException();

        if (empty($data->email)) {
            $errors->add(new Exception('e-mail-ығыҙ яҙылмаған', self::ERROR_INVALID_EMAIL));
        }

        if (empty($data->password)) {
            $errors->add(new Exception('Паролегыҙ яҙылмаған', self::ERROR_INVALID_PASSWORD));
        }

        if (!$errors->isEmpty()) {
            throw $errors;
        }

        $user = User::findByEmail($data->email);

        if (!$user) {
            $errors->add(new Exception('Был e-mail ' . $data->email . ' теркәлмәгән', self::ERROR_INVALID_EMAIL));
        }

        if (!$errors->isEmpty()) {
            throw $errors;
        }

        if (!\T4\Crypt\Helpers::checkPassword($data->password, $user->password)) {
            $errors->add(new Exception('Паролеғыҙ дөрөҫ түгел', self::ERROR_INVALID_PASSWORD));
        }

        if (!$errors->isEmpty()) {
            throw $errors;
        }

        $this->login($user);
        Application::getInstance()->user = $user;
        return $user;
    }

    public function getUser()
    {
        if (!\T4\Http\Helpers::issetCookie(self::AUTH_COOKIE_NAME)) {
            return null;
        }

        $hash = \T4\Http\Helpers::getCookie(self::AUTH_COOKIE_NAME);
        $session = UserSession::findByHash($hash);
        if (empty($session)) {
            \T4\Http\Helpers::unsetCookie(self::AUTH_COOKIE_NAME);
            return null;
        }

        if ($session->userAgentHash != md5($_SERVER['HTTP_USER_AGENT'])) {
            $session->delete();
            \T4\Http\Helpers::unsetCookie(self::AUTH_COOKIE_NAME);
            return null;
        }

        return $session->user;
    }

    public function register($data)
    {
        $errors = new MultiException();

        if (empty($data->email)) {
            $errors->add(new Exception('e-mail-ығыҙ яҙылмаған', self::ERROR_INVALID_EMAIL));
        }
        if (empty($data->firstName)) {
            $errors->add(new Exception('Исемегеҙ яҙылмаған', self::ERROR_INVALID_EMAIL));
        }
        if (empty($data->lastName)) {
            $errors->add(new Exception('Фамилияғыҙ яҙылмаған', self::ERROR_INVALID_EMAIL));
        }

        if (empty($data->password)) {
            $errors->add(new Exception('Паролегыҙ яҙылмаған', self::ERROR_INVALID_PASSWORD));
        }

        if (empty($data->password2)) {
            $errors->add(new Exception('Паролеғыҙ ҡабаттан яҙылмаған', self::ERROR_INVALID_PASSWORD));
        }

        if ($data->password2 != $data->password) {
            $errors->add(new Exception('Паролегыҙ бер береһенә тап килмәй', self::ERROR_INVALID_PASSWORD));
        }

        if (!$errors->isEmpty()) {
            throw $errors;
        }

        $user = User::findByEmail($data->email);
        if (!empty($user)) {
            $errors->add(new Exception('Был e-mail теркәлгән', self::ERROR_INVALID_EMAIL));
        }

        if (!$errors->isEmpty()) {
            throw $errors;
        }

        if (!$errors->isEmpty()) {
            throw $errors;
        }

        $user = new User();
        $user->email = $data->email;
        $user->firstName = $data->firstName;
        $user->lastName = $data->lastName;
        $user->password = password_hash($data->password, PASSWORD_DEFAULT);
        $user->save();

        $mailer = new Mailer();
        $mailer->send($user, 'user.register', $data->password);
        return $user;
    }

    /**
     * @param \App\Models\User $user
     */
    public function login($user)
    {
        $app = Application::getInstance();
        $expire = isset($app->config->auth) && isset($app->config->auth->expire) ?
            time() + $app->config->auth->expire :
            0;
        $hash = md5(time() . $user->password);

        \T4\Http\Helpers::setCookie(self::AUTH_COOKIE_NAME, $hash, $expire);

        $session = new UserSession();
        $session->hash = $hash;
        $session->userAgentHash = md5($_SERVER['HTTP_USER_AGENT']);
        $session->user = $user;
        $session->save();
    }

    public function logout()
    {
        if (!\T4\Http\Helpers::issetCookie(self::AUTH_COOKIE_NAME)) {
            return;
        }

        $hash = \T4\Http\Helpers::getCookie(self::AUTH_COOKIE_NAME);
        $session = UserSession::findByHash($hash);
        if (empty($session)) {
            \T4\Http\Helpers::unsetCookie(self::AUTH_COOKIE_NAME);
            return;
        }
        $session->delete();
        \T4\Http\Helpers::unsetCookie(self::AUTH_COOKIE_NAME);

        $app = Application::getInstance();
        $app->user = null;
    }

}