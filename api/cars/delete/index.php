<?php



require_once '../../../models/Car.php';

require_once '../../../models/Conector.php';

if($_SERVER['REQUEST_METHOD'] === 'DELETE'){

    $connection = Conector::getInstance();

    $id = $_GET['id'];

    $car = new Car($connection);
    $car_exists = $car->existsById($id);
    if(!$car_exists){
        http_response_code(404);
        echo json_encode(['success' => false, 'message'=>'El coche no existe']);
        exit;
    }
    $result = $car->delete($id);

    if($result){
        http_response_code(200);
        echo json_encode(['success' => true, 'message'=>'Coche eliminado correctamente']);
    }else{
        http_response_code(500);
        echo json_encode(['success' => false, 'message'=>'Error al eliminar el coche']);
    }   
}