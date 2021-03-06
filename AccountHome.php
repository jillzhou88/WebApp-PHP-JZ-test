<?php
session_start();
require "./model/Address.php";
require "./model/CreditCard.php";

if (!isset($_SESSION['check']) || ($_SESSION['check'] == FALSE)) {
    header('Location:WebApp.php');
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Account Home</title>

        <!-- css -->
        <link type="text/css" rel="stylesheet" href="./css/global.css">
        <link type="text/css" rel="stylesheet" href="./css/style.css">
        <link type="text/css" rel="stylesheet" href="./css/index.css">
        <link type="text/css" rel="stylesheet" href="./css/account.css">
        
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
                            </div>';
                            }
                            ?>
                            <li class="itm u-sep">|</li>

                            <!-- Shopping Cart -->
                            <li class="itm login j-login">
                                <a href="ShoppingCart.php" >ShoppingCart</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>
        </div>

        <!-- Logo & search -->
        <div class='m-header'>
            <div class='wrap'>

                <!-- logo -->
                <div class='m-logo'><a href="WebApp.php" title='WebApp'>WebApp</a></div>

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
                    <li id="index" class=""><a href="" >Computer Systems</a></li>                    
                    <li id="rank" class=""><a href="" >Components</a></li>
                    <li id="review" class=""><a href="" >Electronics</a></li>
                    <li id="bargain" class=""><a href="" >Gaming</a></li>
                    <li id="category" class=""><a href="" >Software & Services</a></li>                    
                </ul>
            </nav>
        </div>

        <!-- account page -->
        <div class="dash">    
            <div style="display:flex; position:relative; margin:0 auto;">
                <!-- left container -->
                <div class='dashcontainer'> 
                    <!-- recent orders -->
                    <div class="label">
                        <div class="labelheader">
                            <h3>Recent Orders</h3>
                            <div class="sep"></div>
                        </div>
                    </div>
                    <!-- settings -->
                    <div class="label">
                        <div class="labelheader">
                            <h4>Account Settings</h4>
                            <div class="sep"></div>
                        </div>
                    </div>
                </div>

                <!-- right container -->
                <div class="dashcontainer">
                    <!-- credit card -->
                    <div class="label">
                        <div class="labelheader">
                            <h5>Preferred Payment</h5>
                            <?php
                            $card = new CreditCard();
                            $pCard = $card->getPC($_SESSION['row']['email']);                            
                            echo "<div style='padding-top:15px;'><span class='address'>" 
                            . $pCard['name'] . "</span><br><span class='address'>";
                            $numberArr = str_split($pCard['number']);
                            echo "********" . $numberArr[count($numberArr) - 4] 
                                    . $numberArr[count($numberArr) - 3]
                                    . $numberArr[count($numberArr) - 2] 
                                    . $numberArr[count($numberArr) - 1];
                            echo "</span><br><span class='address'>";
                            $date = DateTime::createFromFormat('Y-m-d', $pCard['date']);
                            $monthyear = $date->format('m/Y');
                            echo $monthyear;
                            echo "</span><br></div><br>";                            
                            ?> 
                            <br>
                            <a href="updateCredit.php" class="myBtn">Manage / Add New Payment</a>
                        </div>
                    </div>
                    <!-- address -->
                    <div class="label">
                        <div class="labelheader">
                            <h5>Preferred Shipping Address</h5>

                            <?php
                            $address = new Address();
                            $pAddress = $address->getPA($_SESSION['row']['email']);
                            echo "<div style='padding-top:15px;'><span class='address'>" 
                            . $pAddress['firstname'] . "  " . $pAddress['lastname'] 
                            . "</span><br><span class='address'>" . $pAddress['addressln1'] 
                            . ", " . $pAddress['addressln2'] . "</span><br><span class='address'>"
                            . $pAddress['city'] . "</span><br><span class='address'>" 
                            . $pAddress['state'] . " " . $pAddress['zip'] 
                            . "</span><br><span class='address'>"
                            . $pAddress['phone'] . "</span></div><br>";
                            ?>                               
                            <br>
                            <a href="updateAddress.php" class="myBtn">Manage / Add New Address</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>



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

