<?php
namespace Bootils;

class Dates
{
    
    public function unix2locale($value = null, $format = DEFAULT_DATE_FORMAT)
    {
        //$format = ((strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') ? '%#d' : '%e');

        if (empty($value)) {
            $value=time();
        }
        $values=date('Y-m-d H:i:s', $value);
        $d=explode(" ", $values);
        $d1=explode("-", $d[0]);
        if (!isset($d[1])||$d[1]=='') {
            $d[1]="00:00:00";
        }
        $d2=explode(":", $d[1]);

        $mkd=mktime((int)$d2[0], (int)$d2[1], (int)$d2[2], (int)$d1[1], (int)$d1[2], (int)$d1[0]);
        $mes=strftime("%B", $mkd);
        $data=strftime($format, $mkd);
        // Correction for catalan language in ca_ES, ca_AD, ca_FR, ca_IT, & the future ca_CT
        if (($mes=="agost") || ($mes=="octubre") || ($mes=="abril")) {
            $data=@strftime(str_replace("de %B", "d'%B", $format), $mkd);
        }
        
        return ucfirst($data);
    }
    public function now()
    {
        $date = date_create();
        $array = array(
            'unix' => date_timestamp_get($date),
            'human' => unix2locale(date_timestamp_get($date)),
            'object' => $date
        );
        return $array;
    }
}
