<?php



require_once '../../../models/Car.php';
require_once '../../../models/Conector.php';


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $connection = Conector::getInstance();
    $json_input = json_decode(file_get_contents('php://input'), true);
    if(!file_exists('log.txt')){
        $log = fopen('log.txt', 'w');
    }else{
        $log = fopen('log.txt', 'a');
    }
    fwrite($log, json_encode($_GET)."\n");
    fwrite($log, json_encode($_POST)."\n");
    fwrite($log, "JSON:\n");
    fwrite($log, json_encode($json_input)."\n");
    fclose($log);
    $id = $_GET['id'];
    $brand = $json_input['brand'];
    $model = $json_input['model'];
    $year = $json_input['year'];
    $price = $json_input['price'];
    $color = $json_input['color'];
    
    $car = new Car($connection);
    $result = $car->update($id, $brand, $model, $year, $price, $color);
    if($result){
        http_response_code(200);
        
        echo json_encode(['success' => true, 'message'=>'Coche actualizado correctamente']);    
    }else{
        http_response_code(500);
        echo json_encode(['success' => false, 'message'=>'Error al actualizar el coche']);
    }
}else{
    http_response_code(405);
    echo json_encode(['success' => false, 'message'=>'Método no permitido']);
}