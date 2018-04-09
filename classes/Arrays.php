<?php
/**
 * Array functions file
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
 * Sort an multidimensional array based on a specific key
 *
 * @param Array   $value   Array to modify
 * @param String  $field   Name of field
 * @param Boolean $inverse Set true for invert order to DESC
 *
 * @return Array
 */
function sortByField($value, $field, $inverse = false)
{
    $position = array();
    $newRow = array();
    if ($value) {
        foreach ($value as $key => $row) {
                $position[$key]  = $row[$field];
                $newRow[$key] = $row;
        }
    }
    if ($inverse) {
        arsort($position);
    } else {
        asort($position);
    }
    $returnArray = array();
    foreach ($position as $key => $pos) {
        $returnArray[] = $newRow[$key];
    }
    return $returnArray;
}
