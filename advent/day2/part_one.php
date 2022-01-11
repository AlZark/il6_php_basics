<?php

$myfile = fopen("movements", "r") or die("Unable to open file!");
$actions = explode(PHP_EOL, fread($myfile, filesize("movements")));

fclose($myfile);

$vertical = 0;
$horizontal = 0;

foreach ($actions as $action) {
    switch ($action) {
        case strpos($action, 'forward'):
            $horizontal += substr($action, 7);
            break;
        case strpos($action, 'down'):
            $vertical += substr($action, 5);
            break;
        case strpos($action, 'up'):
            $vertical -= substr($action, 3);
            break;
    }
}

echo $vertical * $horizontal;