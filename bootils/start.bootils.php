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

ini_set("default_charset","utf-8");
header('Content-Type: text/html; charset=utf-8');

define( 'BOOTILS_DIR', dirname( __FILE__ ) . '/' );
require_once BOOTILS_DIR . 'config.bootils.php';

// define constants from config.bootils file
foreach($_bootils as $name => $value){
    eval('if(!defined("'.$name.'")){define( "'.$name.'", "'.$value.'" );}');    
}
unset($_bootils);
unset($name);
unset($value);
// Define default values
if(!defined("DEFAULT_LANGUAGE_LOCALE")){
    define( 'DEFAULT_LANGUAGE_LOCALE', 'en_GB' );
}
if(!defined("DEFAULT_DATE_FORMAT")){
    define( 'DEFAULT_DATE_FORMAT', '%A %d %B %Y' );
}
if(!defined("DEFAULT_COMA_SEPARATOR")){
    define( 'DEFAULT_COMA_SEPARATOR', '.' );
}
if(!defined("DEFAULT_THOUSAND_SEPARATOR")){
    define( 'DEFAULT_THOUSAND_SEPARATOR', ',' );
}

// require_once for kint debug class
if(defined("KINT") && KINT==true &&  file_exists(BOOTILS_DIR . 'third/kint/Kint.class.php')){
    require_once BOOTILS_DIR . 'third/kint/Kint.class.php';
}
unset($_kint_settings);
// require_once for phpmailer debug class
if(defined("SWIFTMAILER") && SWIFTMAILER==true &&  file_exists(BOOTILS_DIR . 'third/swift/swift_required.php')){
    require_once BOOTILS_DIR . 'third/swift/swift_required.php';
}
// configure error_reporting from config.bootils file
if(defined("ERROR_REPORTING") && ERROR_REPORTING==true){
    $tmp=array();
    if(defined("HIDE_ERROR") && HIDE_ERROR==true){$tmp[]='E_ERROR';}
    if(defined("HIDE_RECOVERABLE_ERROR") && HIDE_RECOVERABLE_ERROR==true){$tmp[]='E_RECOVERABLE_ERROR';}
    if(defined("HIDE_WARNING") && HIDE_WARNING==true){$tmp[]='E_WARNING';}
    if(defined("HIDE_PARSE") && HIDE_PARSE==true){$tmp[]='E_PARSE';}
    if(defined("HIDE_STRICT") && HIDE_STRICT==true){$tmp[]='E_STRICT';}
    if(defined("HIDE_NOTICE") && HIDE_NOTICE==true){$tmp[]='E_NOTICE';}
    if(defined("HIDE_DEPRECATED") && HIDE_DEPRECATED==true){$tmp[]='E_DEPRECATED';}
    if(defined("HIDE_USER_DEPRECATED") && HIDE_USER_DEPRECATED==true){$tmp[]='E_USER_DEPRECATED';}
    $tmp=implode('|',$tmp);
    if($tmp!=''){
        eval("error_reporting(E_ALL & ~(".$tmp."));");
    }else{
        eval("error_reporting(E_ALL);");
    }
}elseif(defined("ERROR_REPORTING") && ERROR_REPORTING==false){
        eval("error_reporting(0);");
}
// configure display_errors from config.bootils file
if(defined("DISPLAY_ERRORS") && DISPLAY_ERRORS==true){
    ini_set('display_errors', '1');
}

class Bootils
{
    public static function _init()
	{
            $tmp=opendir(BOOTILS_DIR.'functions/');
            while ($object = readdir($tmp))
            {
                if (strtolower(substr(strrchr($object, '.'),1))=='php')
                {
                    require_once BOOTILS_DIR.'functions/'.$object;
                }
            }
            unset($tmp);
            unset($object);
	}
}
$tmp=opendir(BOOTILS_DIR.'shortcuts/');
while ($object = readdir($tmp))
{
    if (strtolower(substr(strrchr($object, '.'),1))=='php')
    {
        require_once BOOTILS_DIR.'shortcuts/'.$object;
    }
}
unset($tmp);
unset($object);
Bootils::_init();
?>
