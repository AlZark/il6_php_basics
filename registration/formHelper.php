<?php

function generateInput($data)
{
    $input = '';
    $input .= '<input ';
    foreach ($data as $key => $value) {
        $input .= $key . '="' . $value . '" ';
    }
    $input .= '>';
    return $input;
}

function generateTextarea($data){
    $text = '';
    $text .= '<textarea ';
    foreach ($data as $key => $value) {
        $text .= $key . '="' . $value . '" ';

    }
    $text .= '> </textarea>';
    return $text;
}


function generateSelect($data)
{
    $select = '';
    $select .= '<select name ="' . $data['name'] . '" id="' . $data['name'] . '" >';
    foreach ($data as $value) {
        if (is_array($value)) {
            foreach ($value as $option)
                $select .= '<option value="' . $option . '">' . $option . '</option>';
        }
    }
    $select .= '</select>';
    return $select;
}


//function clearEmail($email)
//{
//    return trim(strtolower($email));
//}
//
//function isEmailValid($email)
//{
//    return strpos($email, '@') !== false;
//}
//
//function writeToCsv($data, $fileName)
//{
//    $file = fopen($fileName, 'a');
//    foreach ($data as $element) {
//        fputcsv($file, $element);
//    }
//    fclose($file);
//}