<?php
if ( !function_exists( 'asciQuotes' ) ) {
    function asciQuotes($value = null)
    { 
        $class= new string();
        return $class->asciQuotes($value);
    }
}
if ( !function_exists( 'smartQuotes' ) ) {
    function smartQuotes($value = null)
    {
        $class= new string();
        return $class->smartQuotes($value);
    }
}
if ( !function_exists( 'string2url' ) ) {
    function string2url($value = null)
    {
        $class= new string();
        return $class->string2url($value);
    }
}
if ( !function_exists( 'cut' ) ) {
    function cut($value = null,$size = null,$ellipsis = true)
    {
        $class= new string();
        return $class->cut($value,$size,$ellipsis);
    }
}
if ( !function_exists( 'checkLink' ) ) {
    function checkLink($value = null,$protocol = 'http://')
    {
        $class= new string();
        return $class->checkLink($value,$protocol);
    }
}
if ( !function_exists( 'html2txt' ) ) {
    function html2txt($value = null)
    {
        $class= new string();
        return $class->html2txt($value);
    }
}
?>
