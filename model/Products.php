<?php
class Products {
    public $servername = 'localhost:3306';
    public $username = 'root';
    public $password = '';
    public $dbname = 'webapp';
    public $conn;

public function __construct() {
        $this->conn = new PDO("mysql:host=$this->servername; dbname=$this->dbname",
                $this->username, $this->password);
        try {
            //set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }
    
    public function getProducts($data){
        $stmt = $this->conn->prepare("SELECT id, pname, price, department, store, 
                description, image FROM products WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $id = $data;
        $stmt->execute();
        
        $products = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $conn = null;
        
        return $products;
    }
    
    public function updateQty($data) {
        $stmt = $this->conn->prepare("UPDATE products SET qty=:qty WHERE id=:id");
        $stmt->bindParam(':qty', $data['qty']);
        $stmt->bindParam(':id', $data['id']);
        $stmt->execute();

        $conn = null;
    }

}
?>