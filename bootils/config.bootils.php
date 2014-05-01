<?php

/**
 * Bootils Configuration file
 *
 * Modify the options according to your needs
 *
 */

// REGIONAL CONFIGURATION
$_bootils['LANGUAGE_LOCALE'] = 'ca_ES';// Default value is en_GB
$_bootils['DEFAULT_DATE_FORMAT'] = '%A, %e de %B de %Y';// Default value is %A %d %B %
$_bootils['DEFAULT_COMA_SEPARATOR'] = ',';// Default value is .
$_bootils['DEFAULT_THOUSAND_SEPARATOR'] = '.';// Default value is ,

// KINT 
// Tired of var_dump()? active KINT and enjoy with s() or d() functions.
$_bootils['KINT'] = true;// Don't like KINT?, you are free to delete the third/kint folder to save space

// SWIFTMAILER
$_bootils['SWIFTMAILER'] = true;// Don't like SWIFT MAILER?, you are free to delete the third/swift folder to save space

// GENERAL MAIL OPTIONS
$_bootils['MAIL_CHARSET']='UTF-8';// Default value is UTF-8
$_bootils['MAIL_CHARSET_PLAIN']='UTF-8';// Default value is UTF-8
$_bootils['MAIL_CHARSET_HTML']='UTF-8';// Default value is UTF-8
$_bootils['MAIL_SENDER_MAIL']="sample@remitent.mail";// Default value is blank
$_bootils['MAIL_SENDER_NAME']="Name of remitent";// Default value is blank

// SMTP MAIL OPTION (works only if SWIFTMAILES IS ENABLED)
$_bootils['SMTP_HOST']="84.20.14.216";// Default value is localhost
$_bootils['SMTP_USER']="butlleti@visiteucaldes.cat";// Default value is blank
$_bootils['SMTP_PASSWORD']="bu04ti";// Default value is blank
$_bootils['SMTP_PORT']=25;// Default value is 25

$_bootils['SMTP_ANTIFLOOD']=true;// For massive sending (default true)
$_bootils['SMTP_ANTIFLOOD_MAILS']=100;// number of emails between breaks (default 100)
$_bootils['SMTP_ANTIFLOOD_PAUSE']=30;// Seconds-long break before continuing (default 30)

// ERRORS CONFIGURATION
$_bootils['ERROR_REPORTING']=true;

$_bootils['HIDE_ERROR'] = true;
$_bootils['HIDE_RECOVERABLE_ERROR'] = true;
$_bootils['HIDE_WARNING'] = true;
$_bootils['HIDE_PARSE'] = true;
$_bootils['HIDE_STRICT'] = true;
$_bootils['HIDE_NOTICE'] = true;
$_bootils['HIDE_USER_DEPRECATED'] = true;
$_bootils['HIDE_DEPRECATED'] = true;

$_bootils['DISPLAY_ERRORS']=true; //To see the errors on the web or only in log files
?>
