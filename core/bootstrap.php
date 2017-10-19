<?php
/**
 * Created by PhpStorm.
 * User: jefftan
 * Date: 17-8-17
 * Time: 下午3:37
 */

use Core\Application;

require_once __DIR__ . '/..' . '/vendor/autoload.php';

Application::bind('config', require ROOT_PATH . DIRECTORY_SEPARATOR . 'app/config.php');
Application::bind('database', new \Core\Database\QueryBuilder(\Core\Database\Connection::make(Application::get('config')['database'])));
Application::bind('model', new \Core\Model(new \Core\Database\QueryBuilder(\Core\Database\Connection::make(Application::get('config')['database']))));
Application::bind('cookie',new \Core\Cookie());
Application::bind('session',new \Core\Session());