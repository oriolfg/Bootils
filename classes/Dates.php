<?php
/**
 * Dates functions file
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
 * Convert a unix date to format in the regional current locales
 *
 * @param Int    $value  Unix date formated
 * @param String $format Custom locale format
 *
 * @return String
 */
function unix2locale($value, $format)
{
    $values=date('Y-m-d H:i:s', $value);
    $d=explode(' ', $values);
    $d1=explode('-', $d[0]);
    if (!isset($d[1])||$d[1] == '') {
        $d[1] = '00:00:00';
    }
    $d2 = explode(':', $d[1]);

    $mkd = mktime((int)$d2[0], (int)$d2[1], (int)$d2[2], (int)$d1[1], (int)$d1[2], (int)$d1[0]);
    $mes = strftime('%B', $mkd);
    $data = strftime($format, $mkd);
    // Correction for catalan language in ca_ES, ca_AD, ca_FR, ca_IT, & the future ca_CT
    if (($mes == 'agost') || ($mes == 'octubre') || ($mes == 'abril')) {
        $data = @strftime(str_replace('de %B', 'd\'%B', $format), $mkd);
    }

    return ucfirst($data);
}
/**
 * Return array of the current datetime in unix, human & object format
 *
 * @return Array
 */
function now()
{
    $date = date_create();
    $array = array(
        'unix' => date_timestamp_get($date),
        'human' => unix2locale(date_timestamp_get($date), null),
        'object' => $date
    );
    return $array;
}
