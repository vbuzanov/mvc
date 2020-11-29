<?php


use Core\Libs\Route;

function correct($className){
    $classArr = explode('\\', $className);
  
    for ($i=0; $i < count($classArr)-1 ; $i++) { 
        $classArr[$i] = lcfirst($classArr[$i]);
    };
    $classN = implode('/', $classArr);
    require_once $classN. '.php';
}

spl_autoload_register('correct');




Route::start();
