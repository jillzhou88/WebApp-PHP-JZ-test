<?php
session_start();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Registration</title>
        <style>
            .error {color: #FF0000;}
        </style>
        <!-- css -->
        <link type="text/css" rel="stylesheet" href="./css/global.css">
        <link type="text/css" rel="stylesheet" href="./css/style.css">
        <link type="text/css" rel="stylesheet" href="./css/index.css">
        <link type="text/css" rel="stylesheet" href="./css/cssfaq.css">
        <link type="text/css" rel="stylesheet" href="./css/signup.css">
    </head>
    <body>
        <!-- top bar -->
        <div class='g-doc'>
            <header class='g-hd'>                
                <div class='m-sitenav'>
                    <div class='wrap'>

                        <!-- top left links -->
                        <div class='m-miprdct'>
                            <ul calss='list'>
                                <li><a href="http://www.amazon.com/" target="_blank">Amazon</a></li>
                                <li class='u-sep'>|</li>
                                <li><a href="http://www.bestbuy.com/" target="_blank">Bestbuy</a></li>
                                <li class='u-sep'>|</li>
                                <li><a href="http://www.Newegg.com/" target="_blank">Newegg</a></li>
                                <li class='u-sep'>|</li>
                                <li><a href="http://www.amazon.com/" target="_blank">Amazon</a></li>
                            </ul>
                        </div>

                        <!-- top right login/registration -->
                        <ul class='m-pctrl j-pctrl f-cb'>
                            <?php
                            if (!isset($_SESSION['check']) || ($_SESSION['check'] == FALSE)) {
                                echo '<li class="itm login j-login" ><a href="LogIn.php" id="gotologin">Login</a> / <a href="Register.php" hidefocus="hidefocus">Registration</a></li>';
                            } else {

                                echo '
                            <li class="itm person j-person">
                            <div class="u-dwnmenu u-dwnmenu-pop">
                            <div class="ttl">
                            <a href="AccountHome.php" class="txt" id="username" hidefocus="hidefocus">';
                                echo $_SESSION['row']['email'];
                                echo '
                            </a>                            
                            </div>
                            <div class="cnt">
                            <ul class="list">
                            <li><a href="AccountHome.php">Account Home</a></li>
                            <li><a href="Order.php">Order History </a></li>
                            <li><a href="settings.php">Settings</a></li>                            
                            </ul>
                            <ul class="list list1">                            
                            <li><a href="./control/logout.php">Logout</a></li>
                            </ul>
                            </div>
                            </div>
                            
                            <li class="itm u-sep">|</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </header>
        </div>

        <!-- Logo & search -->
        <div class='m-header'>
            <div class='wrap'>

                <!-- logo -->
                <div class='m-logo'><a href="/" title='WebApp'>WebApp</a></div>

                <!-- search -->
                <form  method="post" action="./model/search.php?go"  id="searchform">
                    <div class='u-search'>                    
                        <div class='form'>                         
                            <input type="search" name="search" class="text" spellcheck="false" autocapitalize="off" 
                                   autocomplete="off" autocorrect="off" hidefocus="hidefocus" placeholder='Search WebApp...'/>
                            <button class='icn-search2' type='submit' name='submit' value='Search'>
                                <image src='./image/searchbutton.png'height="25" width="25"/></button>
                        </div>
                    </div>
                </form>                
            </div>

            <!-- navigation bar -->
            <nav class="m-nav" style="overflow: hidden;">
                <ul class="f-cb" >
                    <li id="index" class=""><a href="" hidefocus="hidefocus">Computer Systems</a></li>                    
                    <li id="rank" class=""><a href="" hidefocus="hidefocus">Components</a></li>
                    <li id="review" class=""><a href="" hidefocus="hidefocus">Electronics</a></li>
                    <li id="bargain" class=""><a href="" hidefocus="hidefocus">Gaming</a></li>
                    <li id="category" class=""><a href="" hidefocus="hidefocus">Software & Services</a></li>                    
                </ul>
            </nav>
        </div>


        <?php
        $uInput = array('email' => '', 'upassword' => '', 'firstname' => '', 'lastname' => '');
        $error = array('emailerr' => '', 'upassworderr' => '', 'passConfirm' => '');

        //validation form
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["email"])) {
                $error['emailerr'] = "Email is required";
            } else {
                $uInput['email'] = test_input($_POST["email"]);
                //check email address
                if (!filter_var($uInput['email'], FILTER_VALIDATE_EMAIL)) {
                    $error['emailerr'] = "Invalid email format";
                }
            }

            if (empty($_POST["upassword"])) {
                $error['upassworderr'] = "Password is required";
            } else {
                $uInput['upassword'] = test_input($_POST["upassword"]);
                $uInput['upassword'] = password_hash($uInput['upassword'], PASSWORD_BCRYPT);
            }

            //password confirm
            if (empty($_POST['passConfirm'])) {
                $error['passConfirm'] = "Please confirm password";
            }

            if ($_POST['upassword'] != $_POST['passConfirm']) {
                $error['passConfirm'] = "Password does not match";
            }

            $uInput['firstname'] = test_input($_POST["firstname"]);
            $uInput['lastname'] = test_input($_POST["lastname"]);
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
            process_form($uInput);
            header('Location: WebApp.php');
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
            <h3>Sign Up</h3><p>Welcome, New Customer!</p>                
            <div class="sep"></div>            
            <div class="inputs">
            <input type="email" placeholder="E-mail" autofocus name="email" value="';
            echo $uInput['email'];
            echo '">
            <span class="error"> ';
            echo $error['emailerr'];
            echo '</span>
            <input type="password" placeholder="Password" name="upassword">
            <span class="error"> ';
            echo $error['upassworderr'];
            echo '</span>
            <input type="password" placeholder="Confirm Password" name="passConfirm">
            <span class="error"> ';
            echo $error['passConfirm'];
            echo '</span>
            <input type="text" placeholder="Firstname" name="firstname" value="';
            echo $uInput['firstname'];
            echo '">
            <input type="text" placeholder="Lastname" type="text" name="lastname" value="';
            echo $uInput['lastname'];
            echo '"><br><br>
            <input class="u-btn2 j-buy" type="submit" name="submit" value="Register"></span>
            </div></div></form>
            </div></div>';
        }

        function process_form($uInput) {
            require './model/Member.php';

            $member = new Member();
            $member->sql_insert($uInput);
        }
        ?>

        <!-- footer -->
        <footer class="g-ft">
            <div class="wrap">
                <div class="m-corp">
                    <p>
                        <a href="aboutus.php">About Us</a><span class="u-sep">|</span>
                        <a href="contact.php">Contact Us</a><span class="u-sep">|</span>
                        <a href="jobs.php">Join Us</a><span class="u-sep">|</span>
                        <a href="faq.php">FAQ</a>
                    </p>
                </div>
                <div class="m-cprt">
                    <p><em>Site Feedback</em></p>
                    <a class="mail" href="mailto:jillzhou88@gmail.com?subject=Website Feedback" hidefocus="hidefocus">jillzhou88@gmail.com</a>
                </div>
            </div>
        </footer>
    </body>
</html>
