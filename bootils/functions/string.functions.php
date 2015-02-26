<?php
class string extends bootils{
    
    function asciQuotes($str)
    {
        $quotes = array(
            "\xC2\xAB"     => '"', //  (U+00AB) in UTF-8
            "\xC2\xBB"     => '"', //  (U+00BB) in UTF-8
            "\xE2\x80\x98" => "'", //  (U+2018) in UTF-8
            "\xE2\x80\x99" => "'", //  (U+2019) in UTF-8
            "\xE2\x80\x9A" => "'", //  (U+201A) in UTF-8
            "\xE2\x80\x9B" => "'", //  (U+201B) in UTF-8
            "\xE2\x80\x9C" => '"', //  (U+201C) in UTF-8
            "\xE2\x80\x9D" => '"', //  (U+201D) in UTF-8
            "\xE2\x80\x9E" => '"', //  (U+201E) in UTF-8
            "\xE2\x80\x9F" => '"', //  (U+201F) in UTF-8
            "\xE2\x80\xB9" => "'", //  (U+2039) in UTF-8
            "\xE2\x80\xBA" => "'", //  (U+203A) in UTF-8
        );
        return strtr($str, $quotes);
    }
    
    function smartQuotes($value) { 
        $search = array("\xe2\x80\x98", "\xe2\x80\x99", "\xe2\x80\x9c", "\xe2\x80\x9d", "\xe2\x80\x93", "\xe2\x80\x94", "\xe2\x80\xa6"); 
        $replace = array("'", "'", '"', '"', '-', '--', '...'); 
        $value= str_replace($search, $replace, $value); 
        $search = array(chr(145), chr(146),  chr(148), chr(150), chr(151), chr(133)); 
        $replace = array("'", "'",  '"', '-', '--', '...'); 
        return str_replace($search, $replace, $value); 
    }
    
    function string2url($str = '')
    { 
        $find = array('À','Á','Ä','Â','à','á','ä','â','ª','@');
        $str = str_replace($find,"a", $str);
        $find = array('È','É','Ë','Ê','è','é','ë','ê');
        $str = str_replace($find,"e", $str);
        $find = array('Ì','Í','ï','î','ì','í','ï','î');
        $str = str_replace($find,"i", $str);
        $find = array('Ò','Ó','Ö','Ô','ò','ó','ö','ô','º');
        $str = str_replace($find,"o", $str); 
        $find = array('Ú','Ù','Ü','Û','ú','ù','ü','û');
        $str = str_replace($find,"u", $str);
        $find = array('Ç','ç');
        $str = str_replace($find,'c',$str);
        $find = array('ß');
        $str = str_replace($find,'s',$str);
        $find = array('&');
        $str = str_replace($find,'and',$str);
        $find = array('Ñ','ñ');
        $str = str_replace($find,'n',$str);
        $find = array('€');
        $str = str_replace($find,'eur',$str);
        $find = array('$');
        $str = str_replace($find,'dollar',$str);
        $find = array(' ');
        $str = str_replace($find,'-',$str);
        $find = array('_');
        $str = str_replace($find,'-',$str);
        $find = array('-------','------','-----','----','---','--');
        $str = str_replace($find,'-',$str);
        $str=mb_strtolower($str);
        $str=preg_replace("/[^a-z0-9-]/", "",$str);
        
        return $str;
        
    }
    function cut($value,$size,$ellipsis)
    {
        $contador = 0;
        $arrayText = split(' ',$value);
        $text2 = '';
        while($size >= strlen($text2) + strlen($arrayText[$contador])){
            $text2 .= ' '.$arrayText[$contador];
            $contador++;
        }
        if(strlen($value)>strlen($text2)&&$ellipsis==true){
            $text2 .= '...';
        }
        return $text2;
    }
    function checkLink($value,$protocol){
        
        if( preg_match('/^smb:\/\//', $value)||
            preg_match('/^ftp:\/\//', $value)||
            preg_match('/^ntp:\/\//', $value)||
            preg_match('/^ssl:\/\//', $value)||
            preg_match('/^smtp:\/\//', $value)||
            preg_match('/^pop:\/\//', $value)||
            preg_match('/^pop3:\/\//', $value)||
            preg_match('/^imap:\/\//', $value)||
            preg_match('/^ssh:\/\//', $value)||
            preg_match('/^http:\/\//', $value)||
            preg_match('/^https:\/\//', $value)||
            preg_match('/^mailto:/', $value)){
            return $value;
        }else{
            return $protocol.$value;
        }
    }
    function html2txt($value) {
        $value = str_replace("\r\n", "\n", $value);
        $value = str_replace("\r", "\n", $value);
        $doc = new DOMDocument();
        if (!$doc->loadHTML($value)){
            return $value;
        }
        $class= new string();
        $output =  $class->iterate_over_node($doc);
        $output = preg_replace("/[ \t]*\n[ \t]*/im", "\n", $output);
        $output = trim($output);
        return $output;
    }
    
    function iterate_over_node($node) {
        $class= new string();
        if ($node instanceof DOMText) {
            return preg_replace("/\\s+/im", " ", $node->wholeText);
        }
        if ($node instanceof DOMDocumentType) {
            return "";
        }
        $nextName = $class->next_child_name($node);
        $prevName = $class->prev_child_name($node);
        $name = strtolower($node->nodeName);
        switch ($name) {
            case "hr":
                    return "------\n";
            case "style":
            case "head":
            case "title":
            case "meta":
            case "script":
                // ignore these tags
                return "";
            case "h1":
            case "h2":
            case "h3":
            case "h4":
            case "h5":
            case "h6":
                // add two newlines
                $output = "\n";
                break;
            case "p":
            case "div":
                // add one line
                $output = "\n";
                break;
            default:
                // print out contents of unknown tags
                $output = "";
                break;
        }
        for ($i = 0; $i < $node->childNodes->length; $i++) {
                $n = $node->childNodes->item($i);
                $text = $class->iterate_over_node($n);
                $output .= $text;
        }
        // end whitespace
        switch ($name) {
            case "style":
            case "head":
            case "title":
            case "meta":
            case "script":
                // ignore these tags
                return "";
            case "h1":
            case "h2":
            case "h3":
            case "h4":
            case "h5":
            case "h6":
                $output .= "\n";
                break;
            case "p":
            case "br":
                // add one line
                if ($nextName != "div")
                    $output .= "\n";
                break;
            case "div":
                // add one line only if the next child isn't a div
                if ($nextName != "div" && $nextName != null)
                    $output .= "\n";
                break;
            case "a":
                // links are returned in [text](link) format
                $href = $node->getAttribute("href");
                if ($href == null) {
                    // it doesn't link anywhere
                    if ($node->getAttribute("name") != null) {
                        $output = "[$output]";
                    }
                } else {
                    if ($href == $output) {
                            // link to the same address: just use link
                        $output;
                    } else {
                            // replace it
                        $output = "[$output]($href)";
                    }
                }
                // does the next node require additional whitespace?
                switch ($nextName) {
                    case "h1": case "h2": case "h3": case "h4": case "h5": case "h6":
                        $output .= "\n";
                        break;
                }
            default:
            // do nothing
        }
        return $output;
    }
    function next_child_name($node) {
        // get the next child
        $nextNode = $node->nextSibling;
        while ($nextNode != null) {
            if ($nextNode instanceof DOMElement) {
                break;
            }
            $nextNode = $nextNode->nextSibling;
        }
        $nextName = null;
        if ($nextNode instanceof DOMElement && $nextNode != null) {
            $nextName = strtolower($nextNode->nodeName);
        }
        return $nextName;
    }
    function prev_child_name($node) {
        // get the previous child
        $nextNode = $node->previousSibling;
        while ($nextNode != null) {
            if ($nextNode instanceof DOMElement) {
                break;
            }
            $nextNode = $nextNode->previousSibling;
        }
        $nextName = null;
        if ($nextNode instanceof DOMElement && $nextNode != null) {
            $nextName = strtolower($nextNode->nodeName);
        }
        return $nextName;
    }
}
?>