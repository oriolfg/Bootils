<?php
if (!function_exists('getIP')) {
    function getIP()
    {
        $class= new Bootils\Server();
        return $class->getIP();
    }
}
if (!function_exists('noCache')) {
    function noCache()
    {
        $class= new Bootils\Server();
        return $class->noCache();
    }
}
if (!function_exists('redirect')) {
    function redirect($value = null, $permanent = false)
    {
        $class= new Bootils\Server();
        return $class->redirect($value, $permanent);
    }
}
if (!function_exists('userLanguage')) {
    function userLanguage()
    {
        $class= new Bootils\Server();
        return $class->userLanguage();
    }
}
if (!function_exists('defineLocale')) {
    function defineLocale($value = null)
    {
        $class= new Bootils\Server();
        return $class->defineLocale($value);
    }
}
