<?php

$myfile = fopen("numbers", "r") or die("Unable to open file!");
$numbers = explode(",", fread($myfile, filesize("numbers")));

fclose($myfile);

$myfile = fopen("bingo_tables", "r") or die("Unable to open file!");
$tables = explode(PHP_EOL, fread($myfile, filesize("bingo_tables")));

fclose($myfile);

//removing empty arrays
$tables = (array_filter($tables));

//dividing array into arrays of 5
$tables = (array_chunk($tables, 5));

// NEXT STEPS. SAVE VALUES IN NEW FILE
// READ FILES FROM NEW FILE
// CHANGE NUMBER INTO X AND SAVE TO FILE
// READ FILE CHECK FOR ARRAY LINE WITH ONLY X


//}
//
//function removeNumber($num, $tables){
//    foreach ($tables as $table) {
//
//        $table = str_replace($num, 'X', $table);
//
//        echo $num;
//
//        echo '<pre>';
//        print_r($table);
//        echo '</pre>';
//
//
//    }
//}