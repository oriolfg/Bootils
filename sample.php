 <?php 
require_once 'Bootils.php';

// Start Bootils
$bootils = new Bootils\Core();

// Change default bootils values to our custom configuration
$bootils->setLocales('ca_ES.utf8,es_ES.utf8,en_EN.utf8');
$bootils->setComaSeparator(',');
$bootils->setThousendSeparator('.');
$bootils->setDateFormat("%A, %d de %B de %Y");

// Using Bootils
echo $bootils->unix2locale(strtotime('01-01-2000'));
echo '<hr>';
echo $bootils->size2size(1, 'GB', 'MB');