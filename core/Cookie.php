<?php
/**
 * Created by PhpStorm.
 * User: jefftan
 * Date: 17-8-25
 * Time: 下午2:30
 */

namespace Core;

class Cookie
{
    public function get($name)
    {
        if(is_array($name)){
            $result = [];
            foreach ($name as $value){
                $result[] = self::get($value);
            }
            return $result;
        }
        return isset($_COOKIE[$name])?$_COOKIE[$name]:null;
    }

    public function make($name, $value, $expire = 0, $path = '/', $domain = '', $secure = false, $httponly = false)
    {
        if (!is_numeric($expire) || $expire < 0) {
            $expire = 0;
        } else {
            $expire = ($expire > 0) ? time() + $expire : 0;
        }
        if($path==='/' && Application::get('config')['cookie']['path']!=='/')
            $path = Application::get('config')['cookie']['path'];
        if($domain==='' && Application::get('config')['cookie']['domain']!=='')
            $domain = Application::get('config')['cookie']['domain'];
        if($secure===false && Application::get('config')['cookie']['secure']!==false)
            $secure = (bool)Application::get('config')['cookie']['secure'];
        if($httponly===false && Application::get('config')['cookie']['httponly']!==false)
            $httponly = (bool)Application::get('config')['cookie']['httponly'];
        return setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
    }

    public function forget($name)
    {
        return setcookie($name,'',time()-3600);
    }
}