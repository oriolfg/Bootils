<?php
namespace Bootils;

class Core
{
    // Debug values
    public $debug = false;
    // Regional values
    public $locales = "en_GB.utf8";
    public $date_format = "'%A %d %B %Y'";
    public $thousand_separator = ",";
    public $coma_separator = ".";
    // User values
    public $user_ip = "";
    public $user_languages = "";
    // Error values
    public $display_errors = true;
    public $error_reporting = true;
    public $e_error = true;
    public $e_recoverable_error = true;
    public $e_warning = true;
    public $e_parse = true;
    public $e_strict = true;
    public $e_notice = true;
    public $e_deprecated = true;
    public $e_user_deprecated = true;
    // Mail general values
    public $mail_charset = 'UTF-8';
    public $mail_charset_plain = 'UTF-8';
    public $mail_charset_html = 'UTF-8';
    public $mail_sender_mail = 'bootils@sample.org';
    public $mail_sender_name = false;
    public $mail_reply_to_mail = 'bootils@sample.org';
    public $mail_reply_to_name = false;
    // Mail SMTP values (if use swiftmailer or similar library)
    public $smtp_host = "localhost";
    public $smtp_protocol = "tls";
    public $smpt_user = false;
    public $smtp_password = false;
    public $smtp_port = 25;
    // Mail Antiflood values
    public $smtp_antiflood = true; // For massive sending
    public $smtp_antiflood_mails = 100; // number of emails between breaks
    public $smtp_antiflood_pause = 30; // Seconds-long break before continuing


    public function __construct()
    {
        $this->debug('The class "'.__CLASS__.'" was started!');
        /*
        * Check & Set user languages preferences
        */
        $this->setUserLanguages();
        /*
        * Check & Set real user IP
        */
        $this->setUserIp();
        /*
        * Define initial default errors to show all errors
        */
        $this->phpErrors();
    }
    public function __destruct()
    {
        $this->debug($this);
        $this->debug('The class "'.__CLASS__.'" was destroyed.');
    }
    /*
    * Debug
    */
    // set & get pubic $debug
    public function setDebug($newval)
    {
        $this->debug = $newval;
        $this->debug('$debug was defined as '.$newval);
    }
     
    public function getDebug()
    {
        return $this->debug;
    }
    // debug
    public function debug($msg)
    {
        if ($this->debug) {
            $this->msg($msg);
        }
    }
    public function msg($msg)
    {
        if (function_exists('s')) {
            s($msg);
        } elseif (!is_string($msg)) {
            echo '<hr>';
            var_dump($msg);
            echo '<hr>';
        } else {
            echo '<hr>'.$msg.'<hr>';
        }
    }
    /*
    * Server
    */
    // set & get pubic $locales
    public function setLocales($newval)
    {
        $this->locales = defineLocale($newval);
        $this->debug('$locales was defined as '.$newval);
    }
    public function getLocales()
    {
        return $this->locales;
    }
    public function disableCache()
    {
        return disableCache();
    }
    public function redirect($url, $permanent = false)
    {
        return redirect($url, $permanent);
    }
    /*
    * Regional
    */
    // set & get pubic $date_format
    public function setDateFormat($newval)
    {
        $this->date_format = $newval;
        $this->debug('$date_format was defined as '.$newval);
    }
    public function getDateFormat()
    {
        return $this->date_format;
    }
    // set & get pubic $coma_separator
    public function setComaSeparator($newval)
    {
        $this->coma_separator = $newval;
        $this->debug('$coma_separator was defined as '.$newval);
    }
    public function getComaSeparator()
    {
        return $this->coma_separator;
    }
    // set & get pubic $thousend_separator
    public function setThousendSeparator($newval)
    {
        $this->thousand_separator = $newval;
        $this->debug('$thousand_separator was defined as'.$newval);
    }
    public function getThousendSeparator()
    {
        return $this->thousand_separator;
    }
    /*
    * User
    */
    // set & get pubic $user_languages
    public function setUserLanguages()
    {
        $this->user_languages = getLanguages();
        $this->debug('$user_languages was defined');
    }
    public function getUserLanguages()
    {
        return $this->user_languages;
    }
    // set & get pubic $user_ip
    public function setUserIp()
    {
        $this->user_ip = getIp();
        $this->debug('$userIp was defined as '.$this->user_ip);
    }
    public function getUserIp()
    {
        return $this->userIp;
    }
    /*
    * Date
    */
    // Convert unix date to regional format
    public function unix2locale($date = null, $format = null)
    {
        if (empty($date)) {
            $date=time();
        }
        if (empty($format)) {
            $format=$this->date_format;
        }
        return unix2locale($date, $format);
    }
    // Get current date in various formats
    public function now()
    {
        $server = new Dates;
        return $server->now();
    }
    /*
    * Errror
    */
    public function getPhpErrors()
    {
        $errors = new \stdClass();
        $errors->display_errors = $this->display_errors;
        $errors->error_reporting = $this->error_reporting;
        $errors->e_error = $this->e_error;
        $errors->e_recoverable_error = $this->e_recoverable_error;
        $errors->e_warning = $this->e_warning;
        $errors->e_parse = $this->e_parse;
        $errors->e_strict = $this->e_strict;
        $errors->e_notice = $this->e_notice;
        $errors->e_deprecated = $this->e_deprecated;
        $errors->e_user_deprecated = $this->e_user_deprecated;
        return $errors;
    }
    public function displayErrors($value = false)
    {
        $this->display_errors=$value;
        $this->phpErrors();
    }
    public function errorReporting($value = false)
    {
        $this->error_reporting=$value;
        $this->phpErrors();
    }
    public function eError($value = true)
    {
        $this->e_error=$value;
        $this->phpErrors();
    }
    public function eRecoverableError($value = true)
    {
        $this->e_recoverable_error=$value;
        $this->phpErrors();
    }
    public function eWarning($value = true)
    {
        $this->e_warning=$value;
        $this->phpErrors();
    }
    public function eParse($value = true)
    {
        $this->e_parse=$value;
        $this->phpErrors();
    }
    public function eStrict($value = true)
    {
        $this->e_strict=$value;
        $this->phpErrors();
    }
    public function eNotice($value = false)
    {
        $this->e_notice=$value;
        $this->phpErrors();
    }
    public function eDeprecated($value = true)
    {
        $this->e_deprecated=$value;
        $this->phpErrors();
    }
    public function eUserDeprecated($value = true)
    {
        $this->e_user_deprecated=$value;
        $this->phpErrors();
    }
    public function phpErrors()
    {
        if ($this->display_errors) {
            ini_set('display_errors', 1);
            if ($this->error_reporting) {
                $tmp=array();
                if ($this->e_error == false) {
                    s('sdfsdf');
                    $tmp[]='E_ERROR';
                }
                if (!$this->e_recoverable_error) {
                    $tmp[]='E_RECOVERABLE_ERROR';
                }
                if (!$this->e_warning) {
                    $tmp[]='E_WARNING';
                }
                if (!$this->e_parse) {
                    $tmp[]='E_PARSE';
                }
                if (!$this->e_strict) {
                    $tmp[]='E_STRICT';
                }
                if (!$this->e_notice) {
                    $tmp[]='E_NOTICE';
                }
                if (!$this->e_deprecated) {
                    $tmp[]='E_DEPRECATED';
                }
                if (!$this->e_user_deprecated) {
                    $tmp[]='E_USER_DEPRECATED';
                }
                $tmp=implode('|', $tmp);
                if ($tmp!='') {
                    eval("error_reporting(E_ALL & ~(".$tmp."));");
                } else {
                    eval("error_reporting(E_ALL);");
                }
            }
        } else {
            ini_set('display_errors', 0);
            error_reporting(0);
        }
    }

    /*
    * Arrays
    */
    public function sortByField($array = array(), $field = null, $inverse = false)
    {
        return Arrays::sortByField($array, $field, $inverse);
    }

    /*
    * Strings
    */
    // Check if link have protocol
    public function checkLink($value, $protocol = 'http://')
    {
        return checkLink($value, $protocol);
    }
    // Convert asci quotes
    public function asciQuotes($string)
    {
        return asciQuotes($string);
    }
    // Convert smart quotes
    public function smartQuotes($string)
    {
        return smartQuotes($string);
    }
    // Convert string to friendly url
    public function string2url($string)
    {
        return string2url($string);
    }
    // Cut string length without cut the words
    public function cut($string, $size = 100, $ellipsis = true)
    {
        return string2url($string, $size, $ellipsis);
    }
    // Convert strint text to plain text
    public function html2txt($string)
    {
        return html2txt($string);
    }

    /*
    * Files
    */
    // Check if link have protocol
    public function dir2array($dir, $content = false)
    {
        return dir2array($dir, $content);
    }
    // get base64 file info
    public function file2base64($file)
    {
        return file2base64($file);
    }
    // get mime of image
    public function getMime($file = null)
    {
        return getMime($file);
    }
    // get time
    public function getTime($file = null)
    {
        return getTime($file);
    }
    // get permisions
    public function getPermissions($file = null)
    {
        return getPermissions($file);
    }
    // Returns the extension of a file in string value.
    public function getExtension($file = null)
    {
        return getExtension($file);
    }
    // Convert size value
    public function size2size($value = null, $from = 'B', $to = 'MB', $decimals = 2)
    {
        return size2size($value, $from, $to, $decimals, $this->coma_separator, $this->thousand_separator);
    }
    // Returns base65 of sha1 of file
    public function fileHash($file)
    {
        return fileHash($file);
    }

    /*
    * Emails
    */
    // Check format mail

    // set & get public $mail_charset
    public function setMailCharset($newval)
    {
        $this->mail_charset = $newval;
        $this->debug('$mail_charset was defined as '.$newval);
    }
    public function getMailCharset()
    {
        return $this->mail_charset;
    }
    // set & get public $mail_charset_plain
    public function setMailCharsetPlain($newval)
    {
        $this->mail_charset_plain = $newval;
        $this->debug('$mail_charset_plain was defined as '.$newval);
    }
    public function getMailCharsetPlain()
    {
        return $this->mail_charset_plain;
    }
    // set & get public $mail_charset_html
    public function setMailCharsetHtml($newval)
    {
        $this->mail_charset_html = $newval;
        $this->debug('$mail_charset_html was defined as '.$newval);
    }
    public function getMailCharsetHtml()
    {
        return $this->mail_charset_html;
    }
    // set & get public $mail_sender_mail
    public function setMailSenderMail($newval)
    {
        $this->mail_sender_mail = $newval;
        $this->debug('$mail_sender_mail was defined as '.$newval);
    }
    public function getMailSenderMail()
    {
        return $this->mail_sender_mail;
    }
    // set & get public $mail_reply_to_mail
    public function setMailReplyToMail($newval)
    {
        $this->mail_reply_to_mail = $newval;
        $this->debug('$mail_reply_to_mail was defined as '.$newval);
    }
    public function getMailReplyToMail()
    {
        return $this->mail_reply_to_mail;
    }
    // set & get public $mail_reply_to_name
    public function setMailReplyToName($newval)
    {
        $this->mail_reply_to_name = $newval;
        $this->debug('$mail_reply_to_name was defined as '.$newval);
    }
    public function getMailReplyToName()
    {
        return $this->mail_reply_to_name;
    }
    // set & get public $mail_sender_name
    public function setMailSenderName($newval)
    {
        $this->mail_sender_name = $newval;
        $this->debug('$mail_sender_name was defined as '.$newval);
    }
    public function getMailSenderName()
    {
        return $this->mail_sender_name;
    }
    // set & get public $smtp_host
    public function setSmtpHost($newval)
    {
        $this->smtp_host = $newval;
        $this->debug('$smtp_host was defined as '.$newval);
    }
    public function getSmtpHost()
    {
        return $this->smtp_host;
    }
    // set & get public $smtp_protocol
    public function setSmtpProtocol($newval)
    {
        $this->smtp_protocol = $newval;
        $this->debug('$smtp_protocol was defined as '.$newval);
    }
    public function getSmtpProtocol()
    {
        return $this->smtp_protocol;
    }
    // set & get public $smpt_user
    public function setSmtpUser($newval)
    {
        $this->smpt_user = $newval;
        $this->debug('$smpt_user was defined as '.$newval);
    }
    public function getSmtpUser()
    {
        return $this->smpt_user;
    }
    // set & get public $smtp_password
    public function setSmtpPassword($newval)
    {
        $this->smtp_password = $newval;
        $this->debug('$smtp_password was defined as '.$newval);
    }
    public function getSmtpPassword()
    {
        return $this->smtp_password;
    }
    // set & get public $smtp_port
    public function setSmtpPort($newval)
    {
        $this->smtp_port = $newval;
        $this->debug('$smtp_port was defined as '.$newval);
    }
    public function getSmtpPort()
    {
        return $this->smtp_port;
    }
    // set & get public $smtp_antiflood
    public function setSmtpAntiflood($newval)
    {
        $this->smtp_antiflood = $newval;
        $this->debug('$smtp_antiflood was defined as '.$newval);
    }
    public function getSmtpAntiflood()
    {
        return $this->smtp_antiflood;
    }
    // set & get public $smtp_antiflood_mails
    public function setSmtpAntifloodMails($newval)
    {
        $this->smtp_antiflood_mails = $newval;
        $this->debug('$smtp_antiflood_mails was defined as '.$newval);
    }
    public function getSmtpAntifloodMails()
    {
        return $this->smtp_antiflood_mails;
    }
    public function getAllMailValues()
    {
        $object = new \stdClass();
        $object->mail_charset = $this->mail_charset;
        $object->mail_charset_plain = $this->mail_charset_plain;
        $object->mail_charset_html = $this->mail_charset_html;
        $object->mail_sender_mail = $this->mail_sender_mail;
        $object->mail_sender_name = $this->mail_sender_name;
        $object->smtp_host = $this->smtp_host;
        $object->smtp_protocol = $this->smtp_protocol;
        $object->smpt_user = $this->smpt_user;
        $object->smtp_password = $this->smtp_password;
        $object->smtp_port = $this->smtp_port;
        $object->smtp_antiflood = $this->smtp_antiflood;
        $object->smtp_antiflood_mails = $this->smtp_antiflood_mails;
        $object->smtp_antiflood_pause = $this->smtp_antiflood_pause;
        $object->mail_reply_to_mail = $this->mail_reply_to_mail;
        $object->mail_reply_to_name = $this->mail_reply_to_name;
        return $object;
    }
    // set & get public $smtp_antiflood_pause
    public function checkMail ($value)
    {
        return checkMail($value);
    }
    // Encode mail to ASCI chars
    public function encodeMail ($value)
    {
        return encodeMail($value);
    }
    // Encode mails inner string to ASCI chars
    public function encodeMailString ($value)
    {
        return encodeMailString($value);
    }
    // Send mil using Swift, phpmailer or php function
    public function fastMail($to = null, $subject = null, $body = null, $extras = array())
    {
        if ($to==null || $subject == null || $body == null) {
            return false;
        }
        if (class_exists('Swift_SmtpTransport') && $this->smpt_user!=false && $this->smtp_password!=false) {
            return swiftMail($to, $subject, $body, $extras, $this->getAllMailValues());
        } else if (class_exists('PHPMailer') && $this->smpt_user!=false && $this->smtp_password!=false) {
            return phpMailer($to, $subject, $body, $extras, $this->getAllMailValues());
        } else {
            return phpMail($to, $subject, $body, $extras, $this->getAllMailValues());
        }
    }
}
