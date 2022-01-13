<?php
include 'core.php';
echo '<h2>' . 'The Game' . '<h2>';

$tools = [
    TOOL_ROCK => 'Akmuo',
    TOOL_PAPER => 'Popierius',
    TOOL_SCISSORS => 'Zirkles'
];

echo '<form action="index.php" method="POST">';
echo '<select name="tool">';
foreach ($tools as $key => $tool){
    echo '<option value="'. $key .'">'. $tool .'</option>';
}
echo '</select>';
echo '<br>';

echo '<input type="submit" value="Play!!!" name="play">';
echo '</form>';

include 'history.php';