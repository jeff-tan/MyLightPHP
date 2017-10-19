<?php
/**
 * Created by PhpStorm.
 * User: jefftan
 * Date: 17-8-21
 * Time: 下午1:36
 */

namespace Core\Database;

use PDO;
use PDOException;

class Connection
{
    private static $connection = null;

    public static function make(array $config)
    {
        $dsn = "{$config['drive']}:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";
        try {
            if (self::$connection == null) {
                self::$connection = new PDO($dsn, $config['username'], $config['password']);
            }
            return self::$connection;
        } catch (PDOException $e) {
            die ('SQL ERROR:' . $e->getMessage());
        }
    }

    private function __construct()
    {

    }

    private function __clone()
    {

    }

}