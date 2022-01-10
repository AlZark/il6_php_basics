<?php

$myfile = fopen("binary_diagnostics", "r") or die("Unable to open file!");
$actions = explode(PHP_EOL, fread($myfile, filesize("binary_diagnostics")));

fclose($myfile);

$gamma_arr = [];
$epsilon_arr = [];


for ($i = 0; $i <= 11; $i++) {
    $firstColumn0 = 0;
    $firstColumn1 = 0;
    foreach ($actions as $action) {
        if ($i < 11) {
            $binary = substr($action, $i, $i - 11);
            if ($binary == 0) {
                $firstColumn0++;
            } else {
                $firstColumn1++;
            }
        } else {
            $binary = substr($action, $i);
            if ($binary == 0) {
                $firstColumn0++;
            } elseif ($binary == 1) {
                $firstColumn1++;
            }
        }
    }
    if ($firstColumn0 > $firstColumn1) {
        $gamma_arr[] = 0;
        $epsilon_arr[] = 1;
    } else {
        $gamma_arr[] = 1;
        $epsilon_arr[] = 0;
    }
}

$gamma = implode(" ", $gamma_arr);
$epsilon = implode(" ", $epsilon_arr);

echo "Gamma: " . $gamma . '<br>' . "Epsilon: " . $epsilon . '<br>';

echo "Answer: " . bindec((str_replace(" ", "", $gamma))) *
    bindec((str_replace(" ", "", $epsilon)));