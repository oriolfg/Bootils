<?php
/**
 * Server functions file
 *
 * PHP version 5
 *
 * @category Core
 * @package  Bootils
 * @author   Oriol Ferràndez Grau github.com/oriolfg <oriol@ferrandez.cat>
 * @license  Licensed under the MIT License http://opensource.org/licenses/MIT
 * @link     https://oriolfg.github.io/Bootils/
 */
namespace Bootils;

/**
 * Define locale
 *
 * @param String $value New value to set
 *
 * @return String
 */
function defineLocale($value)
{
    $locale = setlocale(LC_ALL, explode(',', $value));
    putenv('LC_ALL = ' . $value);
    return $locale;
}
/**
 * Add php headers to disable cache.
 *
 * @return Nothing
 */
function disableCache()
{
    header('Expires: Tue, 13 Mar 1979 18:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');
}
/**
 * Adding php header location for create redirects.
 *
 * @param String  $value     Url to redirect
 * @param Boolean $permanent Set tru to use 301 permanent redirection
 *
 * @return Nothing
 */
function redirect($value, $permanent)
{
    if ($permanent == true) {
        header('HTTP/1.1 301 Moved Permanently');
    }
    header('Location: ' . checkLink($value));
}
