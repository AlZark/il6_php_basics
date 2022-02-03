<?php
include 'vendor/autoload.php';
include 'config.php';

if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] !== '/'){
    $path = trim($_SERVER['PATH_INFO'],'/');
    //echo '<pre>';
    $path = explode('/',$path);
    //print_r($path);
    $class = ucfirst($path[0]);
    $method = $path[1];
    $param = $path[2];

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
            echo '404';
        }
    }else{
        echo '404';
    }
}else{
    echo 'home page';
}