<?php

namespace Helper;

class CsvParser
{
    public static function parseCsv($csv){
        if (($handle = fopen($csv, "r")) !== FALSE) {
            $row = 1;
            $keys = [];
            $adsArray = [];
            while (($data = fgetcsv($handle, 1000)) !== FALSE) {
                if ($row == 1) {
                    $keys = $data;
                } else {
                    $adsArray[$row] = [];
                    foreach ($data as $key => $element) {
                        $adsArray[$row][$keys[$key]] = $element;
                    }
                }
                $row++;
            }
            return $adsArray;
        }else{
            return false;
        }
    }
}