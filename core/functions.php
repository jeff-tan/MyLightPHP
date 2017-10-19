<?php
/**
 * Created by PhpStorm.
 * User: jefftan
 * Date: 17-8-25
 * Time: 上午10:11
 */

if (!function_exists('dump')) {
    function dump($value)
    {
        dump($value);
    }
}

if (!function_exists('view')) {
    function view($name, $data = [])
    {
        \Core\View::getView($name, $data);
    }
}

if (!function_exists('redirect')) {

}