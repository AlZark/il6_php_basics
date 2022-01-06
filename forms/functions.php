<?php
//
//if ($_POST) {
//
//    $number_a = $_POST['number_a'];
//    $number_b = $_POST['number_b'];
//    $action = $_POST['action'];
//
////    function calculate($number_a, $number_b, $action){
////        if ($action == 'add'){
////            return $number_a + $number_b;
////        } elseif ($action == 'multiply'){
////            return $number_a * $number_b;
////        } elseif ($action == 'divide'){
////            return $number_a / $number_b;
////        } elseif ($action == 'deduct'){
////            return $number_a - $number_b;
////        }
////    }
//
//    function calculate($number_a, $number_b, $action)
//    {
//        switch ($action) {
//            case 'add':
//                echo $number_a + $number_b;
//                break;
//            case 'multiply':
//                echo $number_a * $number_b;
//                break;
//            case 'divide':
//                echo $number_a / $number_b;
//                break;
//            case 'deduct':
//                echo $number_a - $number_b;
//                break;
//        }
//    }
//
//    calculate($number_a, $number_b, $action);
//
//
//    $userEmail = $_POST['email'];
//
//    function clearEmail($email)
//    {
//        return trim(strtolower($email));
//    }
//
//    function isEmailValid($email)
//    {
//        //return strpos($email, '@') !== false;
//        if (strpos($email, '@')) {
//            return true;
//        } else {
//            return false;
//        }
//    }
//
//    if (isEmailValid($userEmail)) {
//        echo clearEmail($userEmail);
//    } else {
//        echo 'Invalid email';
//    }
//}

$name = $_POST['name'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

function clearEmail($email)
{
    return trim(strtolower($email));
}

function isEmailValid($email)
{
    if (strpos($email, '@')) {
        return true;
    } else {
        echo 'Invalid email';
    }
}

function getNickName($name, $lastname)
{
    return trim(strtolower(substr($name, 0, 3) . substr($lastname, 0, 3)) . rand(1, 100));
}

function isPasswordValid($password, $password2)
{
    if (strlen($password) > 5) {
        if ($password == $password2) {
            return true;
        } else {
            echo 'Passwords do not match';
        }
    } else {
        echo 'Password must be at least 6 charecters long';
    }
}

function register($name, $lastname, $email, $password, $password2)
{
    if (isEmailValid(clearEmail($email))) {
        if (isPasswordValid($password, $password2)) {
            echo "Welcome " . $name . " " . $lastname;
            echo "<br>" . "Your email is: " . $email;
            echo "<br>" . "Your Username is: " . getNickName($name, $lastname);
        }
    }
}

register($name, $lastname, $email, $password, $password2);

