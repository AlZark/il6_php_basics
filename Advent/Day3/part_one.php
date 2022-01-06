<?php

$myfile = fopen("binary_diagnostics", "r") or die("Unable to open file!");
$actions = explode(PHP_EOL, fread($myfile, filesize("binary_diagnostics")));

fclose($myfile);

//var_dump($actions);

$firstColumn0 = 0;
$firstColumn1 = 0;

foreach ($actions as $action) {
    $binary = substr($action, 0, -11);
    if ($binary == 0){
        $firstColumn0++;
    } else {
        $firstColumn1++;
    }
}

if ($firstColumn0 > $firstColumn1){
    echo "Gamma 0" . "<br>";
} else {
    echo "Epsilon 1";
}

