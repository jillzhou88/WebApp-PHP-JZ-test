<?php
session_start();
require './model/Products.php';
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>WebApp</title>
        <meta name="author" content="Jill">

        <!-- css -->
        <link type="text/css" rel="stylesheet" href="./css/global.css">
        <link type="text/css" rel="stylesheet" href="./css/style.css">
        <link type="text/css" rel="stylesheet" href="./css/index.css">
        <style>
            #container, #container1 {
                position: relative;
                display: flex;                   /* establish flex container */
                flex-direction: row;             /* default value; can be omitted */
                flex-wrap: nowrap;               /* default value; can be omitted */
                justify-content: flex-start;  /* switched from default (flex-start, see below) */
            }

            #container > div, #container1 > div {
                position: relative;
                width: 400px;
                height: 100%;
            }
            #container > div {
                font-family: Century Gothic, sans-serif;
                font-size: 30px;                
            } 
        </style>

        <!-- jssor slider -->
        <script type="text/javascript" src="./css/jssor.js"></script>
        <script type="text/javascript" src="./css/jssor.slider.js"></script>
        <script>
            init_jssor_slider1 = function (containerId) {

                var options = {
                    $DragOrientation: 0, //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
                    $SlideDuration: 500, //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                    $AutoPlay: true, //Whether to play automatically, to enable slideshow, this option must be set to true.
                    $PauseOnHover: 1, //Whether to pause when mouse over if a slider is auto playing, 0: no pause, 1: pause for desktop, 2: pause for touch device, 3: pause for desktop and touch device, 4: freeze for desktop, 8: freeze for touch device, 12: freeze for desktop and touch device, default value is 1

                    $ArrowNavigatorOptions: {//[Optional] Options to specify and enable arrow navigator or not
                        $Class: $JssorArrowNavigator$, //[Requried] Class to create arrow navigator instance
                        $ChanceToShow: 1, //[Required] 0 Never, 1 Mouse Over, 2 Always
                        $AutoCenter: 2, //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                        $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                    }
                };

                var jssor_slider1 = new $JssorSlider$(containerId, options);

//            //responsive code begin
//            //you can remove responsive code if you don't want the slider scales while window resizing
//            function ScaleSlider() {
//                var refSize = jssor_slider1.$Elmt.parentNode.clientWidth;
//                if (refSize) {
//                    refSize = Math.min(refSize, 1920);
//                    jssor_slider1.$ScaleWidth(refSize);
//                }
//                else {
//                    window.setTimeout(ScaleSlider, 30);
//                }
//            }
//            ScaleSlider();
//            $(window).bind("load", ScaleSlider);
//            $(window).bind("resize", ScaleSlider);
//            $(window).bind("orientationchange", ScaleSlider);
//            //responsive code end
            };



        </script>
        <style>
            /* jssor slider arrow navigator skin 01 css */
            /*
            .jssora01l                  (normal)
            .jssora01r                  (normal)
            .jssora01l:hover            (normal mouseover)
            .jssora01r:hover            (normal mouseover)
            .jssora01l.jssora01ldn      (mousedown)
            .jssora01r.jssora01rdn      (mousedown)
            */
            .jssora01l, .jssora01r {
                display: block;
                position: absolute;
                /* size of arrow element */
                width: 45px;
                height: 45px;
                cursor: default;
                background: url(./image/a22.png) no-repeat;
                overflow: hidden;
            }
            .jssora01l { background-position: -8px -38px; }
            .jssora01r { background-position: -68px -38px; }

            .jssora01l:hover { background-position: -128px -38px; }
            .jssora01r:hover { background-position: -188px -38px; }
            .jssora01l.jssora01ldn { background-position: -8px -38px; }
            .jssora01r.jssora01rdn { background-position: -68px -38px; }

            .jssora02l, .jssora02r {
                display: block;
                position: absolute;
                /* size of arrow element */
                width: 45px;
                height: 45px;
                cursor: default;
                background: url(./image/a12.png) no-repeat;
                overflow: hidden;
            }
            .jssora02l { background-position: -8px -38px; }
            .jssora02r { background-position: -68px -38px; }

            .jssora02l:hover { background-position: -128px -38px; }
            .jssora02r:hover { background-position: -188px -38px; }
            .jssora02l.jssora02ldn { background-position: -8px -38px; }
            .jssora01r.jssora01rdn { background-position: -68px -38px; }
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

        <!-- slides -->
        <div style="position:relative; width: 1920px; height:370px;">
            <div id="slider1_container" style="position: relative; width: 100%;
                 height: 370px; overflow: hidden;">

                <!-- Slides Container --> 
                <div u="slides" style="cursor: default; position: relative; left: 0px; top: 0px; width: 1920px; 
                     height: 370px; overflow: hidden; background-position: center;">
                    <div><img u="image" src="./image/20160824061005.png" /></div>
                    <div><img u="image" src="./image/20160824062405.png" /></div>
                    <div><img u="image" src="./image/20160824062500.png" /></div>
                    <div><img u="image" src="./image/20160824062545.png" /></div>            
                </div>

                <!--#region Arrow Navigator Skin Begin -->
                <!-- Help: http://www.jssor.com/development/slider-with-arrow-navigator-jquery.html -->

                <!-- Arrow Left -->
                <span u="arrowleft" class="jssora01l" style="top: 160px; left: 130px;">
                </span>
                <!-- Arrow Right -->
                <span u="arrowright" class="jssora01r" style="top: 160px; right: 140px;">
                </span>                
                <!-- Trigger -->
                <script>
                    init_jssor_slider1("slider1_container");
                </script>              
            </div>
        </div>

        <!-- new, deal, spotlight -->
        <div id='container' style='position:relative; margin:25 auto; text-align:left; width:1200px; height:20px;'>
            <div><span style='color:#ff471a;'>HOT DEALS</span></div>
            <div>What's New</div>
            <div>Spotlight</div>
        </div>

        <!-- products container -->
        <div id='container1' style='position:relative;margin:20 auto;text-align:left; width:1200px; height:400px;'>
            
            <!-- Hot Deals container -->
            <div id="slider2_container" style="position: relative; width: 400px;
                 height: 400px; overflow: hidden; margin-right: 15px;">

                <!-- Slides Container --> 
                <div u="slides" style="cursor: default; position: absolute; left: 0px; top: 0px; width: 400px; 
                     height: 400px; overflow: hidden; ">
                    <div>
                        <a href="ProductView.php?Item=1" hidefocus="hidefocus">
                            <img u="image" src="./image/20160825061231.png" /></a>
                        <div style="position: absolute; top: 260px; left: 30px; width: 400px; 
                             height: 120px; font-size: 20px; color: #000000; line-height: 60px;">
                            <a href="ProductView.php?Item=1" hidefocus="hidefocus"><?php $product = new Products();
                            $products = $product->getProducts(1);
                            echo $products['pname']; ?></a></div>
                        <div style="position: absolute; top: 290px; left: 30px; width: 400px; 
                             height: 120px; font-size: 12px; color: #4d4d4d; line-height: 60px;">
                            Free Shipping</div>
                        <div style="position: absolute; top: 340px; left: 30px; width: 400px; 
                             height: 120px; font-size: 26px; font-weight: bold; color: #000000; line-height: 60px;">
                            $<?php echo $products['price'] ?></div>
                    </div>
                    <div>
                        <div style="position: relative; width:400px; height:270px; overflow:hidden;">
                            <a href="ProductView.php?Item=2" hidefocus="hidefocus">
                                <img style="position:absolute; top:-9999px; bottom:-9999px; left:-9999px; right:-9999px;
                                     margin:auto; max-height: 100%; max-width: 100%;" u="image" src="./image/20160825061311.png" /></a>
                        </div>
                        <div style="position: absolute; top: 260px; left: 30px; width: 400px; 
                             height: 120px; font-size: 20px; color: #000000; line-height: 60px;">
                            <a href="ProductView.php?Item=2" hidefocus="hidefocus"><?php $product = new Products();
                            $products = $product->getProducts(2);
                            echo $products['pname']; ?></a></div>
                        <div style="position: absolute; top: 290px; left: 30px; width: 400px; 
                             height: 120px; font-size: 12px; color: #4d4d4d; line-height: 60px;">
                            Free Shipping</div>
                        <div style="position: absolute; top: 340px; left: 30px; width: 400px; 
                             height: 120px; font-size: 26px; font-weight: bold; color: #000000; line-height: 60px;">
                            $<?php echo $products['price'] ?></div>
                    </div>
                    <div>
                        <div style="position: relative; width:400px; height:270px; overflow:hidden;">
                            <a href="ProductView.php?Item=3" hidefocus="hidefocus">
                                <img style="position:absolute; top:-9999px; bottom:-9999px; left:-9999px; right:-9999px;
                                     margin:auto; max-height: 100%; max-width: 100%;" u="image" src="./image/20161206080619.png" /></a>
                        </div>
                        <div style="position: absolute; top: 260px; left: 30px; width: 400px; 
                             height: 120px; font-size: 20px; color: #000000; line-height: 60px;">
                            <a href="ProductView.php?Item=3" hidefocus="hidefocus"><?php $product = new Products();
                            $products = $product->getProducts(3);
                            echo $products['pname']; ?></a></div>
                        <div style="position: absolute; top: 290px; left: 30px; width: 400px; 
                             height: 120px; font-size: 12px; color: #4d4d4d; line-height: 60px;">
                            Free Shipping</div>
                        <div style="position: absolute; top: 340px; left: 30px; width: 400px; 
                             height: 120px; font-size: 26px; font-weight: bold; color: #000000; line-height: 60px;">
                            $<?php echo $products['price'] ?></div>
                    </div>
                    <div>
                        <div style="position: relative; width:400px; height:270px; overflow:hidden;">
                            <a href="ProductView.php?Item=4" hidefocus="hidefocus">
                                <img style="position:absolute; top:-9999px; bottom:-9999px; left:-9999px; right:-9999px;
                                     margin:auto; max-height: 100%; max-width: 100%;" u="image" src="./image/20161206082044.png" /></a>
                        </div>
                        <div style="position: absolute; top: 260px; left: 30px; width: 400px; 
                             height: 120px; font-size: 20px; color: #000000; line-height: 60px;">
                            <a href="ProductView.php?Item=3" hidefocus="hidefocus"><?php $product = new Products();
                            $products = $product->getProducts(4);
                            echo $products['pname']; ?></a></div>
                        <div style="position: absolute; top: 290px; left: 30px; width: 400px; 
                             height: 120px; font-size: 12px; color: #4d4d4d; line-height: 60px;">
                            Free Shipping</div>
                        <div style="position: absolute; top: 340px; left: 30px; width: 400px; 
                             height: 120px; font-size: 26px; font-weight: bold; color: #000000; line-height: 60px;">
                            $<?php echo $products['price'] ?></div>
                    </div>          
                </div>

                <!--#region Arrow Navigator Skin Begin -->                
                <!-- Arrow Left -->
                <span u="arrowleft" class="jssora02l" style="left: -8px;">
                </span>
                <!-- Arrow Right -->
                <span u="arrowright" class="jssora02r" style="right:7px;">
                </span>                
                <!-- Trigger -->
                <script>
                    init_jssor_slider1("slider2_container");
                </script>              
            </div>

            <!-- What's New container -->
            <div id="slider3_container" style="position: relative; width: 400px;
                 height: 400px; overflow: hidden; margin-right: 15px;">

                <!-- Slides Container --> 
                <div u="slides" style="cursor: default; position: absolute; left: 0px; top: 0px; width: 400px; height: 400px;
                     overflow: hidden; ">
                    <div>
                        <a href="ProductView.php?Item=1" hidefocus="hidefocus">
                            <img u="image" src="./image/20160825061231.png" /></a>
                        <div style="position: absolute; top: 260px; left: 30px; width: 400px; 
                             height: 120px; font-size: 20px; color: #000000; line-height: 60px;">
                            <a href="ProductView.php?Item=1" hidefocus="hidefocus"><?php $product = new Products();
                            $products = $product->getProducts(1);
                            echo $products['pname']; ?></a></div>
                        <div style="position: absolute; top: 290px; left: 30px; width: 400px; 
                             height: 120px; font-size: 12px; color: #4d4d4d; line-height: 60px;">
                            Free Shipping</div>
                        <div style="position: absolute; top: 340px; left: 30px; width: 400px; 
                             height: 120px; font-size: 26px; font-weight: bold; color: #000000; line-height: 60px;">
                            $<?php echo $products['price'] ?></div>
                    </div>
                    <div>
                        <div style="position: relative; width:400px; height:270px; overflow:hidden;">
                            <a href="ProductView.php?Item=2" hidefocus="hidefocus">
                                <img style="position:absolute; top:-9999px; bottom:-9999px; left:-9999px; right:-9999px;
                                 margin:auto; max-height: 100%; max-width: 100%;" u="image" src="./image/20160825061311.png" /></a>
                        </div>
                        <div style="position: absolute; top: 260px; left: 30px; width: 400px; 
                             height: 120px; font-size: 20px; color: #000000; line-height: 60px;">
                            <a href="ProductView.php?Item=2" hidefocus="hidefocus"><?php $product = new Products();
                            $products = $product->getProducts(2);
                            echo $products['pname']; ?></a></div>
                        <div style="position: absolute; top: 290px; left: 30px; width: 400px; 
                             height: 120px; font-size: 12px; color: #4d4d4d; line-height: 60px;">
                            Free Shipping</div>
                        <div style="position: absolute; top: 340px; left: 30px; width: 400px; 
                             height: 120px; font-size: 26px; font-weight: bold; color: #000000; line-height: 60px;">
                            $<?php echo $products['price'] ?></div>
                    </div>
                    <div><img u="image" src="./image/20160824062500.png" /></div>
                    <div><img u="image" src="./image/20160824062545.png" /></div>            
                </div>

                <!--#region Arrow Navigator Skin Begin -->                
                <!-- Arrow Left -->
                <span u="arrowleft" class="jssora02l" style="left: -8px;">
                </span>
                <!-- Arrow Right -->
                <span u="arrowright" class="jssora02r" style="right: 7px;">
                </span>                
                <!-- Trigger -->
                <script>
                    init_jssor_slider1("slider3_container");
                </script>              
            </div>

            <!-- Spotlight container -->
            <div id="slider4_container" style="position: relative; width: 400px;
                 height: 400px; overflow: hidden; margin-right: 15px;">

                <!-- Slides Container --> 
                <div u="slides" style="cursor: default; position: absolute; left: 0px; top: 0px; width: 400px; height: 400px;
                     overflow: hidden; ">
                    <div>
                        <a href="ProductView.php?Item=1" hidefocus="hidefocus">
                            <img u="image" src="./image/20160825061231.png" /></a>
                        <div style="position: absolute; top: 260px; left: 30px; width: 400px; 
                             height: 120px; font-size: 20px; color: #000000; line-height: 60px;">
                            <a href="ProductView.php?Item=1" hidefocus="hidefocus"><?php $product = new Products();
                            $products = $product->getProducts(1);
                            echo $products['pname']; ?></a></div>
                        <div style="position: absolute; top: 290px; left: 30px; width: 400px; 
                             height: 120px; font-size: 12px; color: #4d4d4d; line-height: 60px;">
                            Free Shipping</div>
                        <div style="position: absolute; top: 340px; left: 30px; width: 400px; 
                             height: 120px; font-size: 26px; font-weight: bold; color: #000000; line-height: 60px;">
                            $<?php echo $products['price'] ?></div>
                    </div>
                    <div>
                        <div style="position: relative; width:400px; height:270px; overflow:hidden;">
                            <a href="ProductView.php?Item=1" hidefocus="hidefocus">
                                <img style="position:absolute; top:-9999px; bottom:-9999px; left:-9999px; right:-9999px;
                                 margin:auto; max-height: 100%; max-width: 100%;" u="image" src="./image/20160825061311.png" /></a>
                        </div>
                        <div style="position: absolute; top: 260px; left: 30px; width: 400px; 
                             height: 120px; font-size: 20px; color: #000000; line-height: 60px;">
                            <a href="ProductView.php?Item=2" hidefocus="hidefocus"><?php $product = new Products();
                            $products = $product->getProducts(2);
                            echo $products['pname']; ?></a></div>
                        <div style="position: absolute; top: 290px; left: 30px; width: 400px; 
                             height: 120px; font-size: 12px; color: #4d4d4d; line-height: 60px;">
                            Free Shipping</div>
                        <div style="position: absolute; top: 340px; left: 30px; width: 400px; 
                             height: 120px; font-size: 26px; font-weight: bold; color: #000000; line-height: 60px;">
                            $<?php echo $products['price'] ?></div>
                    </div>
                    <div><img u="image" src="./image/20160824062500.png" /></div>
                    <div><img u="image" src="./image/20160824062545.png" /></div>            
                </div>

                <!--#region Arrow Navigator Skin Begin -->                
                <!-- Arrow Left -->
                <span u="arrowleft" class="jssora02l" style="left: -8px;">
                </span>
                <!-- Arrow Right -->
                <span u="arrowright" class="jssora02r" style="right: 7px;">
                </span>                
                <!-- Trigger -->
                <script>
                    init_jssor_slider1("slider4_container");
                </script>              
            </div>

        </div>

        <!-- Service -->
        <div class="g-bd">
            <div class="m-aimg">

                <div class="u-aimg" unselectable="on" onselectstart="return false;">
                    <ul>

                        <li><a href=""><img src="./image/20160826052525.png"></a></li>

                        <li><a href=""><img src="./image/20160826055321.jpg"></a></li>

                        <li><a href=""><img src="./image/20160826055626.jpg"></a></li>

                        <li><a href=""><img src="./image/20160826052542.png"></a></li>

                    </ul>
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


