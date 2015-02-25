<?php
if (!function_exists('sortField')) {
    function sortField($value = null, $field = null, $invert = false)
    {
        $class= new Bootils\Arrays();
        return $class->sortField($value, $field, $invert);
    }
}
