<?php
if ( !function_exists( 'checkMail' ) ) {
    function checkMail($value = null)
    {
        $class= new email();
        return $class->checkMail($value);
    }
}
if ( !function_exists( 'encodeMail' ) ) {
    function encodeMail($value = null)
    {
        $class= new email();
        return $class->encodeMail($value);
    }
}
if ( !function_exists( 'encodeMailString' ) ) {
    function encodeMailString($value = null)
    {
        $class= new email();
        return $class->encodeMailString($value);
    }
}
if ( !function_exists( 'fastMail' ) ) {
    function fastMail($to=null,$subject = null, $body = null, $extras=array())
    {
        if($to==null || $subject == null || $body == null){
            return false;
        }
        if(defined("SWIFTMAILER") && SWIFTMAILER==true){
            $class= new email();
            return $class->swiftMail($to,$subject,$body,$extras);
        }else{
            $class= new email();
            return $class->phpMail($to,$subject,$body,$extras);
        }
    }
}
?>
