<?php

class Member {

    public $servername = 'localhost:3306';
    public $username = 'root';
    public $password = '';
    public $dbname = 'webapp';
    public $conn;
    
    public $email, $upassword;

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

    public function sql_insert($data) {
        //prepare and bind parameters
        $stmt = $this->conn->prepare("INSERT INTO user (email, password, firstname, lastname)
                VALUES (:email, :password, :firstname, :lastname)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $upassword);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        
        //insert
        $email = $data['email'];
        $upassword = $data['upassword'];
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $stmt->execute();
        
//        echo "New Record created successfully";
//        echo "password is: ".$data['upassword'];
        $conn = null;
    }
    
    public function sql_login($data){
        $stmt = $this->conn->prepare("SELECT email, password FROM user
                WHERE email=:email ");
        $stmt->bindParam(':email', $email);
        
        //select data
        $email = $data['email'];
        $stmt->execute();       
                        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $conn = null;
        
        return $row;        
    }

}
?>