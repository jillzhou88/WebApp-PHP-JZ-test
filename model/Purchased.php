<?php

class Purchased {

    public $servername = 'localhost:3306';
    public $username = 'root';
    public $password = '';
    public $dbname = 'webapp';
    public $conn;

    public function __construct() {
        $this->conn = new PDO("mysql:host=$this->servername; dbname=$this->dbname", $this->username, $this->password);
        try {
            //set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }

//    public function findItem($data) {
//        $stmt = $this->conn->prepare("SELECT id from cart WHERE id=:id");
//        $stmt->bindParam(':id', $data['id']);
//        $stmt->execute();
//
//        $item = $stmt->fetch(PDO::FETCH_ASSOC);
//
//        $conn = null;
//
//        if ($item == "") {
//            return FALSE;
//        } else {
//            return TRUE;
//        }
//    }

    public function getQty($data) {
        $stmt = $this->conn->prepare("SELECT qty FROM cart WHERE id=:id");
        $stmt->bindParam(':id', $data['id']);
        $stmt->execute();

        $qty = $stmt->fetch(PDO::FETCH_ASSOC);

        $conn = null;

        return $qty;
    }

    public function addPurchased($data) {
        $stmt = $this->conn->prepare("INSERT INTO upurchased (orderId, productId, qty)
                    VALUES (:orderId, :productId, :qty)");
        $stmt->bindParam(':orderId', $data['orderId']);
        $stmt->bindParam(':productId', $data['productId']);
        $stmt->bindParam(':qty', $data['qty']);
        $stmt->execute();

        $conn = null;
    }

    public function getCart($email) {
        $stmt = $this->conn->prepare("SELECT cart.id, cart.qty, products.pname, products.price 
                FROM cart INNER JOIN products ON cart.id=products.id WHERE cart.email=:email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $cartItem = array();

        while ($cart = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cartItem[] = $cart;
        };

        $conn = null;

        return $cartItem;
    }

    public function updateQty($data) {
        if ($data['qty'] == 0) {
            $stmt = $this->conn->prepare("DELETE FROM cart WHERE id=:id");
            $stmt->bindParam('id', $data['id']);
            $stmt->execute();
        } else {
            $stmt = $this->conn->prepare("UPDATE cart SET qty=:qty WHERE id=:id");
            $stmt->bindParam(':qty', $data['qty']);
            $stmt->bindParam(':id', $data['id']);
            $stmt->execute();
        }


        $conn = null;
    }
    
    public function deleteCart($email){
        $stmt = $this->conn->prepare("DELETE FROM cart WHERE email=:email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $conn = null;
    }

}
?>

