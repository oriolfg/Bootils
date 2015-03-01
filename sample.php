 <?php 
require_once 'Bootils.php';
//require_once BOOTILS_DIR . 'classes/third/kint/Kint.class.php';
//require_once BOOTILS_DIR . 'classes/third/swift/swift_required.php';
//require_once BOOTILS_DIR . 'classes/third/PHPMailer-master/PHPMailerAutoload.php';


$Bootils = new Bootils\Core();

$Bootils->setDebug(true);
$Bootils->setLocales('ca_ES.utf8,es_ES.utf8,en_EN.utf8');
$Bootils->setComaSeparator(',');
$Bootils->setThousendSeparator('.');
$Bootils->setDateFormat("'%A, %d de %B de %Y'");
