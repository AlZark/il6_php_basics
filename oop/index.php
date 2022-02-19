<?php
date_default_timezone_set('Europe/Vilnius');
include 'vendor/autoload.php';
include 'config.php';
session_start();

if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] !== '/'){
    $path = trim($_SERVER['PATH_INFO'],'/');
    $path = explode('/',$path);
    //print_r($path);
    $class = ucfirst($path[0]);
    if(isset($path[1])){
        $method = $path[1];
    } else {
        $method = 'index';
    }

    $class = '\Controller\\'.$class;
    if(class_exists($class)) {
        $obj = new $class();
        if(method_exists($obj, $method)){
            if(isset($path[2])) {
                $obj->$method($path[2]);
            }else{
                $obj->$method();
            }
        }else{
            $error = new \Controller\Error();
            $error->error404();
        }
    }else{
        $error = new \Controller\Error();
        $error->error404();
    }
}else{
    $obj = new \Controller\Home();
    $obj->index();
}