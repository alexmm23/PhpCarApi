<?php

require_once '../../models/Car.php';  
require_once '../../models/Conector.php';  
$connection = Conector::getInstance();
$car = new Car($connection);

if($_SERVER['REQUEST_METHOD'] === 'GET'){
   
    $cars = $car->getAll();
    if($cars && count($cars) > 0){  
        http_response_code(200);    
        echo json_encode($cars);
    }else{
        http_response_code(404);
        echo json_encode([]);   
    }
}else{
    http_response_code(405);
    echo json_encode([]);   
}