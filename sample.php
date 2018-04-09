<?php
/**
 * Bootils Sample file
 *
 * Just do a require, configure & use it.
 *
 * PHP version 5
 *
 * LICENSE: Read the LICENSE atached file in original package
 *
 * @category Bootstrap_File
 * @package  Bootils
 * @author   Oriol Ferràndez Grau github.com/oriolfg <oriol@ferrandez.cat>
 * @license  Licensed under the MIT License http://opensource.org/licenses/MIT
 * @link     http://oriolet.github.io/Bootils/
 */
require_once 'Bootils.php';

/**
 *  Initialization sample
 */
$bootils = new Bootils\Core();

/**
 *  Configuration sample
 */
$bootils->setLocales('ca_ES.utf8,es_ES.utf8,en_EN.utf8');
$bootils->setComaSeparator(',');
$bootils->setThousandSeparator('.');
$bootils->setDateFormat("%A, %d de %B de %Y");

/*
 * Usage sample
 */
echo $bootils->unix2locale(strtotime('01-01-2000'));
echo '<hr>';
echo $bootils->size2size(1, 'GB', 'MB');
