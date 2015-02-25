<?php

if (!function_exists('getTime')) {
    function getTime($value = null)
    {
        $class= new Bootils\Files();
        return $class->getTime($value);
    }
}

if (!function_exists('getPermissions')) {
    function getPermissions($value = null)
    {
        $class= new Bootils\Files();
        return $class->getPermissions($value);
    }
}

if (!function_exists('dir2array')) {
    function dir2array($value = null, $content = false)
    {
        $class= new Bootils\Files();
        return $class->dir2array($value, $content);
    }
}

if (!function_exists('getMime')) {
    function getMime($value = null)
    {
        $class= new Bootils\Files();
        return $class->getMime($value);
    }
}

if (!function_exists('file2base64')) {
    function file2base64($value = null)
    {
        $class= new Bootils\Files();
        return $class->file2base64($value);
    }
}

if (!function_exists('getExtension')) {
    function getExtension($value = null)
    {
        $class= new Bootils\Files();
        return $class->getExtension($value);
    }
}

if (!function_exists('size2size')) {
    function size2size($value = null, $from = 'B', $to = 'MB', $decimals = 2)
    {
        $class= new Bootils\Files();
        return $class->size2size($value, $from, $to, $decimals);
    }
}
if (!function_exists('fileHash')) {
    function fileHash($value = null)
    {
        $class= new Bootils\Files();
        return $class->fileHash($value);
    }
}
