<?php

$myfile = fopen("binary_diagnostics", "r") or die("Unable to open file!");
$result = explode(PHP_EOL, fread($myfile, filesize("binary_diagnostics")));

fclose($myfile);

$oxygen = $result;
$co2 = $result;
$o_count = 0;
$co2_count = 0;
$gas_value = 0;

findOxygenRating($oxygen, $o_count, "Oxygen");
findOxygenRating($co2, $co2_count, "Co2");



function findOxygenRating($gas, $gas_count, $gas_type)
{
    if (count($gas) > 1) {
        ratingCheck($gas, $gas_count, $gas_type);
    } else {
        $answer = implode(",", $gas);
        echo bindec($answer) . '<br>';
    }
}

function ratingCheck($gas, $gas_count, $gas_type)
{
    $binary0 = 0;
    $binary1 = 0;
    if ($gas_count < 11) {
        foreach ($gas as $rating) {
            $binary = substr($rating, $gas_count, $gas_count - 11);
            if ($binary == 1) {
                $binary0++;
            } else {
                $binary1++;
            }
        }
    } else {
        foreach ($gas as $rating) {
            $binary = substr($rating, 11);
            if ($binary == 0) {
                $binary0++;
            } else {
                $binary1++;
            }
        }
    }

    if ($gas_type == "Oxygen") {
        if ($binary0 >= $binary1) {
            rmvIncorrectGasRatings(1, $gas, $gas_count, $gas_type);
        } else {
            rmvIncorrectGasRatings(0, $gas, $gas_count, $gas_type);
        }
    } else {
        if ($binary0 >= $binary1) {
            rmvIncorrectGasRatings(0, $gas, $gas_count, $gas_type);
        } else {
            rmvIncorrectGasRatings(1, $gas, $gas_count, $gas_type);
        }
    }
}

function rmvIncorrectGasRatings($number, $gas, $gas_count, $gas_type)
{
    $gasNew = [];
    if ($gas_count < 11) {
        foreach ($gas as $rating) {
            $binary = substr($rating, $gas_count, $gas_count - 11);
            if ($binary == $number) {
                $gasNew[] = $rating;
            }
        }
    } else {
        foreach ($gas as $rating) {
            $binary = substr($rating, 11);
            if ($binary == $number) {
                $gasNew[] = $rating;
            }
        }
    }
    $gas_count++;
    $gas = $gasNew;
    findOxygenRating($gas, $gas_count, $gas_type);
}

function debug($data)
{
    echo '<pre>';
    var_dump($data);
    die();
}
