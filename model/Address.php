<?php

class Address {

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

    public function insertAddress($data) {
        //prepare and bind parameters
        $stmt = $this->conn->prepare("INSERT INTO address (email, firstname, lastname, 
                addressln1, addressln2, city, state, zip, phone, isPrimary)
                VALUES (:email, :firstname, :lastname, :addressln1, :addressln2,
                :city, :state, :zip, :phone, :isPrimary)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':addressln1', $addressln1);
        $stmt->bindParam(':addressln2', $addressln2);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':zip', $zip);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':isPrimary', $isPrimary);

        //insert
        $email = $data['email'];
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $addressln1 = $data['addressln1'];
        $addressln2 = $data['addressln2'];
        $city = $data['city'];
        $state = $data['state'];
        $zip = $data['zip'];
        $phone = $data['phone'];
        $isPrimary = $data['isPrimary'];
        $stmt->execute();

        $conn = null;
    }

    public function getPA($email) {
        $stmt = $this->conn->prepare("SELECT id, firstname, lastname, addressln1,
                addressln2, city, state, zip, phone, isPrimary FROM address WHERE
                email=:email AND isPrimary=1");
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $primaryAddress = $stmt->fetch(PDO::FETCH_ASSOC);

        $conn = null;

        return $primaryAddress;
    }

    public function getAddress($email) {
        $stmt = $this->conn->prepare("SELECT id, firstname, lastname, addressln1,
                addressln2, city, state, zip, phone, isPrimary FROM address WHERE
                email=:email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $addressBook = array();

        while ($address = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $addressBook[] = $address;
        };

        $conn = null;

        return $addressBook;
    }
    
    public function findAddress($id){
        $stmt = $this->conn->prepare("SELECT firstname, lastname, addressln1,
                addressln2, city, state, zip, phone, isPrimary FROM address WHERE
                id=:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        $address = $stmt->fetch(PDO::FETCH_ASSOC);

        $conn = null;

        return $address;
    }
    
    public function updatePA($id, $setPrimary){
        $stmt = $this->conn->prepare("UPDATE address SET isPrimary=:setPrimary WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':setPrimary', $setPrimary);
        $stmt->execute();
        
        $conn = null;
    }

    public function deleteAddress($id) {
        $stmt = $this->conn->prepare("DELETE FROM address WHERE id=:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $conn = null;
    }

}
?>

