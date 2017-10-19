<?php
/**
 * Created by PhpStorm.
 * User: jefftan
 * Date: 17-8-25
 * Time: 下午4:44
 */

namespace Core\Facades;

use Core\Application;

class Cookie extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Application::get('cookie');
    }
}