<?php
if ( !function_exists( 'getIP' ) ) {
    function getIP()
    {
        $class= new server();
        return $class->getIP();
    }
}
if ( !function_exists( 'noCache' ) ) {
    function noCache()
    {
        $class= new server();
        return $class->noCache();
    }
}
if ( !function_exists( 'redirect' ) ) {
    function redirect($value=null,$permanent=false)
    {
        $class= new server();
        return $class->redirect($value,$permanent);
    }
}
if ( !function_exists( 'userLanguage' ) ) {
    function userLanguage()
    {
        $class= new server();
        return $class->userLanguage();
    }
}
?>
