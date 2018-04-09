<?php
/**
 * Email functions file
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
 * Checks that the mail has the correct format
 *
 * @param String $value Email Address
 *
 * @return Array
 */
function checkMail($value)
{
    if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
        return false;
    } else {
        return true;
    }
}
/**
 * Encode an email to that robots cannot read
 *
 * @param String $value Email Address
 *
 * @return Array
 */
function encodeMail($value)
{
    $new_mail = '';
    $longitud = strlen($value);
    for ($i = 0; $i < $longitud; $i++) {
        $new_mail .= '&#'.ord($value[$i]).';';
    }
    return $new_mail;
}
/**
 * Search and encode all emails in string so that it can be read by robots
 *
 * @param String $value Email Address
 *
 * @return Array
 */
function encodeMailString($value)
{
    $value = str_replace(' />', '/>', $value);
    $value = str_replace('<', ' <', $value);
    $value = str_replace('>', '> ', $value);
    $words = explode(' ', $value);
    $newValue = '';
    foreach ($words as $word) {
        if (preg_match('/@/', $word)) {
            if (checkMail($word) === false) {
                $email = preg_replace(
                    "/href=[\'|\"]mailto:(.*?)[\'|\"].*/",
                    '$1',
                    strip_tags($word)
                );
                $email2 = encodeMail($email);
                $newValue .= preg_replace('/' . $email . '/', $email2, $word);
            } else {
                $newValue .= encodeMail($word) . ' ';
            }
        } else {
            $newValue .= $word . ' ';
        }
    }
    return $newValue;
}
/**
 * Send phpmailer
 *
 * @param String/Array $to       Email adress to send
 * @param String       $subject  Subject of mail
 * @param String       $body     Content of mail
 * @param Array        $values   Extra params for sending
 * @param Array        $mailConf Mail configuration params
 *
 * @return Result
 */
function phpMailer($to, $subject, $body, $values, $mailConf)
{
    $mail = new \PHPMailer;
    $mail->isSMTP();
    $mail->Host = $mailConf->smtp_host;
    $mail->SMTPAuth = true;
    $mail->Username = $mailConf->smpt_user;
    $mail->Password = $mailConf->smtp_password;
    $mail->SMTPSecure = $mailConf->smtp_protocol;
    $mail->Port = $mailConf->smtp_port;
    $mail->From = $mailConf->mail_sender_mail;
    $mail->FromName = $mailConf->mail_sender_name;
    // Recipients
    if (is_array($to)) {
        foreach ($to as $email => $name) {
            if (is_numeric($email)) {
                $mail->addAddress($name);
            } else {
                $mail->addAddress($email, $name);
            }
        }
    } else {
        $mail->addAddress($to);
    }
    if (isset($mailConf->mail_reply_to_name)
        && $mailConf->mail_reply_to_name != null
    ) {
        $mail->addReplyTo(
            $mailConf->mail_reply_to_mail,
            $mailConf->mail_reply_to_name
        );
    } else {
        $mail->addReplyTo($mailConf->mail_reply_to_mail);
    }
    if (isset($values['cc']) && is_array($values['cc'])) {
        foreach ($values['cc'] as $email => $name) {
            if (is_numeric($email)) {
                $mail->addCC($name);
            } else {
                $mail->addCC($email, $name);
            }
        }
    } else {
        $mail->addCC($to);
    }
    if (isset($values['bcc']) && is_array($values['bcc'])) {
        foreach ($values['bcc'] as $email => $name) {
            if (is_numeric($email)) {
                $mail->addBCC($name);
            } else {
                $mail->addBCC($email, $name);
            }
        }
    } else {
        $mail->addBCC($to);
    }

    if (isset($values['attachment']) && is_array($values['attachment'])) {
        foreach ($values['attachment'] as $file) {
            $mail->addAttachment($file);
        }
    } elseif (isset($values['attachment'])) {
        $mail->addAttachment($values['attachment']);
    }

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->AltBody = html2txt($body);

    if (isset($values['charset'])) {
        $mail->CharSet = $values['charset'];
    } else {
        $mail->CharSet = $mailConf->mail_charset;
    }
    // Send the message
    if (!$mail->send()) {
        return false;
    } else {
        return true;
    }
}
/**
 * Send swiftMAil
 *
 * @param String/Array $to       Email adress to send
 * @param String       $subject  Subject of mail
 * @param String       $body     Content of mail
 * @param Array        $values   Extra params for sending
 * @param Array        $mailConf Mail configuration params
 *
 * @return Result
 */
function swiftMail($to, $subject, $body, $values, $mailConf)
{
    $from = array($mailConf->mail_sender_mail => $mailConf->mail_sender_name);

    // create swift transport
    $transport = \Swift_SmtpTransport::newInstance(
        $mailConf->smtp_host,
        $mailConf->smtp_port
    )
    ->setUsername($mailConf->smpt_user)
    ->setPassword($mailConf->smtp_password);
    // create swift mailer
    $mailer = \Swift_Mailer::newInstance($transport);

    // optional active antiflood
    if ($mailConf->smtp_antiflood == true) {
        $mailer->registerPlugin(
            new \Swift_Plugins_AntiFloodPlugin(
                $mailConf->smtp_antiflood_mails,
                $mailConf->smtp_antiflood_pause
            )
        );
    }

    // Create a message
    $message = \Swift_Message::newInstance();

    // set the recipients of email
    if (is_array($to)) {
        $message->setTo($to);
    } else {
        $message->setTo(array($to));
    }
    // set the subject of email
    $message->setSubject($subject);

    // set the sender of email
    if (is_array($from)) {
        $message->setFrom($from);
    } else {
        $message->setFrom(array($from));
    }

    // set the Copy recipients of email
    if (isset($values['cc']) && is_array($values['cc'])) {
        $message->setCc($values['cc']);
    } elseif (isset($values['cc'])) {
        $message->setCc(array($values['cc']));
    }
    // set the Hiden copy recipients of email
    if (isset($values['bcc']) && is_array($values['bcc'])) {
        $message->setBcc($values['bcc']);
    } elseif (isset($values['bcc'])) {
        $message->setBcc(array($values['bcc']));
    }

    if (isset($values['charset'])) {
        $message->setCharset($values['charset']);
    } else {
        $message->setCharset($mailConf->mail_charset);
    }
    if (isset($values['html_charset'])) {
        $message->setBody($body, 'text/html', $values['html_charset']);
    } else {
        $message->setBody($body, 'text/html', $mailConf->mail_charset_html);
    }
    if (isset($values['plain_charset'])) {
        $message->addPart(html2txt($body), 'text/plain', $values['plain_charset']);
    } else {
        $message->addPart(
            html2txt($body),
            'text/plain',
            $mailConf->mail_charset_html
        );
    }
    if (isset($values['priority'])
        && $values['priority'] > 0
        && $values['priority'] < 6
    ) {
        $message->setPriority($values['priority']);
    }
    if (isset($values['attachment']) && is_array($values['attachment'])) {
        foreach ($values['attachment'] as $file) {
            $message->attach(\Swift_Attachment::fromPath($file));
        }
    } elseif (isset($values['attachment'])) {
        $message->attach(\Swift_Attachment::fromPath($values['attachment']));
    }
    // Send the message
    $result = $mailer->send($message);
    return $result == 1;
}
/**
 * Send phpmail
 *
 * @param String/Array $to       Email adress to send
 * @param String       $subject  Subject of mail
 * @param String       $body     Content of mail
 * @param Array        $values   Extra params for sending
 * @param Array        $mailConf Mail configuration params
 *
 * @return Result
 */
function phpMail($to, $subject, $body, $values, $mailConf)
{
    // recipients
    $recipients = array();
    if (is_array($to)) {
        foreach ($to as $key => $value) {
            if (checkMail($key) == true) {
                $recipients[] = $value . ' <' . $key . '>';
            } elseif (checkMail($value) == true) {
                $recipients[] = $value;
            }
        }
    } else {
        $recipients[] = $to;
    }
    $to =  implode(',', $recipients);
    // define charset
    if (isset($values['charset'])) {
        $charset = $values['charset'];
    } else {
        $charset = $mailConf->mail_charset;
    }
    if (isset($values['html_charset'])) {
        $charset = $values['html_charset'];
    } else {
        $charset = $mailConf->mail_charset_html;
    }
    // bulding extra headers
    $headers  = 'MIME-Version: 1.0' . '\r\n';
    $headers .= 'Content-type: text/html; charset=' . $charset . '\r\n';
    // sender headers
    $senders = array();
    if (isset($values['sender'])) {
        if (is_array($values['sender'])) {
            foreach ($values['sender'] as $key => $value) {
                if (checkMail($key) == true) {
                    $senders[] = $value . ' <' . $key . '>';
                } elseif (checkMail($value) == true) {
                    $senders[] = $value;
                }
            }
        } else {
            $senders[] = $values['sender'];
        }
    } elseif ($mailConf->mail_sender_mail) {
        if ($mailConf->mail_sender_name) {
            $senders[] = $mailConf->mail_sender_name . ' <'
            . $mailConf->mail_sender_mail . '>';
        } else {
            $senders[] = $mailConf->mail_sender_mail;
        }
    }
    if (sizeof($senders) > 0) {
        $tmp = implode(',', $senders);
        $headers .= 'From: ' . $tmp . '\r\n';
    }
    // copy headers
    $cc = array();
    if (isset($values['cc'])) {
        if (is_array($values['cc'])) {
            foreach ($values['cc'] as $key => $value) {
                if (checkMail($key) == true) {
                    $cc[] = $value . ' <' . $key . '>';
                } elseif (checkMail($value) == true) {
                    $cc[] = $value;
                }
            }
        } else {
            $cc[] = $values['cc'];
        }
    }
    if (sizeof($cc) > 0) {
        $tmp =  implode(',', $cc);
        $headers .= 'Cc: ' . $tmp . '\r\n';
    }
    // hidden copy headers
    $cc = array();
    if (isset($values['bcc'])) {
        if (is_array($values['bcc'])) {
            foreach ($values['bcc'] as $key => $value) {
                if (checkMail($key) == true) {
                    $cc[] = $value . ' <' . $key . '>';
                } elseif (checkMail($value) == true) {
                    $cc[] = $value;
                }
            }
        } else {
            $cc[] = $values['bcc'];
        }
    }
    if (sizeof($cc) > 0) {
        $tmp = implode(',', $cc);
        $headers .= 'Bcc: ' . $tmp . '\r\n';
    }
    // send email
    $result = mail($to, $subject, $body, $headers);
    return $result == null;
}
