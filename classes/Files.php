<?php
/**
 * Files functions file
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
 * Convert folder structure to multidimensional array with all info and content.
 *
 * @param String  $dir     Folderpath
 * @param Boolean $content Add content in base64
 *
 * @return Array
 */
function dir2array($dir, $content)
{
    if ($dir[strlen($dir)-1] != '/') {
        $dir .= '/';
    }
    if (!is_dir($dir)) {
        return array();
    }
    $dir_handle  = opendir($dir);
    $array = array();
    while ($object = readdir($dir_handle)) {
        if (!in_array($object, array('.', '..'))) {
            $filepath = $dir.$object;
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
            if ($file_object['type'] == 'dir') {
                if ($content == true) {
                    $file_object['content'] = dir2array($filepath, $content);
                }
            } else {
                if ($content == true) {
                    $file_object['content'] = file2base64($filepath);
                }
                $file_object['mime'] = getMime($filepath);
            }
            $array[] = $file_object;
        }
    }
    return $array;
}
/**
 * Returns the MIME information from a file in string format.
 *
 * @param String $value Filepath
 *
 * @return Array
 */
function getMime($value)
{
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $result = finfo_file($finfo, $value) . "\n";
    finfo_close($finfo);
    return $result;
}
/**
 * Returns the MIME information from a file in string format.
 *
 * @param String $value Filepath
 *
 * @return String
 */
function getTime($value)
{
    $array = array(
        'modified' => filemtime($value),
        'accessed' => fileatime($value),
        'changed' => filectime($value)
    );
    return $array;
}
/**
 * Returns an array with three different formats of file permissions
 * (Numeric, Octal and Full).
 *
 * @param String $value Filepath
 *
 * @return Array
 */
function getPermissions($value)
{
    $perms = fileperms($value);
    if (($perms & 0xC000) == 0xC000) {
        $info = 's';
    } elseif (($perms & 0xA000) == 0xA000) {
        $info = 'l';
    } elseif (($perms & 0x8000) == 0x8000) {
        $info = '-';
    } elseif (($perms & 0x6000) == 0x6000) {
        $info = 'b';
    } elseif (($perms & 0x2000) == 0x2000) {
        $info = 'c';
    } elseif (($perms & 0x1000) == 0x1000) {
        $info = 'p';
    } else {
        $info = 'u';
    }
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
/**
 * Returns the extension of a file in string value
 *
 * @param String $value Filepath
 *
 * @return Array
 */
function getExtension($value)
{
    return strtolower(substr(strrchr($value, '.'), 1));
}
/**
 * Convert size values (Available formats: B, KB, MB, GB, TB PB, EB, ZB, YB).
 *
 * @param Int    $value    Value
 * @param String $from     From Format
 * @param String $to       To format
 * @param Int    $decimals Number of decimals
 * @param Int    $coma     Coma simbol separator
 * @param Int    $thousand Thousand simbol separator
 *
 * @return Array
 */
function size2size($value, $from, $to, $decimals, $coma, $thousand)
{
    if ($from == 'B') {
        $B = $value;
        $KB = $value/1024;
        $GB = $MB/1024;
        $TB = $GB/1024;
        $EB = $PB/1024;
        $ZB = $EB/1024;
        $YB = $ZB/1024;
    }
    if ($from == 'KB') {
        $KB = $value;
        $MB = $KB/1024;
        $GB = $MB/1024;
        $TB = $GB/1024;
        $PB = $TB/1024;
        $EB = $PB/1024;
        $ZB = $EB/1024;
        $YB = $ZB/1024;
        $B = $value*1024;
    }
    if ($from == 'MB') {
        $MB = $value;
        $GB = $MB/1024;
        $TB = $GB/1024;
        $PB = $TB/1024;
        $EB = $PB/1024;
        $ZB = $EB/1024;
        $YB = $ZB/1024;
        $KB = $value*1024;
        $B = $KB*1024;
    }
    if ($from == 'GB') {
        $GB = $value;
        $TB = $GB/1024;
        $PB = $TB/1024;
        $EB = $PB/1024;
        $ZB = $EB/1024;
        $YB = $ZB/1024;
        $MB = $value*1024;
        $KB = $MB*1024;
        $B = $KB*1024;
    }
    if ($from == 'TB') {
        $TB = $value;
        $PB = $TB/1024;
        $EB = $PB/1024;
        $ZB = $EB/1024;
        $YB = $ZB/1024;
        $GB = $value*1024;
        $MB = $GB*1024;
        $KB = $MB*1024;
        $B = $KB*1024;
    }
    if ($from == 'PB') {
        $PB = $value;
        $EB = $PB/1024;
        $ZB = $EB/1024;
        $YB = $ZB/1024;
        $TB = $value*1024;
        $GB = $TB*1024;
        $MB = $GB*1024;
        $KB = $MB*1024;
        $B = $KB*1024;
    }
    if ($from == 'EB') {
        $EB = $value;
        $ZB = $EB/1024;
        $YB = $ZB/1024;
        $PB = $value*1024;
        $TB = $PB*1024;
        $GB = $TB*1024;
        $MB = $GB*1024;
        $KB = $MB*1024;
        $B = $KB*1024;
    }
    if ($from == 'ZB') {
        $ZB = $value;
        $YB = $ZB/1024;
        $EB = $value*1024;
        $PB = $EB*1024;
        $TB = $PB*1024;
        $GB = $TB*1024;
        $MB = $GB*1024;
        $KB = $MB*1024;
        $B = $KB*1024;
    }
    if ($from == 'YB') {
        $YB = $value;
        $ZB = $YB*1024;
        $EB = $value*1024;
        $PB = $EB*1024;
        $TB = $PB*1024;
        $GB = $TB*1024;
        $MB = $GB*1024;
        $KB = $MB*1024;
        $B = $KB*1024;
    }
    if ($to == 'B') {
        return number_format($B, $decimals, $coma, $thousand) . ' B';
    }
    if ($to == 'KB') {
        return number_format($KB, $decimals, $coma, $thousand) . ' kB';
    }
    if ($to == 'MB') {
        return number_format($MB, $decimals, $coma, $thousand) . ' MB';
    }
    if ($to == 'GB') {
        return number_format($GB, $decimals, $coma, $thousand) . ' GB';
    }
    if ($to == 'TB') {
        return number_format($TB, $decimals, $coma, $thousand) . ' TB';
    }
    if ($to == 'PB') {
        return number_format($PB, $decimals, $coma, $thousand) . ' PB';
    }
    if ($to == 'EB') {
        return number_format($EB, $decimals, $coma, $thousand) . ' EB';
    }
    if ($to == 'ZB') {
        return number_format($ZB, $decimals, $coma, $thousand) . ' ZB';
    }
    if ($to == 'YB') {
        return number_format($YB, $decimals, $coma, $thousand) . ' YB';
    }
}
/**
 * Returns an array with base64 code, mime, name & size of file
 *
 * @param String $value Filepath
 *
 * @return Array
 */
function file2base64($value)
{
    if (is_dir($value)) {
        return false;
    } else {
        $mime = getMime($value);
        $fd = fopen($value, 'rb');
        $size = filesize($value);
        fclose($fd);
        $result['base64'] = base64_encode(file_get_contents($value));
        $result['mime'] = $mime;
        $result['name'] = basename($value);
        $result['size'] = $size;
        return $result;
    }

}
