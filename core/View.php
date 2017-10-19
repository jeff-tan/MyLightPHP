<?php
/**
 * Created by PhpStorm.
 * User: jefftan
 * Date: 17-8-25
 * Time: 下午1:33
 */

namespace Core;

use Philo\Blade\Blade;

class View
{
    const VIEW_PATH = ROOT_PATH . DIRECTORY_SEPARATOR . 'app/Views';
    const CACHE_PATH = ROOT_PATH . DIRECTORY_SEPARATOR . 'cache/view';

    public static function getView($name, $data = [])
    {
        if (!is_dir(self::CACHE_PATH)) {
            mkdir(self::CACHE_PATH, 0777, true);
        }
        $blade = new Blade(self::VIEW_PATH, self::CACHE_PATH);
        echo $blade->view()->make($name, $data)->render();
    }
}