<?php
/**
 * Created by PhpStorm.
 * User: jefftan
 * Date: 17-8-17
 * Time: 下午4:17
 */

namespace Core;

use Exception;

class Application
{
    protected static $attributes = [];

    public static function bind($key, $value)
    {
        static::$attributes[$key] = $value;
    }

    public static function get($key)
    {
        if (!array_key_exists($key, static::$attributes)) {
            throw new Exception("Error: No {$key} is bound in the container.");
        }
        return static::$attributes[$key];
    }

}