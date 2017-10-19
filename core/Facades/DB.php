<?php
/**
 * Created by PhpStorm.
 * User: jefftan
 * Date: 17-8-25
 * Time: 下午4:45
 */

namespace Core\Facades;

use Core\Application;

class DB
{
    protected static function getFacadeAccessor()
    {
        return Application::get('database');
    }
}