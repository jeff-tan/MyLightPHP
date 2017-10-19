<?php

namespace Core;

class Request
{
    protected static $uri;
    protected static $method;
    protected static $parameters = [];


    private function getUri()
    {
        self::$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        return $this;
    }

    public static function uri()
    {
        return self::$uri;
    }


    private function getMethod()
    {
        self::$method = strtoupper($_SERVER['REQUEST_METHOD']);
        return $this;
    }

    public static function method()
    {
        return self::$method;
    }

    private function getParameters()
    {
        switch (self::$method) {
            case 'GET':
                self::$parameters = $_GET;
                break;
            case 'POST':
            case 'PUT':
            case 'DELETE':
                parse_str(file_get_contents('php://input'), self::$parameters);
                break;
        }
    }

    public static function run()
    {
        $request = new static;
        $request->getUri()->getMethod()->getParameters();
    }

    public static function all()
    {
        return self::$parameters;
    }

    public static function input($key = '')
    {
        if (empty($key)) return self::$parameters;
        return isset(self::$parameters[$key]) ? self::$parameters[$key] : null;
    }

    public static function only(array $keys = [])
    {
        if (empty($keys)) return self::$parameters;
        $arr = [];
        foreach ($keys as $key) {
            if (isset(self::$parameters[$key])) {
                $arr[] = self::$parameters[$key];
            }
        }
        return $arr;
    }

    public static function except(array $keys = [])
    {
        if (empty($keys)) return self::$parameters;
        $arr = self::$parameters;
        foreach ($keys as $key) {
            if (isset($arr[$key])) {
                unset($arr[$key]);
            }
        }
        return $arr;
    }
}