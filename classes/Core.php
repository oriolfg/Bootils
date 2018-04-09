<?php
/**
 * Bootils Core file
 *
 * PHP version 5
 *
 * @category Core
 * @package  Bootils
 * @author   Oriol Ferràndez Grau github.com/oriolfg <oriol@ferrandez.cat>
 * @license  Licensed under the MIT License http://opensource.org/licenses/MIT
 * @link     https://oriolfg.github.io/Bootils/
 */
namespace Bootils;

/**
 * Bootils Core class
 *
 * @category Core
 * @package  Bootils
 * @author   Oriol Ferràndez Grau github.com/oriolfg <oriol@ferrandez.cat>
 * @license  Licensed under the MIT License http://opensource.org/licenses/MIT
 * @link     https://oriolfg.github.io/Bootils/
 */
class Core
{
    // Debug values
    public $debug = false;
    // Regional values
    public $locales = "en_GB.utf8";
    public $date_format = "%A %d %B %Y";
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


    /**
     * Construct
     */
    public function __construct()
    {
        $this->debug('The class "' . __CLASS__ . '" was started!');
        $this->setUserLanguages();
        $this->setUserIp();
        $this->phpErrors();
    }
    /**
     * Destruct
     */
    public function __destruct()
    {
        $this->debug($this);
        $this->debug('The class "' . __CLASS__ . '" was destroyed.');
    }
    /**
     * Set debug parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function setDebug($value)
    {
        $this->debug = $value;
        $this->debug('$debug was defined as ' . $value);
    }
    /**
     * Get debug parameter
     *
     * @return String
     */
    public function getDebug()
    {
        return $this->debug;
    }
    /**
     * Debug
     *
     * @param String $msg Message to show
     *
     * @return Nothing
     */
    public function debug($msg)
    {
        if ($this->debug) {
            $this->msg($msg);
        }
    }
    /**
     * Msg show
     *
     * @param String $msg Message to show
     *
     * @return Print
     */
    public function msg($msg)
    {
        if (function_exists('s')) {
            s($msg);
        } elseif (!is_string($msg)) {
            echo '<hr>';
            var_dump($msg);
            echo '<hr>';
        } else {
            echo '<hr>' . $msg.'<hr>';
        }
    }
    /**
     * Set locales parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function setLocales($value)
    {
        $this->locales = defineLocale($value);
        $this->debug('$locales was defined as ' . $value);
    }
    /**
     * Get locales parameter
     *
     * @return String
     */
    public function getLocales()
    {
        return $this->locales;
    }
    /**
     * Add php headers to disable cache.
     *
     * @return Nothing
     */
    public function disableCache()
    {
        disableCache();
    }
    /**
     * Adding php header location for create redirects.
     *
     * @param String  $url       Url to redirect
     * @param Boolean $permanent Set tru to use 301 permanent redirection
     *
     * @return Nothing
     */
    public function redirect($url, $permanent = false)
    {
        redirect($url, $permanent);
    }
    /**
     * Set date_format parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function setDateFormat($value)
    {
        $this->date_format = $value;
        $this->debug('$date_format was defined as ' . $value);
    }
    /**
     * Get pubic $date_format
     *
     * @return String Date format
     */
    public function getDateFormat()
    {
        return $this->date_format;
    }
    /**
     * Set coma_separator parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function setComaSeparator($value)
    {
        $this->coma_separator = $value;
        $this->debug('$coma_separator was defined as ' . $value);
    }
    /**
     * Get coma_separator parameter
     *
     * @return String
     */
    public function getComaSeparator()
    {
        return $this->coma_separator;
    }
    /**
     * Set thousand_separator parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function setThousandSeparator($value)
    {
        $this->thousand_separator = $value;
        $this->debug('$thousand_separator was defined as' . $value);
    }
    /**
     * Get thousand_separator parameter
     *
     * @return String
     */
    public function getThousandSeparator()
    {
        return $this->thousand_separator;
    }
    /**
     * Set user_languages parameter
     *
     * @return Nothing
     */
    public function setUserLanguages()
    {
        $this->user_languages = getLanguages();
        $this->debug('$user_languages was defined');
    }
    /**
     * Returns an array (neat to priorities) with user languages.
     *
     * @return String
     */
    public function getUserLanguages()
    {
        return $this->user_languages;
    }
    /**
     * Set user_ip parameter
     *
     * @return Nothing
     */
    public function setUserIp()
    {
        $this->user_ip = getIp();
        $this->debug('$userIp was defined as ' . $this->user_ip);
    }
    /**
     * Returns the real user's IP avoiding proxy in string format.
     *
     * @return String
     */
    public function getUserIp()
    {
        return $this->userIp;
    }
    /**
     * Convert a unix date to format in the regional current locales
     *
     * @param Int    $date   Unix date formated
     * @param String $format Custom locale format
     *
     * @return String
     */
    public function unix2locale($date = null, $format = null)
    {
        if (empty($date)) {
            $date = time();
        }
        if (empty($format)) {
            $format = $this->date_format;
        }
        return unix2locale($date, $format);
    }
    /**
     * Return array of the current datetime in unix, human & object format
     *
     * @return Array
     */
    public function now()
    {
        return now();
    }
    /**
     * Get php errors parameters
     *
     * @return Object
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
    /**
     * Set display_errors parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function displayErrors($value = false)
    {
        $this->display_errors = $value;
        $this->phpErrors();
    }
    /**
     * Set error_reporting parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function errorReporting($value = false)
    {
        $this->error_reporting = $value;
        $this->phpErrors();
    }
    /**
     * Set e_error parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function eError($value = true)
    {
        $this->e_error = $value;
        $this->phpErrors();
    }
    /**
     * Set e_recoverable_error parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function eRecoverableError($value = true)
    {
        $this->e_recoverable_error = $value;
        $this->phpErrors();
    }
    /**
     * Set e_warning parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function eWarning($value = true)
    {
        $this->e_warning = $value;
        $this->phpErrors();
    }
    /**
     * Set e_parse parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function eParse($value = true)
    {
        $this->e_parse = $value;
        $this->phpErrors();
    }
    /**
     * Set e_strinct parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function eStrict($value = true)
    {
        $this->e_strict = $value;
        $this->phpErrors();
    }
    /**
     * Set e_notice parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function eNotice($value = false)
    {
        $this->e_notice = $value;
        $this->phpErrors();
    }
    /**
     * Set e_deprecated parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function eDeprecated($value = true)
    {
        $this->e_deprecated = $value;
        $this->phpErrors();
    }
    /**
     * Set e_user_deprecated parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function eUserDeprecated($value = true)
    {
        $this->e_user_deprecated = $value;
        $this->phpErrors();
    }
    /**
     * Apply display errors params configuration
     *
     * @return Nothing
     */
    public function phpErrors()
    {
        if ($this->display_errors) {
            ini_set('display_errors', 1);
            if ($this->error_reporting) {
                $tmp=array();
                if ($this->e_error == false) {
                    $tmp[] = 'E_ERROR';
                }
                if (!$this->e_recoverable_error) {
                    $tmp[] = 'E_RECOVERABLE_ERROR';
                }
                if (!$this->e_warning) {
                    $tmp[] = 'E_WARNING';
                }
                if (!$this->e_parse) {
                    $tmp[] = 'E_PARSE';
                }
                if (!$this->e_strict) {
                    $tmp[] = 'E_STRICT';
                }
                if (!$this->e_notice) {
                    $tmp[] = 'E_NOTICE';
                }
                if (!$this->e_deprecated) {
                    $tmp[] = 'E_DEPRECATED';
                }
                if (!$this->e_user_deprecated) {
                    $tmp[] = 'E_USER_DEPRECATED';
                }
                $tmp=implode('|', $tmp);
                if ($tmp != '') {
                    eval('error_reporting(E_ALL & ~('.$tmp.'));');
                } else {
                    eval('error_reporting(E_ALL);');
                }
            }
        } else {
            ini_set('display_errors', 0);
            error_reporting(0);
        }
    }
    /**
     * Sort an multidimensional array based on a specific key
     *
     * @param Array   $array   Array to modify
     * @param String  $field   Name of field
     * @param Boolean $inverse Set true for invert order to DESC
     *
     * @return Array
     */
    public function sortByField($array = array(), $field = null, $inverse = false)
    {
        return sortByField($array, $field, $inverse);
    }
    /**
     * Check and add protocol to link.
     *
     * @param String $link     Link to check
     * @param String $protocol Protocol to add if
     *
     * @return String
     */
    public function checkLink($link, $protocol = 'http://')
    {
        return checkLink($link, $protocol);
    }
    /**
     * Convert ASCI quotes to text format
     * (to clean text, before saving it to the database).
     *
     * @param String $string Text to replace
     *
     * @return String
     */
    public function asciQuotes($string)
    {
        return asciQuotes($string);
    }
    /**
     * Convert smart quotes to text format
     * (to clean text, before saving it to the database).
     *
     * @param String $string Text to replace
     *
     * @return String
     */
    public function smartQuotes($string)
    {
        return smartQuotes($string);
    }
    /**
     * Returns the string without spaces or symbols to build friendly URL.
     *
     * @param String $string Text to convert
     *
     * @return String
     */
    public function string2url($string)
    {
        return string2url($string);
    }
    /**
     * Cut a length of text characters you want, without breaking any word.
     *
     * @param String  $string   Text to cut
     * @param Int     $size     Max siz of result
     * @param Boolean $ellipsis Add ellipsis at end of result
     *
     * @return String
     */
    public function cut($string, $size = 100, $ellipsis = true)
    {
        return cut($string, $size, $ellipsis);
    }
    /**
     * Converts html to plain text maintaining a human readable format without
     * losing links and breaklines.
     *
     * @param String $string Text to convert
     *
     * @return String
     */
    public function html2txt($string)
    {
        return html2txt($string);
    }
    /**
     * Convert folder structure to multidimensional array with all info and content.
     *
     * @param String  $dir     Folderpath
     * @param Boolean $content Add content in base64
     *
     * @return Array
     */
    public function dir2array($dir, $content = false)
    {
        return dir2array($dir, $content);
    }
    /**
     * Returns an array with base64 code, mime, name & size of file
     *
     * @param String $file Filepath
     *
     * @return Array
     */
    public function file2base64($file)
    {
        return file2base64($file);
    }
    /**
     * Returns the MIME information from a file in string format.
     *
     * @param String $file Filepath
     *
     * @return Array
     */
    public function getMime($file = null)
    {
        return getMime($file);
    }
    /**
     * Returns the MIME information from a file in string format.
     *
     * @param String $file Filepath
     *
     * @return String
     */
    public function getTime($file = null)
    {
        return getTime($file);
    }
    /**
     * Returns an array with three different formats of file permissions
     * (Numeric, Octal and Full).
     *
     * @param String $file Filepath
     *
     * @return Array
     */
    public function getPermissions($file = null)
    {
        return getPermissions($file);
    }
    /**
     * Returns the extension of a file in string value
     *
     * @param String $file Filepath
     *
     * @return Array
     */
    public function getExtension($file = null)
    {
        return getExtension($file);
    }
    /**
     * Convert size values (Available formats: B, KB, MB, GB, TB PB, EB, ZB, YB).
     *
     * @param Int    $value    Value
     * @param String $from     From Format
     * @param String $to       To format
     * @param Int    $decimals Number of decimals
     *
     * @return Array
     */
    public function size2size($value = null, $from = 'B', $to = 'MB', $decimals = 2)
    {
        return size2size(
            $value,
            $from,
            $to,
            $decimals,
            $this->coma_separator,
            $this->thousand_separator
        );
    }

    /**
     * Set mail_charset parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function setMailCharset($value)
    {
        $this->mail_charset = $value;
        $this->debug('$mail_charset was defined as ' . $value);
    }
    /**
     * Get mail_charset parameter
     *
     * @return String
     */
    public function getMailCharset()
    {
        return $this->mail_charset;
    }
    /**
     * Set mail_charset_plain parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function setMailCharsetPlain($value)
    {
        $this->mail_charset_plain = $value;
        $this->debug('$mail_charset_plain was defined as ' . $value);
    }
    /**
     * Get mail_charset_plain parameter
     *
     * @return String
     */
    public function getMailCharsetPlain()
    {
        return $this->mail_charset_plain;
    }
    /**
     * Set mail_charset_html parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function setMailCharsetHtml($value)
    {
        $this->mail_charset_html = $value;
        $this->debug('$mail_charset_html was defined as ' . $value);
    }
    /**
     * Get mail_charser_html parameter
     *
     * @return String
     */
    public function getMailCharsetHtml()
    {
        return $this->mail_charset_html;
    }
    /**
     * Set mail_sender_mail parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function setMailSenderMail($value)
    {
        $this->mail_sender_mail = $value;
        $this->debug('$mail_sender_mail was defined as ' . $value);
    }
    /**
     * Get mail_sender_mail parameter
     *
     * @return String
     */
    public function getMailSenderMail()
    {
        return $this->mail_sender_mail;
    }
    /**
     * Set mail_reply_to_mail parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function setMailReplyToMail($value)
    {
        $this->mail_reply_to_mail = $value;
        $this->debug('$mail_reply_to_mail was defined as ' . $value);
    }
    /**
     * Get mail_replt_to_mail parameter
     *
     * @return String
     */
    public function getMailReplyToMail()
    {
        return $this->mail_reply_to_mail;
    }
    /**
     * Set mail_reply_to_name parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function setMailReplyToName($value)
    {
        $this->mail_reply_to_name = $value;
        $this->debug('$mail_reply_to_name was defined as ' . $value);
    }
    /**
     * Get mail_replt_to_name parameter
     *
     * @return String
     */
    public function getMailReplyToName()
    {
        return $this->mail_reply_to_name;
    }
    /**
     * Set mail_sender_name parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function setMailSenderName($value)
    {
        $this->mail_sender_name = $value;
        $this->debug('$mail_sender_name was defined as ' . $value);
    }
    /**
     * Get mail_sender_name parameter
     *
     * @return String
     */
    public function getMailSenderName()
    {
        return $this->mail_sender_name;
    }
    /**
     * Set smtp_host parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function setSmtpHost($value)
    {
        $this->smtp_host = $value;
        $this->debug('$smtp_host was defined as ' . $value);
    }
    /**
     * Get smtp_host parameter
     *
     * @return String
     */
    public function getSmtpHost()
    {
        return $this->smtp_host;
    }
    /**
     * Set smtp_protocol parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function setSmtpProtocol($value)
    {
        $this->smtp_protocol = $value;
        $this->debug('$smtp_protocol was defined as ' . $value);
    }
    /**
     * Get smtp_protocol parameter
     *
     * @return String
     */
    public function getSmtpProtocol()
    {
        return $this->smtp_protocol;
    }
    /**
     * Set smtp_user parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function setSmtpUser($value)
    {
        $this->smpt_user = $value;
        $this->debug('$smpt_user was defined as ' . $value);
    }
    /**
     * Get smtp_user parameter
     *
     * @return String
     */
    public function getSmtpUser()
    {
        return $this->smpt_user;
    }
    /**
     * Set smtp_password parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function setSmtpPassword($value)
    {
        $this->smtp_password = $value;
        $this->debug('$smtp_password was defined as ' . $value);
    }
    /**
     * Get smtp_password parameter
     *
     * @return String
     */
    public function getSmtpPassword()
    {
        return $this->smtp_password;
    }
    /**
     * Set smtp_port parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function setSmtpPort($value)
    {
        $this->smtp_port = $value;
        $this->debug('$smtp_port was defined as ' . $value);
    }
    /**
     * Get smtp_port parameter
     *
     * @return String
     */
    public function getSmtpPort()
    {
        return $this->smtp_port;
    }
    /**
     * Set smtop_antiflood parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function setSmtpAntiflood($value)
    {
        $this->smtp_antiflood = $value;
        $this->debug('$smtp_antiflood was defined as ' . $value);
    }
    /**
     * Get smtp_antiflood parameter
     *
     * @return String
     */
    public function getSmtpAntiflood()
    {
        return $this->smtp_antiflood;
    }
    /**
     * Set smtp_antiflood_mails parameter
     *
     * @param String $value New value to set
     *
     * @return Nothing
     */
    public function setSmtpAntifloodMails($value)
    {
        $this->smtp_antiflood_mails = $value;
        $this->debug('$smtp_antiflood_mails was defined as ' . $value);
    }
    /**
     * Get smtp_antiflood_mails parameter
     *
     * @return String
     */
    public function getSmtpAntifloodMails()
    {
        return $this->smtp_antiflood_mails;
    }
    /**
     * Get all mail values parameters
     *
     * @return Object
     */
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
    /**
     * Checks that the mail has the correct format
     *
     * @param String $value Email Address
     *
     * @return Array
     */
    public function checkMail($value)
    {
        return checkMail($value);
    }
    /**
     * Encode an email to that robots cannot read
     *
     * @param String $value Email Address
     *
     * @return Array
     */
    public function encodeMail($value)
    {
        return encodeMail($value);
    }
    /**
     * Search and encode all emails in string so that it can be read by robots
     *
     * @param String $value Email Address
     *
     * @return Array
     */
    public function encodeMailString($value)
    {
        return encodeMailString($value);
    }
    /**
     * Send smtp or phpmail with the same function dependent of your configuration
     *
     * @param String/Array $to      Email adress to send
     * @param String       $subject Subject of mail
     * @param String       $body    Content of mail
     * @param Array        $extras  Extra params for sending
     *
     * @return Result
     */
    public function fastMail(
        $to = null,
        $subject = null,
        $body = null,
        $extras = array()
    ) {
        if ($to == null || $subject == null || $body == null) {
            return false;
        }
        if (class_exists('Swift_SmtpTransport')
            && $this->smpt_user != false
            && $this->smtp_password != false
        ) {
            return swiftMail(
                $to,
                $subject,
                $body,
                $extras,
                $this->getAllMailValues()
            );
        } else if (class_exists('PHPMailer')
            && $this->smpt_user != false
            && $this->smtp_password != false
        ) {
            return phpMailer(
                $to,
                $subject,
                $body,
                $extras,
                $this->getAllMailValues()
            );
        } else {
            return phpMail(
                $to,
                $subject,
                $body,
                $extras,
                $this->getAllMailValues()
            );
        }
    }
}
