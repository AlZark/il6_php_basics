<?php
include 'helper.php';

$email = $_POST['email'];

$email = clearEmail($email);

if (isEmailValid($email) && isEmailUnique($email, EMAIL_FIELD_KEY, 'subscriber_list.csv'))
{
    $data[] = [$email];
    writeToCsv($data, 'subscriber_list.csv');
    echo 'Thank you for signing up';
} else {
    echo 'Invalid email address';
}