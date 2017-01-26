<?php
session_start();
if (!isset($_SESSION['check']) || ($_SESSION['check'] == FALSE)) {
    header ('Location:WebApp.php');
}
unset($_SESSION['aid']);
unset($_SESSION['cid']);
unset($_SESSION['sPrice']);
unset($_SESSION['shipping']);

require "./model/Order.php";
require "./model/Cart.php";
require "./model/Purchased.php";

if($_POST['sPrice'] == null | $_POST['sPrice'] == 0){
    header('Location: CheckOut.php');
    exit;
} else {
    $orderId = time() . rand(10*45, 100*98);;
    $data = array('id' => $orderId, 'email' => $_POST['email'], 'addressId' => $_POST['addressId'], 
        'cardId' => $_POST['cardId'], 'shipping' => $_POST['shipping'], 
        'total' => $_POST['total']);
    $order = new Order();
    
    $order->insertOrder($data);
    
    $purchased = new Purchased();
    $cart = new Cart();
    //insert cart items into table upurchased 
    $cartItem = $cart->getCart($_SESSION['row']['email']);
    for ($i = 0; $i < count($cartItem); $i++) {
    $purchasedItem = array("orderId" => $orderId, 'productId' => $cartItem[$i]['id'], 
        'qty' => $cartItem[$i]['qty']);
    $purchased->addPurchased($purchasedItem);
    }
    
    $cart->deleteCart($_POST['email']);
    
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Placing Order</title>
       
        <!-- css -->
        <link type="text/css" rel="stylesheet" href="./css/global.css">
        <link type="text/css" rel="stylesheet" href="./css/style.css">
        <link type="text/css" rel="stylesheet" href="./css/index.css">
        <link type="text/css" rel="stylesheet" href="./css/cssfaq.css">
        <link type="text/css" rel="stylesheet" href="./css/signup.css">
        <style>
            .info{
                margin: 0 auto;
                font-size: 20px;
                color: #8e5c32;
                
            }
        </style>
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
                            <li><a href="logout.php">Logout</a></li>
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
                    <li id="index" class=""><a href="" hidefocus="hidefocus">Computer Systems</a></li>                    
                    <li id="rank" class=""><a href="" hidefocus="hidefocus">Components</a></li>
                    <li id="review" class=""><a href="" hidefocus="hidefocus">Electronics</a></li>
                    <li id="bargain" class=""><a href="" hidefocus="hidefocus">Gaming</a></li>
                    <li id="category" class=""><a href="" hidefocus="hidefocus">Software & Services</a></li>                    
                </ul>
            </nav>
        </div>
        
        <div class="info">
            <?php
            echo "Your order has been placed! An email confirmation will be sent to you soon.";
            
            ?>
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
