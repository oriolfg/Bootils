<?php
// init bootils
require_once 'start.bootils.php';

// If your site is multilanguage, put here the function to define locales
$current_locale='ca_ES.utf8,es_ES.utf8,en_EN.utf8';

// And now you can configure the locale language with the bootils shortcut function
$current_defined_locale=defineLocale($current_locale);

// Sampe of unix2locale() function
echo '<b>Current locale:</b><br><i>'.$current_defined_locale.'</i><br>';
echo '<br>';
echo '<b>Current date:</b><br><i>'.unix2locale().'</i><br>';

//And now you can continue building your app or site using the bootils library functions!!
?>