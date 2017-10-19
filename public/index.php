<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

defined('PUBLIC_PATH') or define('PUBLIC_PATH', dirname(__FILE__));

defined('ROOT_PATH') or define('ROOT_PATH',dirname(PUBLIC_PATH));

require_once ROOT_PATH . DIRECTORY_SEPARATOR . 'core/bootstrap.php';

\Core\Request::run();
\Core\Router::run('routes.php',\Core\Request::method(),\Core\Request::uri());






