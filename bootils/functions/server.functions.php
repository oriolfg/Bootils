<?php
class server extends bootils{
    
    function getIP(){
       if( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' ){
          $client_ip =
             ( !empty($_SERVER['REMOTE_ADDR']) ) ?
                $_SERVER['REMOTE_ADDR']
                :
                ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
                   $_ENV['REMOTE_ADDR']
                   :
                   "unknown" );
          $entries = split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);
          reset($entries);
          while (list(, $entry) = each($entries)){
             $entry = trim($entry);
             if ( preg_match("/^([0-9]+\\.[0-9]+\\.[0-9]+\\.[0-9]+)/", $entry, $ip_list) ){
                $private_ip = array(
                      '/^0\\./',
                      '/^127\\.0\\.0\\.1/',
                      '/^192\\.168\\..*/',
                      '/^172\\.((1[6-9])|(2[0-9])|(3[0-1]))\\..*/',
                      '/^10\\..*/');
                $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);
                if ($client_ip != $found_ip){
                   $client_ip = $found_ip;
                   break;
                }
             }
          }
       }else{
          $client_ip =
             ( !empty($_SERVER['REMOTE_ADDR']) ) ?
                $_SERVER['REMOTE_ADDR']
                :
                ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
                   $_ENV['REMOTE_ADDR']
                   :
                   "unknown" );
       }
       return $client_ip;
    }
    function noCache(){
        header('Expires: Tue, 13 Mar 1979 18:00:00 GMT');
        header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
    }
    function redirect($value,$permanent){
        if($permanent==true){
            header ('HTTP/1.1 301 Moved Permanently');
        }
        header('Location: '.checkLink($value));
        exit;
    }
    function userLanguage(){
      if(!isset($_SESSION['user_language'])){
          if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
              $values=preg_split('/;|,/',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
          }else{
              $values=preg_split('/;|,/','en');
          }
          $userlangs=array();
          foreach($values as $val){
            if(substr(str_replace(' ','',str_replace('-','_',$val)), 0, 2)!='q='){
              $tmp=str_replace(' ','',str_replace('-','_',$val));
              if(!in_array($tmp, $userlangs)){
                  $userlangs[]=$tmp;
              }
            }
          }
          // If the user does not have English, added to the end of the list of priorities
          if(!in_array('en', $userlangs)){
              $userlangs[]='en';
          }
          if(!in_array('en_GB', $userlangs)){
              $userlangs[]='en_GB';
          }
          return $userlangs;
      }
    }
    function defineLocale($value){
        if(isset($value)){
            $locale = setlocale(LC_ALL, explode(',',$value)); 
        }else{
            $locale = setlocale(LC_ALL, DEFAULT_LANGUAGE_LOCALE); 
        }
        return $locale;
    }
}
?>
