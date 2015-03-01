<?php
/**
 * Bootils Start file
 *
 * Just do a require_once this file so that bootils do the rest for you, totally unaware of the internal routes, it will work automatically.
 *
 * Bootils version 1.0
 *
 * LICENSE: Read the LICENSE atached file in original package
 *
 * @category   Utilities for Web Developers
 * @package    Bootils
 * @author     Oriol Ferràndez Grau <oriolet@oriolet.com>
 * @version    1.0
 * @link       http://bootils.oriolet.com
 */

ini_set("default_charset", "utf-8");
header('Content-Type: text/html; charset=utf-8');
define('BOOTILS_DIR', dirname(__FILE__).'/');


require_once BOOTILS_DIR . 'classes/Arrays.php';
require_once BOOTILS_DIR . 'classes/User.php';
require_once BOOTILS_DIR . 'classes/Server.php';
require_once BOOTILS_DIR . 'classes/Strings.php';
require_once BOOTILS_DIR . 'classes/Files.php';
require_once BOOTILS_DIR . 'classes/Emails.php';

require_once BOOTILS_DIR . 'classes/Core.php';
require_once BOOTILS_DIR . 'classes/Dates.php';
