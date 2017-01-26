<?php
session_start();
require './model/Products.php';
$id = $_GET['Item'];
//$id = 1;
$product = new Products();
$row = $product->getProducts($id);
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>WebApp: <?php echo $row['pname']; ?></title>
        <meta name="author" content="Jill">

        <!-- css -->
        <link type="text/css" rel="stylesheet" href="./css/global.css">
        <link type="text/css" rel="stylesheet" href="./css/style.css">
        <link type="text/css" rel="stylesheet" href="./css/index.css">
        <style>
            .button {
                display: inline-block;
                border-radius: 4px;
                background-color: #D2B48C;
                border: none;
                color: #FFFFFF;
                text-align: center;
                font-size: 25px;
                padding: 20px;
                width: 200px;
                transition: all 0.5s;
                cursor: pointer;
                margin: 5px;
            }

            .button span {
                cursor: pointer;
                display: inline-block;
                position: relative;
                transition: 0.5s;
            }

            .button span:after {
                content: '»';
                position: absolute;
                opacity: 0;
                top: 0;
                right: -20px;
                transition: 0.5s;
            }

            .button:hover span {
                padding-right: 25px;
            }

            .button:hover span:after {
                opacity: 1;
                right: 0;
            }

            @media screen and (max-width: 800px){
                .g-bd1 .g-sd {
                    width:100%;
                }
                .g-bd1 .g-mn {
                    width:100%;
                }
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

                        <!-- top right login/registration &shopping cart -->
                        <ul class='m-pctrl j-pctrl f-cb'>
                            <!-- login/register -->
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
                            <!-- shopping cart -->
                            <li class="itm login j-login">
                                <a href="ShoppingCart.php">ShoppingCart</a>
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

        <!-- Product View-->
        <div class="g-bd1">
            <div class="u-nav-crumbs">
                <span style="color:#a57940;">Current Location:</span>
                <a href="WebApp.php" hidefocus="hidefocus"><span style="color:#a57940;">Main Page</span></a>
                <span class="sep">&gt;</span>
                <a href="" hidefocus="hidefocus"><span style="color:#a57940;"> <?php echo $row['department']; ?></span></a>
                <span class="sep">&gt;</span>
                <em><span style="color:#a57940;"><?php echo $row['pname']; ?></span></em>
            </div>

            <div class="g-wrap">
                <div class="g-mn">
                    <div class="g-mnc">
                        <div style="display:flex; position:relative;">
                            <!-- picture -->
                            <div style="width:500px; position:relative;" >
                                <img itemprop="image" src="<?php echo './' . $row['image']; ?>" 
                                     alt="<?php echo $row['pname']; ?>" 
                                     style="width:400px; height:400px; display:block; position:relative;"/>

                            </div>

                            <!-- product name, price, stock, buy-->
                            <div style='flex-grow:1; position:relative; width:350px; margin-left: 20px;'>
                                <!-- name -->
                                <h2><?php echo $row['pname']; ?></h2>
                                <br>

                                <!-- stock,price,buy-->
                                <div class="cnt">
                                    <!-- stock -->
                                    <div>
                                        <?php
                                        if ($row['store'] > 5) {
                                            echo "<span style='font-size:23px; color:#D2691E;'>In Stock</span>";
                                        } else if ($row['store'] > 0 && $row['store'] <=5 ){
                                            echo "<span style='font-size:23px; color:#D2691E;'>Only " . $row['store'] . " in stock</span>";
                                        }
                                        else {
                                            echo "<span style='font-size:23px; color:#D2691E;'>Temporary Out of Stock</span>";
                                        }                                        
                                        ?>
                                        <br><br>
                                    </div>
                                    <div class="pay">
                                        <!-- price -->
                                        <div class="price">
                                            <em><?php echo "<span style='font:20px Verdana,Sans-serif;color:#FF4500;'>$" 
                                            . $row['price'] . "</span><br><br>"; ?></em>
                                        </div>
                                        <!-- buy -->
                                        <div >
                                            <form action="addCart.php" method="GET">
                                                <p class="view">                                                    
                                                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                                                    <input type='hidden' name='qty' value=1/>
                                                    <button type="submit" name="submit" class="button" style="vertical-align:middle;"><span>Add to Cart</span></button>
                                                </p>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="m-bookdetail j-detail">
                            <div class="u-nav-tab j-tab">
                                <ul>
                                    <li class="itm crt"><span style="font:18px Verdana,sans-serif;">Description</span></li>

                                </ul>
                                <div class="icn-arrow icn-arrow-top3 j-target" style="left:29px;">
                                    <span class="arrow0"></span>
                                    <span class="arrow1"></span>
                                </div>
                            </div>
                            <section class="cnt j-cnt" >
                                <article class="intro" id="book-content" hidefocus="hidefocus">
                                    <p><span style="font:14px Arial,sans-serif;"><?php echo $row['description']; ?></p></article>
                                <div class="more" style="visibility:hidden;">
                                    <a class="u-more1 j-more" href="javascript:void(0);" hidefocus="hidefocus">
                                        More
                                        <div class="icn-arrow icn-arrow-bottom">
                                            <span class="arrow0"></span>
                                            <span class="arrow1"></span>
                                        </div>
                                    </a>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>


                <div class="g-sd">

                    <section class="u-taglist">
                        <div class="u-ttl1"><h3>Tags</h3></div>
                        <ul>
                            <li><a href="">Samsung</a></li>
                            <li><a href="">SSD</a></li>
                            <li><a href="">850 Pro</a></li>
                            <li><a href="">Data Storage</a></li>
                        </ul>
                    </section>


                    <section class="m-recommend j-recommend-page">
                        <div class="u-ttl1"><h4>Customers Who Bought This Item Also Bought</h4></div>
                        <div class="cnt">
                            <ul>
                                <li class="u-bookitm2 j-bookitm">
                                    <div class="book">
                                        <div class="cover">
                                            <a href="ProductView.php?Item=2">
                                                <img src="./image/20160825061311.png" alt="Samsung 850 PRO SSD 512GB" style="display:block"/>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="info">
                                        <a href="ProductView.php?Item=2" class="title" hidefocus="hidefocus" target="_blank">
                                            <?php $product = new Products();
                                            $products = $product->getProducts(2);
                                            echo $products['pname']; ?></a>
                                        <div class="u-author">
                                            <span><?php echo $products['department']; ?></span>
                                        </div>
                                        <div class="u-price">
                                            <em><?php echo "$".$products['price'];?></em>
                                        </div>
                                    </div>
                                </li>
                                
                                <li class="u-bookitm2 j-bookitm">
                                    <div class="book">
                                        <div class="cover">
                                            <a href="ProductView.php?Item=1">
                                                <img src="./image/20160825061231.png" alt="Samsung 850 PRO SSD 256GB" style="display:block"/>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="info">
                                        <a href="ProductView.php?Item=1" class="title" hidefocus="hidefocus" target="_blank">
                                            <?php $product = new Products();
                                            $products = $product->getProducts(1);
                                            echo $products['pname']; ?></a>
                                        <div class="u-author">
                                            <span><?php echo $products['department']; ?></span>
                                        </div>
                                        <div class="u-price">
                                            <em><?php echo "$".$products['price'];?></em>
                                        </div>
                                    </div>
                                </li> 

                            </ul>
                        </div>
                    </section>

                </div>
            </div>
        </div>



        <?php
        // put your code here
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
