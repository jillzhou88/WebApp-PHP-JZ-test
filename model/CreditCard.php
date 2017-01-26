<?php

class CreditCard {

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

    public function insertCard($data) {
        //prepare and bind parameters
        $stmt = $this->conn->prepare("INSERT INTO creditcard (email, name, number, date,
                scode, isPrimary) VALUES (:email, :name, :number, :date, :scode, :isPrimary)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':number', $number);        
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':scode', $scode);
        $stmt->bindParam(':isPrimary', $isPrimary);

        //insert
        $email = $data['email'];
        $name = $data['name'];
        $number = $data['number'];
        $date = $data['date'];
        $scode = $data['scode'];
        $isPrimary = $data['isPrimary'];

        $stmt->execute();

        $conn = null;
    }
    
    public function getPC($email) {
        $stmt = $this->conn->prepare("SELECT id, name, number, date, scode, isPrimary 
                FROM creditcard WHERE email=:email AND isPrimary=1");
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $primaryCard = $stmt->fetch(PDO::FETCH_ASSOC);

        $conn = null;

        return $primaryCard;
    }

    public function getCard($email){
        $stmt = $this->conn->prepare("SELECT id, name, number, date, isPrimary FROM creditcard
                WHERE email=:email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $creditCards = array();

        while ($card = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $creditCards[] = $card;
        };

        $conn = null;

        return $creditCards;
    }
    
    public function findCard($id){
        $stmt = $this->conn->prepare("SELECT id, name, number, date, isPrimary 
                FROM creditcard WHERE id=:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        $card = $stmt->fetch(PDO::FETCH_ASSOC);

        $conn = null;

        return $card;
    }
    
    public function updatePC($id, $setPrimary){
        $stmt = $this->conn->prepare("UPDATE creditcard SET isPrimary=:setPrimary WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':setPrimary', $setPrimary);
        $stmt->execute();
        
        $conn = null;
    }

    public function deleteCard($id) {
        $stmt = $this->conn->prepare("DELETE FROM creditcard WHERE id=:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $conn = null;
    }
}

?>

