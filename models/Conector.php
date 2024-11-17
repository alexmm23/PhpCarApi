<?php

class Conector extends mysqli {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $db = 'practica_mysql';
    private $conn;
    private static $instance = null;

    // Singleton
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db);
        self::$instance = $this->conn;
        if ($this->conn->connect_error) {
            die('Error de conexión: ' . $this->conn->connect_error);
        }
        $this->conn->set_charset('utf8');
    }

    public function __destruct() {
        $this->conn->close();
    }

    public function query(string $query, int $result_mode = MYSQLI_STORE_RESULT): mysqli_result|bool {
        $result = $this->conn->query($query, $result_mode);
        if (!$result) {
            die('Error en la consulta: ' . $this->conn->error);
        }
        return $result;
    }

    public function showTables() {
        $result = $this->query("SHOW TABLES");
        if ($result) {
            while ($row = $result->fetch_array()) {
                echo $row[0] . "\n";
            }
        } else {
            echo "No tables found.";
        }
    }
}