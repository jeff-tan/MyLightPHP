<?php
/**
 * Created by PhpStorm.
 * User: jefftan
 * Date: 17-8-25
 * Time: 下午2:28
 */

namespace Core;

class Session
{
    public function __construct()
    {
        session_start();
    }

    public function get($name)
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }

    public function make($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function forget($name)
    {
        if(isset($_SESSION[$name]))
            unset($_SESSION[$name]);
    }

    public function destroy()
    {
        session_destroy();
    }
}