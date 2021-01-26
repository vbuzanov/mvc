<?php
require_once __DIR__ . '/vendor/autoload.php';

use Core\Libs\Exceptions\DbException;
use Core\Libs\Exceptions\NotFoundException;
use Core\Libs\Route;
use Core\Views\View;

function correct($className){
    $classArr = explode('\\', $className);
  
    for ($i=0; $i < count($classArr)-1 ; $i++) { 
        $classArr[$i] = lcfirst($classArr[$i]);
    };
    $classN = implode('/', $classArr);
    require_once $classN. '.php';
}

spl_autoload_register('correct');

try{
    Route::start();
}
catch(DbException $e){
    echo $e->getMessage();
}
catch(NotFoundException $e){
    View::render('errors/404', [], 404);
}