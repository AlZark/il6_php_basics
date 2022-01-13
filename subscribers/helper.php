<?php

function clearEmail($email)
{
    return trim(strtolower($email));
}

function isEmailValid($email)
{
    return strpos($email, '@') !== false;
}

function isEmailUnique($email)
{
    $subscribers = readFromCsv('subscriber_list.csv');
    foreach ($subscribers as $subscriber) {
        if ($email === $subscriber[0]) {
            return false;
        }
    }
    return true;
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