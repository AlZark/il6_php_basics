<?php

const TOOL_ROCK = 'rock';
const TOOL_PAPER = 'paper';
const TOOL_SCISSORS = 'scissors';
const GAME_OUTCOME = 1;

$toolsArray = [
    0 => TOOL_ROCK,
    1 => TOOL_PAPER,
    2 => TOOL_SCISSORS
];

if (isset($_POST['play'])) {
    $playerChoice = $_POST['tool'];
    $pcChoice = rand(0, 2);
    $pcChoice = $toolsArray[$pcChoice];

    echo '<table>';
    echo '<tr><td><img src="img/' . $playerChoice . '.jpg" width="200"></td><td>VS</td><td><img src="img/' . $pcChoice . '.jpg" width="200"></td></tr>';
    echo '</table>';

    if ($playerChoice == $pcChoice) {
        $result = 'Draw';
        echo $result;
    } elseif ($playerChoice == TOOL_ROCK && $pcChoice == TOOL_SCISSORS) {
        $result = 'Player wins!';
        echo $result;
    } elseif ($playerChoice == TOOL_PAPER && $pcChoice == TOOL_ROCK) {
        $result = 'Player wins!';
        echo $result;
    } elseif ($playerChoice == TOOL_SCISSORS && $pcChoice == TOOL_PAPER) {
        $result = 'Player wins!';
        echo $result;
    } else {
        $result = 'PC wins!';
        echo $result;
    }

    $next_id = getNextGameId();
    $data = [];
    $data[] = [$next_id, $result, $playerChoice, $pcChoice];
    writeToCsv($data, 'play_history.csv');
}


function writeToCsv($data, $fileName)
{
    $file = fopen($fileName, 'a');
    foreach ($data as $element) {
        fputcsv($file, $element);
    }
    fclose($file);
}

function readFromCsv($fileName)
{
    $data = [];
    $file = fopen($fileName, "r");
    while (!feof($file)) {
        $line = fgetcsv($file);
        if (!empty($line)) {
            $data[] = $line;
        }
    }
    fclose($file);
    return $data;
}

function getNextGameId()
{
    $games = readFromCsv('play_history.csv');
    $count = sizeof($games);
    return $count + 1;
}