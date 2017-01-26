<?php
session_start();

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Login</title>
        
        <link type="text/css" rel="stylesheet" href="../admin/admincss.css">
        
        <link rel="stylesheet" href="../jquery-ui-1.12.1/jquery-ui.css">
        <link rel="stylesheet" href="../jquery-ui-1.12.1/jquery-ui.min.css">
        <link rel="stylesheet" href="../jquery-ui-1.12.1/jquery-ui.structure.css">
        <link rel="stylesheet" href="../jquery-ui-1.12.1/jquery-ui.structure.min.css">
        <link rel="stylesheet" href="../jquery-ui-1.12.1/jquery-ui.theme.css">
        <link rel="stylesheet" href="../jquery-ui-1.12.1/jquery-ui.theme.min.css">
                
        <script src="../jquery-ui-1.12.1/external/jquery/jquery.js"></script>
        <script src="../jquery-ui-1.12.1/jquery-ui.js"></script>
        <script src="../jquery-ui-1.12.1/jquery-ui.min.js"></script>
        
    </head>
    <body>        
        <?php
        $uInput = array('pw' => '', 'name' => '');
        $error = array('pwerr' => '', 'nameerr' => '');

        //validation form
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["name"])) {
                $error['emailerr'] = "Username is required";
            } else {
                $uInput['name'] = test_input($_POST["name"]);                
            }

            if (empty($_POST["pw"])) {
                $error['pwerr'] = "Password is required";
            } else {
                $uInput['pw'] = test_input($_POST["pw"]);
            }

            //validate email and password
            require '../admin/adminuser.php';
            //get email and password from database
            $adminUser = new Admin();
            $row = $adminUser->sql_login($uInput);
            //check whether email exist
            if ($row == "") {
                //show invalid format first
                if ($error['nameerr'] == '') {
                    $error['nameerr'] = "No user exist! Please contact security department for help.";
                }
            } else {
                //compare password
                if (!password_verify($uInput['pw'], $row['password'])) {
                    $error['pwerr'] = "Wrong Password";
                }
            }
        }
        
        function test_input($input) {
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input);
            return $input;
        }

        //check error before process form
        $isValid = TRUE;
        foreach ($error as $value) {
            if ($value) {
                $isValid = FALSE;
                break;
            }
        }

        if (isset($_POST['submit']) && $isValid) {
            $_SESSION['check'] = TRUE;
            $_SESSION['row'] = $row;
            header('Location: ../admin/adminHome.php');
        } else {
            display_reg($error, $uInput);
        }

        function display_reg($error, $uInput) {
            echo '
            <div class="suc_content">
            <div class="container">
        
            <form id="signup" method="post" action="';
            echo htmlspecialchars($_SERVER["PHP_SELF"]);
            echo '">
            <div class="header">        
            <h3>Sign In</h3><p>Welcome, administrator!</p>                
            <div class="sep"></div>            
            <div class="inputs">
            <input type="text" placeholder="Username" autofocus name="name" value="';
            echo $uInput['name'];
            echo '">            
            <input type="password" placeholder="Password" name="pw">
            <span class="error"> ';
            echo $error['pwerr'];
            echo '</span><br><br>
            <input class="submit" type="submit" name="submit" value="Submit"></span>
            </div></div></form>
            </div></div>';
        }
        
        ?>        
    </body>
</html>
