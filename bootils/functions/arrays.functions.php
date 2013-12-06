<?php
class arrays extends bootils{
    
    function sortField ($value, $field, $inverse = false) {
        $position = array();
        $newRow = array();
        if($value){
            foreach ($value as $key => $row) {
                    $position[$key]  = $row[$field];
                    $newRow[$key] = $row;
            }
        }
        if ($inverse) {
            arsort($position);
        }
        else {
            asort($position);
        }
        $returnArray = array();
        foreach ($position as $key => $pos) {
            $returnArray[] = $newRow[$key];
        }
        return $returnArray;
    }
}
?>
