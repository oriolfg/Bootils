<?php
class files extends bootils{
    function dir2array($dir,$content)
    {
        if ($dir[strlen($dir)-1] != '/') $dir .= '/';
        if (!is_dir($dir)) return array();
        $dir_handle  = opendir($dir);
        $array = array();
        while ($object = readdir($dir_handle))
        {
            if (!in_array($object, array('.','..')))
            {
                $filepath    = $dir.$object;
                $file_object = array(
                    'name' => $object,
                    'path' => $dir,
                    'size' => filesize($filepath),
                    'type' => filetype($filepath),
                    'node' => fileinode($filepath),
                    'group' => filegroup($filepath),
                    'time' => getTime($filepath),
                    'perms' => getPermissions($filepath)
                );
                if($file_object['type']=='dir'){
                    if($content==true){
                        $file_object['content']=dir2array($filepath,$content);
                    }
                }else{
                    if($content==true){
                        $file_object['content']=file2base64($filepath);
                    }
                    $file_object['mime']=getMime($filepath);
                }
                $array[] = $file_object;
            }
        }
        return $array;
    }
    function file2base64($value){
        if(is_dir($value)){
            return false;
        }else{
            $mime=getMime($value);
            $fd = fopen($value, 'rb');
            $size = filesize($value);
            $cont = fread($fd, $size);
            fclose($fd);
            $result['base64']=base64_encode($cont);
            $result['mime']=$mime;
            $result['name']=basename($value);
            $result['size']=$size;
            return $result;
        }
        
    }
    function getMime($value)
    {
        return image_type_to_mime_type(exif_imagetype($value));
        
    }
    function getTime($value)
    {
        
        $array = array(
            'modified' => filemtime($value),
            'accessed' => fileatime($value),
            'changed' => filectime($value)
        );
        return $array;
        
    }
    function getPermissions($value)
    {
        $perms = fileperms($value);
        if     (($perms & 0xC000) == 0xC000) { $info = 's'; }
        elseif (($perms & 0xA000) == 0xA000) { $info = 'l'; }
        elseif (($perms & 0x8000) == 0x8000) { $info = '-'; }
        elseif (($perms & 0x6000) == 0x6000) { $info = 'b'; }
        elseif (($perms & 0x4000) == 0x4000) { $info = 'd'; }
        elseif (($perms & 0x2000) == 0x2000) { $info = 'c'; }
        elseif (($perms & 0x1000) == 0x1000) { $info = 'p'; }
        else                                 { $info = 'u'; }
        $info .= (($perms & 0x0100) ? 'r' : '-');
        $info .= (($perms & 0x0080) ? 'w' : '-');
        $info .= (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x' ) : (($perms & 0x0800) ? 'S' : '-'));
        $info .= (($perms & 0x0020) ? 'r' : '-');
        $info .= (($perms & 0x0010) ? 'w' : '-');
        $info .= (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x' ) : (($perms & 0x0400) ? 'S' : '-'));
        $info .= (($perms & 0x0004) ? 'r' : '-');
        $info .= (($perms & 0x0002) ? 'w' : '-');
        $info .= (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x' ) : (($perms & 0x0200) ? 'T' : '-'));
        
        $array = array(
            'numeric' => $perms,
            'octal' => substr(sprintf('%o', $perms), -4),
            'full' => $info
        );
        return $array;
        
    }
    function getExtension($value){
        return strtolower(substr(strrchr($value, '.'),1));
    }
    function size2size($value,$from,$to,$decimals){
        if($from=='B'){
            $B=$value;
            $KB=$value/1024;
            $MB=$KB/1024;
            $GB=$MB/1024;
            $TB=$GB/1024;
            $PB=$TB/1024;
            $EB=$PB/1024;
            $ZB=$EB/1024;
            $YB=$ZB/1024;
        }
        if($from=='KB'){
            $KB=$value;
            $MB=$KB/1024;
            $GB=$MB/1024;
            $TB=$GB/1024;
            $PB=$TB/1024;
            $EB=$PB/1024;
            $ZB=$EB/1024;
            $YB=$ZB/1024;
            $B=$value*1024;
        }
        if($from=='MB'){
            $MB=$value;
            $GB=$MB/1024;
            $TB=$GB/1024;
            $PB=$TB/1024;
            $EB=$PB/1024;
            $ZB=$EB/1024;
            $YB=$ZB/1024;
            $KB=$value*1024;
            $B=$KB*1024;
        }
        if($from=='GB'){
            $GB=$value;
            $TB=$GB/1024;
            $PB=$TB/1024;
            $EB=$PB/1024;
            $ZB=$EB/1024;
            $YB=$ZB/1024;
            $MB=$value*1024;
            $KB=$MB*1024;
            $B=$KB*1024;
        }
        if($from=='TB'){
            $TB=$value;
            $PB=$TB/1024;
            $EB=$PB/1024;
            $ZB=$EB/1024;
            $YB=$ZB/1024;
            $GB=$value*1024;
            $MB=$GB*1024;
            $KB=$MB*1024;
            $B=$KB*1024;
        }
        if($from=='PB'){
            $PB=$value;
            $EB=$PB/1024;
            $ZB=$EB/1024;
            $YB=$ZB/1024;
            $TB=$value*1024;
            $GB=$TB*1024;
            $MB=$GB*1024;
            $KB=$MB*1024;
            $B=$KB*1024;
        }
        if($from=='EB'){
            $EB=$value;
            $ZB=$EB/1024;
            $YB=$ZB/1024;
            $PB=$value*1024;
            $TB=$PB*1024;
            $GB=$TB*1024;
            $MB=$GB*1024;
            $KB=$MB*1024;
            $B=$KB*1024;
        }
        if($from=='ZB'){
            $ZB=$value;
            $YB=$ZB/1024;
            $EB=$value*1024;
            $PB=$EB*1024;
            $TB=$PB*1024;
            $GB=$TB*1024;
            $MB=$GB*1024;
            $KB=$MB*1024;
            $B=$KB*1024;
        }
        if($from=='YB'){
            $YB=$value;
            $ZB=$YB*1024;
            $EB=$value*1024;
            $PB=$EB*1024;
            $TB=$PB*1024;
            $GB=$TB*1024;
            $MB=$GB*1024;
            $KB=$MB*1024;
            $B=$KB*1024;
        }
        
        if($to=='B'){
            return number_format($B,$decimals,DEFAULT_COMA_SEPARATOR,DEFAULT_THOUSAND_SEPARATOR).' B';
        }
        if($to=='KB'){
            return number_format($KB,$decimals,DEFAULT_COMA_SEPARATOR,DEFAULT_THOUSAND_SEPARATOR).' kB';
        }
        if($to=='MB'){
            return number_format($MB,$decimals,DEFAULT_COMA_SEPARATOR,DEFAULT_THOUSAND_SEPARATOR).' MB';
        }
        if($to=='GB'){
            return number_format($GB,$decimals,DEFAULT_COMA_SEPARATOR,DEFAULT_THOUSAND_SEPARATOR).' GB';
        }
        if($to=='TB'){
            return number_format($TB,$decimals,DEFAULT_COMA_SEPARATOR,DEFAULT_THOUSAND_SEPARATOR).' TB';
        }
        if($to=='PB'){
            return number_format($PB,$decimals,DEFAULT_COMA_SEPARATOR,DEFAULT_THOUSAND_SEPARATOR).' PB';
        }
        if($to=='EB'){
            return number_format($EB,$decimals,DEFAULT_COMA_SEPARATOR,DEFAULT_THOUSAND_SEPARATOR).' EB';
        }
        if($to=='ZB'){
            return number_format($ZB,$decimals,DEFAULT_COMA_SEPARATOR,DEFAULT_THOUSAND_SEPARATOR).' ZB';
        }
        if($to=='YB'){
            return number_format($YB,$decimals,DEFAULT_COMA_SEPARATOR,DEFAULT_THOUSAND_SEPARATOR).' YB';
        }
    }
    function fileHash($value){
        if(file_exists($value)){
            return base64_encode(sha1_file($value,true));
        }else{
            return false;
        }
    }
}
?>
