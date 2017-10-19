<?php
/**
 * Created by PhpStorm.
 * User: jefftan
 * Date: 17-8-25
 * Time: 下午4:43
 */

namespace Core\Facades;

class Facade
{


    public static function __callStatic($method, $args)
    {
        $instance = static::getFacadeAccessor();

        switch (count($args)) {
            case 0:
                return $instance->$method();
            case 1:
                return $instance->$method($args[0]);
            case 2:
                return $instance->$method($args[0], $args[1]);
            case 3:
                return $instance->$method($args[0], $args[1], $args[2]);
            case 4:
                return $instance->$method($args[0], $args[1], $args[2], $args[3]);
            default:
                return call_user_func_array([$instance, $method], $args);
        }
    }
}