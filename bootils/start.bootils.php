<?php

ini_set("default_charset","utf-8");
header('Content-Type: text/html; charset=utf-8');

define( 'BOOTILS_DIR', dirname( __FILE__ ) . '/' );
require_once BOOTILS_DIR . 'config.bootils.php';

// define constants from config.bootils file
foreach($_bootils as $name => $value){
    eval('if(!defined("'.$name.'")){define( "'.$name.'", "'.$value.'" );}');    
}
// Define default values
if(!defined("LANGUAGE_LOCALE")){
    define( 'LANGUAGE_LOCALE', 'en_GB' );
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
// require_once for phpmailer debug class
if(defined("SWIFTMAILER") && SWIFTMAILER==true &&  file_exists(BOOTILS_DIR . 'third/swift/swift_required.php')){
    require_once BOOTILS_DIR . 'third/swift/swift_required.php';
}
// configure locales from config.bootils file
$installed_locales = @shell_exec('locale -a');
if(is_array($installed_locales)){
    $installed_locales = explode("\n" , $installed_locales);
}else{
    $installed_locales= array();
}
if(defined("LANGUAGE_LOCALE")&&in_array(LANGUAGE_LOCALE, $installed_locales)){
   setlocale(LC_ALL, LANGUAGE_LOCALE); 
}elseif(defined("LANGUAGE_LOCALE")){
    setlocale(LC_ALL, LANGUAGE_LOCALE.'.utf8'); 
}
// configure error_reporting from config.bootils file
if(defined("ERROR_REPORTING") && ERROR_REPORTING==true){
    $disable=array();
    if(defined("HIDE_ERROR") && HIDE_ERROR==true){$disable[]='E_ERROR';}
    if(defined("HIDE_RECOVERABLE_ERROR") && HIDE_RECOVERABLE_ERROR==true){$disable[]='E_RECOVERABLE_ERROR';}
    if(defined("HIDE_WARNING") && HIDE_WARNING==true){$disable[]='E_WARNING';}
    if(defined("HIDE_PARSE") && HIDE_PARSE==true){$disable[]='E_PARSE';}
    if(defined("HIDE_STRICT") && HIDE_STRICT==true){$disable[]='E_STRICT';}
    if(defined("HIDE_NOTICE") && HIDE_NOTICE==true){$disable[]='E_NOTICE';}
    if(defined("HIDE_DEPRECATED") && HIDE_DEPRECATED==true){$disable[]='E_DEPRECATED';}
    if(defined("HIDE_USER_DEPRECATED") && HIDE_USER_DEPRECATED==true){$disable[]='E_USER_DEPRECATED';}
    $disable=implode('|',$disable);
    if($disable!=''){
        eval("error_reporting(E_ALL & ~(".$disable."));");
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
            $dir=opendir(BOOTILS_DIR.'functions/');
            while ($object = readdir($dir))
            {
                if (strtolower(substr(strrchr($object, '.'),1))=='php')
                {
                    require_once BOOTILS_DIR.'functions/'.$object;
                }
            }
	}
}
$dir=opendir(BOOTILS_DIR.'shortcuts/');
while ($object = readdir($dir))
{
    if (strtolower(substr(strrchr($object, '.'),1))=='php')
    {
        require_once BOOTILS_DIR.'shortcuts/'.$object;
    }
}

Bootils::_init();
?>