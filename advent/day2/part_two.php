<?php

$myfile = fopen("movements", "r") or die("Unable to open file!");
$actions = explode(PHP_EOL, fread($myfile, filesize("movements")));

fclose($myfile);

$vertical = 0;
$horizontal = 0;
$aim = 0;

foreach ($actions as $action) {
    switch ($action) {
        case strpos($action, 'forward'):
            $horizontal += substr($action, 7);
            $vertical += substr($action, 7) * $aim;
            break;
        case strpos($action, 'down'):
            $aim += substr($action, 5);
            break;
        case strpos($action, 'up'):
            $aim -= substr($action, 3);
            break;
    }
}

echo $vertical * $horizontal;