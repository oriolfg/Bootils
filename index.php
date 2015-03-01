 <?php 
// Require Bootils manually or with composer autoload
require_once 'Bootils.php';

// Start Bootils
$Bootils = new Bootils\Core();

// Configure values
$Bootils->setLocales('ca_ES.utf8,es_ES.utf8,en_EN.utf8');
$Bootils->setComaSeparator(',');
$Bootils->setThousendSeparator('.');
$Bootils->setDateFormat("%A, %d de %B de %Y");

// Use Bootils
echo $Bootils->unix2locale();
