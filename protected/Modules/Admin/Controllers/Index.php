<?php
/**
 * Created by PhpStorm.
 * User: Ильдар
 * Date: 02.03.2016
 * Time: 10:07
 */

namespace App\Modules\Admin\Controllers;

use T4\Mvc\Controller;
use T4\Mvc\Route;
use T4\Mvc\Router;
use T4\Core\Exception;
use T4\Http\E404Exception;

class Index extends Controller
{
    public function actionDefault()
    {
        $this->app->runRoute(
            new Route('/Service/Admin//'),
            Router::getInstance()->getFormatByExtension($this->app->request->extension)
        );
        die;
    }

    public function actionModule($module, $controller = 'Admin', $action = Router::DEFAULT_ACTION)
    {
        try {
            $this->app->runRoute(
                new Route('/' . ucfirst($module) . '/' . ucfirst($controller) . '/' . ucfirst($action)),
                Router::getInstance()->getFormatByExtension($this->app->request->extension)
            );
            exit;
        } catch (Exception $e) {
            throw new E404Exception('Ошибка админ-панели в модуле ' . $module . ': ' . $e->getMessage());
        }
    }

    protected function access($action)
    {
        return !empty($this->app->user) && $this->app->user->hasRole('admin');
    }
}
