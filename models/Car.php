<?php

class Car{
    private $conn;
    public function __construct($conn){
        $this->conn = $conn;
    }

    public function getAll(){
        $sql = 'SELECT * FROM cars';
        $result = $this->conn->query($sql);
        $cars = [];
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $cars[] = $row;
            }
        }
        return $cars;
    }

    public function getById($id){
        $sql = "SELECT * FROM cars WHERE id = $id";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }

    public function create($brand, $model, $year, $price, $color){
        $sql = "INSERT INTO cars (brand, model, year, price, color) VALUES ('$brand', '$model', $year, $price, '$color')";
        return $this->conn->query($sql);
    }
    public function update($id, $brand, $model, $year, $price, $color){
        $sql = "UPDATE cars SET brand = '$brand', model = '$model', year = $year, price = $price, color = '$color' WHERE id = $id";
        return $this->conn->query($sql);
    }   

    public function delete($id){
        $sql = "DELETE FROM cars WHERE id = $id";
        return $this->conn->query($sql);
    }
    public function exists($brand, $model, $year, $color){
        $sql = "SELECT COUNT(*) AS count FROM cars WHERE brand = '$brand' AND model = '$model' AND year = $year AND color = '$color'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['count'] > 0;
    }
    public function existsById($id){
        $sql = "SELECT COUNT(*) AS count FROM cars WHERE id = $id";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['count'] > 0;
    }
}