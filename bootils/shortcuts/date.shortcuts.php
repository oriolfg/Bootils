<?php
if ( !function_exists( 'unix2locale' ) ) {
    function unix2locale($value= null,$format=DEFAULT_DATE_FORMAT)
    {
        $class= new date();
        return $class->unix2locale($value,$format);
    }
}
if ( !function_exists( 'now' ) ) {
    function now()
    {
        $class= new date();
        return $class->now();
    }
}
?>
