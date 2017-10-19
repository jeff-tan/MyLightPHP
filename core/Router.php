<?php
/**
 * Created by PhpStorm.
 * User: jefftan
 * Date: 17-8-17
 * Time: 下午2:43
 */

namespace Core;

use Exception;

class Router
{
    protected static $routes = [
        'GET' => [], 'POST' => []
    ];

    /**
     * 将定义的GET请求存入routes数组内
     * @param $uri
     * @param $controller
     */
    private function get($uri, $controller)
    {
        if (!array_key_exists('GET', self::$routes)) {
            self::$routes['GET'] = [];
        }
        self::$routes['GET'][$uri] = $controller;
    }

    /**
     * 将定义的POST请求存入routes数组内
     * @param $uri
     * @param $controller
     */
    private function post($uri, $controller)
    {
        if (!array_key_exists('POST', self::$routes)) {
            self::$routes['POST'] = [];
        }
        self::$routes['POST'][$uri] = $controller;
    }

    /**
     * 加载路由文件
     * @param $routeFile
     * @return static
     */
    private function loadRoutes($routeFile)
    {
        $router = $this;
        require_once ROOT_PATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $routeFile;
        return $router;
    }

    private function catchRoute($requestMethod, $requestUri)
    {
        if (!array_key_exists($requestUri, self::$routes[$requestMethod])) {
            throw new Exception("NotFoundHttpException:{$requestUri}");
        }
        $mixed = explode('@', self::$routes[$requestMethod][$requestUri]);
        return $this->callAction($mixed[0], $mixed[1]);
    }

    private function callAction($controller, $method)
    {
        $controller = 'App\\Controllers\\' . $controller;
        if (in_array($controller, get_declared_classes())) {
            throw new Exception("NotFoundControllerException:{$controller}");
        }
        $controllerObject = new $controller();
        if (!method_exists($controllerObject, $method)) {
            throw new Exception("NotFoundMethodException:{$method}");
        }
        return $controllerObject->$method();
    }


    public static function run($routeFile, $requestMethod, $requestUri)
    {
        try {
            $router = new static;
            $router->loadRoutes($routeFile)->catchRoute($requestMethod, $requestUri);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}