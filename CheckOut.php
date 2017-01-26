<?php
session_start();
require "./model/Cart.php";
require "./model/CreditCard.php";
require "./model/Address.php";

//check whether login
if (!isset($_SESSION['check']) || ($_SESSION['check'] == FALSE)) {
    header('Location: login.php');
}
print_r($_POST);
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Check Out</title>
        <meta name="author" content="Jill">

        <!-- css -->
        <link type="text/css" rel="stylesheet" href="./css/global.css">
        <link type="text/css" rel="stylesheet" href="./css/style.css">
        <link type="text/css" rel="stylesheet" href="./css/index.css">
        <link type="text/css" rel="stylesheet" href="./css/cssfaq.css">
        <style>
            table{
                margin:0 auto; border:1px solid lightgrey; padding: 20px; color: grey
            }
            table tr{
                height: 5%; border: 1px solid lightgrey
            }
            table tr th, td{
                height: 10%; border: 1px solid lightgrey; text-align: center; font-size: 120%; font-family: Tahoma; padding:4px 6px
            }
            .address{                
                width: 50%;
                height: 250%;
                margin-left: 180px;
                margin-top: -15px;
                position: relative;
/*                background-color: yellow;*/
            }
            .address p{
                font-size: 16px;
                text-align: left;
                line-height: 1.2;
            }
            .totalPrice {           
                font-size: 20px;
                float: left;
                color: #b62f2f;
                font-weight: bold;
            }
            .division{                 
                border-bottom:1px dashed #E3E3E3; 
                padding:30px;
            }
            .selectAddress{               
                position:absolute;
                right: -200px;
                top: 12px;
            }
            @media screen and (-webkit-min-device-pixel-ratio:0) {  /*safari and chrome*/
                .selectAddress select{
                    height:30px;
                    line-height:30px;
                    font-size: 15px;
/*                    background:#f4f4f4;*/
                } 
            }
            .selectAddress select::-moz-focus-inner { /*Remove button padding in FF*/ 
                border: 0;
                padding: 0;
            }
            @-moz-document url-prefix() { /* targets Firefox only */
                .selectAddress select {
                    padding: 15px 0!important;
                }
            }
            .notice{
                margin-bottom: -10px;
                margin-top: 15px;
                font-size: 14px;
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

                        <!-- top right login/registration & Shopping Cart-->
                        <ul class='m-pctrl j-pctrl f-cb'>
                            <!-- login/register -->
                            <?php
                            if (!isset($_SESSION['check']) || ($_SESSION['check'] == FALSE)) {
                                echo '<li class="itm login j-login" ><a href="LogIn.php">Login</a> / <a href="Register.php" hidefocus="hidefocus">Registration</a></li>';
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
                            <input type="text" name="search" class="text" spellcheck="false" autocapitalize="off" 
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

        <!-- check out -->
        <div class="suc_content">
            <div class="suc_kuang">
                <div class="hei_513">
                    <!-- shipping address -->
                    <div class="division" style="height:25px; line-height:25px;">
                        <span class="left_name">
                            <span class="m_func">Shipping Address:</span>
                        </span>
                        <div class='address'>
                            <?php                            
                            $address = new Address();
                            $addressList = $address->getAddress($_SESSION['row']['email']);
                            
                            //check if address form is changed
                            if (array_key_exists('addressChoose', $_POST) == TRUE) {
                                $_SESSION['aid'] = $_POST['addressChoose'];  
                            }
                                $addressChoose = $address->findAddress($_SESSION['aid']);
                                echo"<p>" . $addressChoose['firstname'] . "  "
                                . $addressChoose['lastname']
                                . "<br>" . $addressChoose['addressln1']
                                . ", " . $addressChoose['addressln2'] . "<br>"
                                . $addressChoose['city'] . ", "
                                . $addressChoose['state'] . " " . $addressChoose['zip']
                                . "</p>";                               
                            
                            //select address
                            echo "<div class='selectAddress'><form action='CheckOut.php' method='post'>"
                            . "<select name='addressChoose' onchange='this.form.submit()' >";
                            echo "<option value=''> -- select your shipping address -- </option>";
                            for ($i = 0; $i < count($addressList); $i++) {
                                echo "<option value='" . $addressList[$i]['id'] 
                                        . "'>" . $addressList[$i]['addressln1'];
                                if ($addressList[$i]['addressln2'] == "") {
                                    echo ", ";
                                } else {
                                    echo ", " . $addressList[$i]['addressln2'] . ", ";
                                }
                                echo $addressList[$i]["city"] . ", " . $addressList[$i]['state'] 
                                        . " " . $addressList[$i]['zip'] . "</option>";
                            }
                            echo "</select></form></div>";
                            ?>
                        </div>
                    </div>
                    <!-- payment -->
                    <div class="division" style="height:25px; line-height:25px;">
                        <span class="left_name">
                            <span class="m_func">Payment:</span>
                        </span>
                        <div class="address">
                            <?php
                            $card = new CreditCard();
                            $cardList = $card->getCard($_SESSION['row']['email']);
                            
                            //check if card form is changed
                            if (array_key_exists('cardChoose', $_POST) == TRUE) {
                                $_SESSION['cid'] = $_POST['cardChoose'];
                            }
                                $cardChoose = $card->findCard($_SESSION['cid']);
                                echo"<p>" . $cardChoose['name'] . "<br>";
                                $numberArr = str_split($cardChoose['number']);
                                echo "Card ending in " . $numberArr[count($numberArr) - 4]
                                . $numberArr[count($numberArr) - 3]
                                . $numberArr[count($numberArr) - 2]
                                . $numberArr[count($numberArr) - 1];
                                echo "<br>";
                                $date = DateTime::createFromFormat('Y-m-d', $cardChoose['date']);
                                $monthyear = $date->format('m/Y');
                                $exDate = $date->format('Y-m');
                                $today = date("Y-m");
                                //compare expire date with today
                                if ($exDate >= $today) {
                                    echo $monthyear;
                                } else {
                                    echo "<span style='color:red;'>" . $monthyear . " Expired</span>";
                                }
                                echo "</p>";
                            
                            
                            //select card
                            echo "<div class='selectAddress'><form action='CheckOut.php' method='post'>"
                            . "<select name='cardChoose' onchange='this.form.submit()' >";
                            echo "<option value=''> -- select your payment -- </option>";
                            for ($i = 0; $i < count($cardList); $i++) {
                                echo "<option value='" . $cardList[$i]['id'] 
                                        . "'>";
                                $numberArr = str_split($cardList[$i]['number']);
                            echo "Card ending in " . $numberArr[count($numberArr) - 4]
                            . $numberArr[count($numberArr) - 3]
                            . $numberArr[count($numberArr) - 2]
                            . $numberArr[count($numberArr) - 1];
                                echo "</option>";
                            }
                            echo "</select></form></div>";
                            ?> 
                        </div>
                    </div>
                    <!-- review items -->
                    <div class="division">
                        <span class="left_name">
                            <span class="m_func">Review Items:</span>
                        </span>
                    
                    <div style="margin-left:5%"><br><br>                        
                        <table>
                            <tr>                                    
                                <th><b>Name</b></th>
                                <th><b>Quantity</b></th>
                                <th><b>Price</b></th>                                
                            </tr>
                            <?php
                            //get cart table
                            $cart = new Cart();
                            $cartItem = $cart->getCart($_SESSION['row']['email']);

                            for ($i = 0; $i < count($cartItem); $i++) {
                                echo "<tr><form action='updateCart.php' method='POST'><td>
                                    <input type='hidden' name='id' value="
                                    . $cartItem[$i]['id'] . " />" . $cartItem[$i]['pname'] . "</td>";
                                echo "<td><select name='cartqty' onchange='this.form.submit()'>
                                    <option value='" . $cartItem[$i]['qty'] . "'>"
                                    . $cartItem[$i]['qty'] . "</option>
                                    <option value='0'>Delete</option>
                                    <option value='1'>1</option>
                                    <option value='2'>2</option>
                                    <option value='3'>3</option>
                                    <option value='4'>4</option>
                                    <option value='5'>5</option>                                    
                                    </td>";
                                echo "<td>" . $cartItem[$i]['price'] . "</td></form></tr>";
                                $price = 0;
                                $price += $cartItem[$i]['qty'] * $cartItem[$i]['price'];
                            }
                            
                            ?>
                        </table>
                        <br><br></div></div>
                    <!-- choose shipping -->
                    <div class="division" style="height:25px; line-height:25px;">
                        <span class="left_name">
                            <span class="m_func">Shipping:</span>
                        </span>
                        <div class="address">
                            <?php
                            
                            if (array_key_exists('shipping', $_POST) == TRUE) {
                                $_SESSION['shipping'] = $_POST['shipping'];
                                if ($_SESSION['shipping'] == 1) {
                                    $_SESSION['sPrice'] = 5.99;
                                } else if ($_SESSION['shipping'] == 2) {
                                    $_SESSION['sPrice'] = 23.99;
                                } else if ($_SESSION['shipping'] == 3) {
                                    $_SESSION['sPrice'] = 33.99;
                                }
                            }
                            echo '<form action="CheckOut.php" method="post"><p>
                                <input type="radio" name="shipping" onclick="this.form.submit()"';
                                if (isset($_SESSION['shipping']) && $_SESSION['shipping']==1) echo "checked "; 
                            echo 'value="1"> Ground Shipping 5-7 days -- $5.99</input><br>
                            <input type="radio" name="shipping" onclick="this.form.submit()"';
                                 if (isset($_SESSION['shipping']) && $_SESSION['shipping']==2) echo "checked "; 
                            echo 'value="2"> Two Day Shipping  -- $23.99</input><br>
                            <input type="radio" name="shipping" onclick="this.form.submit()"';
                                 if (isset($_SESSION['shipping']) && $_SESSION['shipping']==3) echo "checked "; 
                            echo 'value="3"> One Day Shipping  -- $33.99</input><br>';
                            //<span style="color:red;">*  ';
                            //if ($sPrice == null) echo "Please choose a shipping method";
                            echo '</p></form>';                            
                            ?>
                        </div>
                        <div>
                            <?php
                            if ($_SESSION['sPrice'] == 0){
                                echo "<span class='selectAddress' style='color:red;'>Please choose a shipping method</span>";
                            }                                
                            ?>
                        </div>
                    </div>
                    <!-- total price -->
                    <div class="division" style="height:25px; line-height:25px;">
                        <span class="left_name">
                            <span class="m_func">Order Total:</span>
                        </span>
                        <div class="address">
                            
                                <?php
                                if ($_SESSION['sPrice'] == 0) {
                                    echo "<p>Items: $" . $price;
                                    echo "<br><span style='color:red;'>Please choose a shipping method</span></p>";
                                } else {
                                    $totalPrice = $price + $_SESSION['sPrice'];
                                    
                                    echo "<span class='totalPrice'>$" . $totalPrice."</span>";
                                }
                                ?>
                            
                        </div>
                    </div>
                    <br><br>      
                    <!-- submit order -->
                    <form action="placeOrder.php" method="post">
                        <input type="hidden" name="email" value="<?php echo $_SESSION['row']['email']; ?>"/>
                        <input type="hidden" name="addressId" value="<?php echo $_SESSION['aid']; ?>"/>
                        <input type="hidden" name="cardId" value="<?php echo $_SESSION['cid']; ?>"/>
                        <input type="hidden" name="sPrice" value="<?php echo $_SESSION['sPrice']; ?>"/>
                        <input type="hidden" name="shipping" value="<?php echo $_SESSION['shipping']; ?>"/>
                        <input type="hidden" name="total" value="<?php echo $totalPrice; ?>"/>
                        <button class="u-btn2 j-buy" type="submit" style="background-color:orange; color:#7a1f1f;">
                            <strong>Place Order</strong></a></button>
                    </form>
                    <p class="notice">By placing your order, you agree to our privacy notice and conditions of use.</p>
                    <br><br>
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

