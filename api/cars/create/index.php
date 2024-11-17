<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../../../models/Car.php';
require_once __DIR__ . '/../../../models/Conector.php';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $connection = Conector::getInstance();
    $json_input = json_decode(file_get_contents('php://input'), true);
    if(!file_exists('log.txt')){
        $log = fopen('log.txt', 'w');   
    }else{
        $log = fopen('log.txt', 'a');
    }
    fwrite($log, json_encode($_POST)."\n");
    fwrite($log, "JSON:\n");
    fwrite($log, json_encode($json_input)."\n");    
    fclose($log);
    if(empty($json_input['brand']) || empty($json_input['model']) || empty($json_input['year']) || empty($json_input['price']) || empty($json_input['color'])){
        http_response_code(400);
        echo json_encode(['success' => false, 'message'=>'Faltan datos']);
        exit;
    }
    $brand = $json_input['brand'];
    $model = $json_input['model'];
    $year = $json_input['year'];
    $price = $json_input['price'];
    $color = $json_input['color'];

    $car = new Car($connection);
    $existing_car = $car->exists($brand, $model, $year, $color);
    
    if($existing_car){
        http_response_code(400);
        echo json_encode(['success' => false, 'message'=>'El coche ya existe']);
        exit;
    }
    $result = $car->create($brand, $model, $year, $price, $color);

    //write a log file with the request data

    if($result){
        http_response_code(201);
        echo json_encode(['success' => true, 'message'=>'Coche creado correctamente']);
    }else{
        http_response_code(500);
        echo json_encode(['success' => false, 'message'=>'Error al crear el coche']);   
    }


}else{
    http_response_code(405);
    echo json_encode(['success' => false, 'message'=>'Método no permitido']);   
}   