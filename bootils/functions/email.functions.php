<?php
class email extends bootils{
    
    function checkMail ($value) {
        if(filter_var($value,FILTER_VALIDATE_EMAIL) === false){
            return false;
        }else{
            return true;
        }
    }
    function encodeMail ($value)
    {
        $new_mail = '';
        $longitud = strlen($value);
        for ($i = 0; $i < $longitud; $i++) {
            $new_mail .= "&#".ord($value[$i]).";";
        }
        return $new_mail;
    }
    function encodeMailString ($value)
    {
        $value=str_replace(' />','/>',$value);
        $value=str_replace('<',' <',$value);
        $value=str_replace('>','> ',$value);
        $words=explode(' ',$value);
        $newValue='';
        foreach($words as $word){
            if(preg_match('/@/',$word)){
                if(checkMail($word)=== false){
                    $email = preg_replace("/href=[\'|\"]mailto:(.*?)[\'|\"].*/", "$1", strip_tags($word)); 
                    $email2 = encodeMail($email);
                    $newValue.= preg_replace("/".$email."/", $email2, $word);
                }else{
                    $newValue.=encodeMail($word).' ';
                }
            }else{
                $newValue.=$word.' ';
            }
        }
        return $newValue;
    }
    function swiftMail ($to,$subject,$body,$values) {
        //Default values
        if(!defined("SMTP_HOST")){ define( 'SMTP_HOST', 'localhost' ); }
        if(!defined("SMTP_PORT")){ define( 'SMTP_PORT', 25 ); }
        if(!defined("SMTP_USER")){ define( 'SMTP_USER', '' ); }
        if(!defined("SMTP_PASSWORD")){ define( 'SMTP_PASSWORD', '' ); }
        if(!defined("SMTP_ANTIFLOOD")){define( 'SMTP_ANTIFLOOD', true );}
        if(!defined("SMTP_ANTIFLOOD_MAILS")){define( 'SMTP_ANTIFLOOD_MAILS', 100 );}
        if(!defined("SMTP_ANTIFLOOD_PAUSE")){define( 'SMTP_ANTIFLOOD_PAUSE', 30 );}
        
        if(isset($values['sender'])){
            $from=$values['sender'];
        }else{
            if(!defined("MAIL_SENDER_MAIL")){ define( 'MAIL_SENDER_MAIL', '' ); }
            if(!defined("MAIL_SENDER_NAME")){ define( 'MAIL_SENDER_NAME', '' ); }
            $from=array(MAIL_SENDER_MAIL => MAIL_SENDER_NAME);
        }
        
        // create swift transport
        $transport = Swift_SmtpTransport::newInstance(SMTP_HOST, SMTP_PORT)
            ->setUsername(SMTP_USER)
            ->setPassword(SMTP_PASSWORD)
        ;
        // create swift mailer
        $mailer = Swift_Mailer::newInstance($transport);
        
        // optional active antiflood
        if(SMTP_ANTIFLOOD==true){
            $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(SMTP_ANTIFLOOD_MAILS, SMTP_ANTIFLOOD_PAUSE));
        }

        // Create a message
        $message = Swift_Message::newInstance();
        
        // set the recipients of email
        if(is_array($to)){
            $message->setTo($to);
        }else{
            $message->setTo(array($to));
        }
        // set the subject of email
        $message->setSubject($subject);
        
        // set the sender of email
        if(is_array($from)){
            $message->setFrom($from);
        }else{
            $message->setFrom(array($from));
        }
            
        // set the Copy recipients of email
        if(isset($values['cc']) && is_array($values['cc'])){
            $message->setCc($values['cc']);
        }elseif(isset($values['cc'])){
            $message->setCc(array($values['cc']));
        }
        // set the Hiden copy recipients of email
        if(isset($values['bcc']) && is_array($values['bcc'])){
            $message->setBcc($values['bcc']);
        }elseif(isset($values['bcc'])){
            $message->setBcc(array($values['bcc']));
        }
        
        if(isset($values['charset'])){
            $message->setCharset($values['charset']);
        }else{
            if(!defined("MAIL_CHARSET")){ define( 'MAIL_CHARSET', 'UTF-8' ); }
            $message->setCharset(MAIL_CHARSET);
        }
        if(isset($values['html_charset'])){
            $message->setBody($body, 'text/html',$values['html_charset']);
        }else{
            if(!defined("MAIL_CHARSET_HTML")){
                if(isset($values['charset'])){
                    define( 'MAIL_CHARSET_HTML', $values['charset'] );
                }else{
                    define( 'MAIL_CHARSET_HTML', 'UTF-8' );
                }
            }
            $message->setBody($body, 'text/html',MAIL_CHARSET_HTML);
        }
        if(isset($values['plain_charset'])){
            $message->addPart(html2txt($body), 'text/plain',$values['plain_charset']);
        }else{
            if(!defined("MAIL_CHARSET_PLAIN")){
                if(isset($values['charset'])){
                    define( 'MAIL_CHARSET_PLAIN', $values['charset'] );
                }else{
                    define( 'MAIL_CHARSET_PLAIN', 'UTF-8' );
                }
            }
            $message->addPart(html2txt($body), 'text/plain',MAIL_CHARSET_HTML);
        }
        if(isset($values['priority']) && $values['priority']>0 && $values['priority']<6){
            $message->setPriority($values['priority']);
        }
        if(isset($values['attachment']) && is_array($values['attachment'])){
            foreach($values['attachment'] as $file){
                $message->attach(Swift_Attachment::fromPath($file));
            }
        }elseif(isset($values['attachment'])){
            $message->attach(Swift_Attachment::fromPath($values['attachment']));
        }
        // Send the message
        $result=$mailer->send($message);
        if ($result==1)
        {
            return true;
        }else{
            return false;
        }
    }
    function phpMail ($to,$subject,$body,$values) {        
        // recipients
        $recipients=array();
        if(is_array($to)){
            foreach($to as $key=>$value){
                if(checkMail($key)==true){
                    $recipients[]=$value.' <'.$key.'>';
                }elseif(checkMail($value)==true){
                    $recipients[]=$value;
                }
            }
        }else{
            $recipients[]=$to;
        }
        $to=  implode(',', $recipients);
        // define charset
        if(isset($values['charset'])){
            $charset=$values['charset'];
        }else{
            if(!defined("MAIL_CHARSET")){ define( 'MAIL_CHARSET', 'UTF-8' ); }
            $charset=MAIL_CHARSET;
        }
        if(isset($values['html_charset'])){
            $charset=$values['html_charset'];
        }else{
            if(!defined("MAIL_CHARSET_HTML")){
                if(isset($values['charset'])){
                    define( 'MAIL_CHARSET_HTML', $values['charset'] );
                }else{
                    define( 'MAIL_CHARSET_HTML', 'UTF-8' );
                }
            }
            $charset=MAIL_CHARSET_HTML;
        }
        // bulding extra headers
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset='.$charset . "\r\n";
        // sender headers
        $senders=array();
        if(isset($values['sender'])){
            if(is_array($values['sender'])){
                foreach($values['sender'] as $key=>$value){
                    if(checkMail($key)==true){
                        $senders[]=$value.' <'.$key.'>';
                    }elseif(checkMail($value)==true){
                        $senders[]=$value;
                    }
                }
            }else{
                $senders[]=$values['sender'];
            }
        }elseif(defined("MAIL_SENDER_MAIL")){
            if(defined("MAIL_SENDER_NAME")){
                $senders[]=MAIL_SENDER_NAME.' <'.MAIL_SENDER_MAIL. ">";
            }else{
                $senders[]=MAIL_SENDER_MAIL;
            }
        }
        if(sizeof($senders)>0){
            $tmp=  implode(',', $senders);
            $headers.="From: ".$tmp."\r\n";
        }
        // copy headers
        $cc=array();
        if(isset($values['cc'])){
            if(is_array($values['cc'])){
                foreach($values['cc'] as $key=>$value){
                    if(checkMail($key)==true){
                        $cc[]=$value.' <'.$key.'>';
                    }elseif(checkMail($value)==true){
                        $cc[]=$value;
                    }
                }
            }else{
                $cc[]=$values['cc'];
            }
        }
        if(sizeof($cc)>0){
            $tmp=  implode(',', $cc);
            $headers.="Cc: ".$tmp."\r\n";
        }
        // hidden copy headers
        $cc=array();
        if(isset($values['bcc'])){
            if(is_array($values['bcc'])){
                foreach($values['bcc'] as $key=>$value){
                    if(checkMail($key)==true){
                        $cc[]=$value.' <'.$key.'>';
                    }elseif(checkMail($value)==true){
                        $cc[]=$value;
                    }
                }
            }else{
                $cc[]=$values['bcc'];
            }
        }
        if(sizeof($cc)>0){
            $tmp=  implode(',', $cc);
            $headers.="Bcc: ".$tmp."\r\n";
        }
        // send email
        $result=mail($to, $subject, $body,$headers);
        if($result==null){
            return false;
        }else{
            return true;
        }
    }
}
?>
