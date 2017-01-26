<?php

class Order {

    public $servername = 'localhost:3306';
    public $username = 'root';
    public $password = '';
    public $dbname = 'webapp';
    public $conn;

    //public $email, $upassword;

    public function __construct() {
        $this->conn = new PDO("mysql:host=$this->servername; dbname=$this->dbname", $this->username, $this->password);
        try {
            //set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }

    public function insertOrder($data) {
        //prepare and bind parameters
        $stmt = $this->conn->prepare("INSERT INTO uorder (id, email, addressId, cardId,
                shipping, total) VALUES (:id, :email, :addressId, :cardId, :shipping, :total)");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':addressId', $addressId);
        $stmt->bindParam(':cardId', $cardId);
        $stmt->bindParam(':shipping', $shipping);
        $stmt->bindParam(':total', $total);
        
        //insert
        $id = $data['id'];
        $email = $data['email'];
        $addressId = $data['addressId'];
        $cardId = $data['cardId'];
        $shipping = $data['shipping'];
        $total = $data['total'];        
        $stmt->execute();

        $conn = null;
    }
    
    public function getOrder($email) {
        $stmt = $this->conn->prepare("SELECT id, email, addressId, cardId, shipping,
                total, date, status FROM uorder WHERE email=:email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $orderBook = array();

        while ($order = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $orderBook[] = $order;
        };

        $conn = null;

        return $orderBook;
    }
    
    public function findOrder($id){
        $stmt = $this->conn->prepare("SELECT id, email, addressId, cardId, shipping,
                total, date, status FROM uorder WHERE id=:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        $conn = null;

        return $order;
    }
    
    public function updateAddress($id, $aid){
        $stmt = $this->conn->prepare("UPDATE uorder SET addressId=:addressId WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':addressId', $aid);
        $stmt->execute();
        
        $conn = null;
    }
    
    public function updateCard($id, $cid){
        $stmt = $this->conn->prepare("UPDATE uorder SET cardId=:cardId WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':cardId', $cid);
        $stmt->execute();
        
        $conn = null;
    }
    
    public function updateStatus($id, $status){
        $stmt = $this->conn->prepare("UPDATE uorder SET status=:status WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        
        $conn = null;
    }

    public function deleteOrder($id) {
        $stmt = $this->conn->prepare("DELETE FROM uorder WHERE id=:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $conn = null;
    }

}
?>

