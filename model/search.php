<?php

if (isset($_POST['submit'])) {
    if (isset($_GET['go'])) {
        if ($_POST['search'] != "") {
            //connect  to the database 
            $servername = 'localhost:3306';
            $username = 'root';
            $password = '';
            $dbname = 'webapp';

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //echo "Connected successfully";
                //select data
            $stmt = $conn->prepare("SELECT id, pname, price FROM products WHERE pname LIKE :pname");
                //$stmt = $conn->prepare("SELECT email, password FROM user WHERE email LIKE '%admin%'");
            $stmt->bindParam(':pname', $pname, PDO::PARAM_STR);
            $term = $_POST['search'];
            $pname = '%'.$term.'%';
            $stmt->execute();
//            echo $term;
//            echo '<br>';
//            echo $pname;
//            $row = $stmt->fetch(PDO::FETCH_ASSOC);
//            echo $row['id'][0];
            
            //-create  while loop and loop through result set 
            if ($stmt->rowCount() > 0) {
            echo "<table><tr><th>ID</th><th>Name</th><th>Price</th></tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {                
                    echo "<tr><td>" . $row["id"] . "</td><td>" . $row["pname"] . "</td><td>" . $row["price"] . "</td></tr>";
                }
                echo "</table>";
                $conn = null;
            } else {
                echo "0 results";
                $conn = null;
            }
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
            
        } else {
            header('Location: localhost:8080/WebApp/WebApp.php');
        }
    }
}
//$search = $_GET['term'];
//
//$stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE '% :searchTerm %' ORDER BY id ASC");
//$stmt->bindParam(':searchTerm', $search);
//$stmt->execute();
//
//while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//    $data[] = $row['products'];
//}
//
//return json_encode($data);
?>