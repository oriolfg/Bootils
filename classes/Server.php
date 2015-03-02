<?php
namespace Bootils;

function defineLocale($value)
{
    $locale = setlocale(LC_ALL, explode(',', $value));
    putenv("LC_ALL=$value");
    return $locale;
}
function disableCache()
{
    header('Expires: Tue, 13 Mar 1979 18:00:00 GMT');
    header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');
}
function redirect($value, $permanent)
{
    if ($permanent==true) {
        header('HTTP/1.1 301 Moved Permanently');
    }
    header('Location: '.checkLink($value));
    exit;
}
