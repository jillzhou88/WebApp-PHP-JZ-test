<?php
session_start();
require "./model/Address.php";

$data = array('email'=>'', 'firstname'=>'', 'lastname'=>'','addressln1'=>'', 
    'addressln2'=>'', 'city'=>'', 'state'=>'', 'zip'=>'', 'phone'=>'', 'isPrimary'=>'');
$error = array('firstname'=>'', 'lastname'=>'', 'addressln1'=>'', 'addressln2'=>'',
    'city'=>'', 'state'=>'', 'zip'=>'', 'phone'=>'');
$address = new Address();
$pAddress = $address->getPA($_SESSION['row']['email']);

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
    //change primary address
//    if ($_POST['setPrimary'] == TRUE) {
//        $address->updatePA($pAddress['id'], 0);
//        $address->updatePA($_POST['id'], 1);
//    }

    //add new address
    if ($_POST['addNew'] == TRUE) {
        //validate form
        if (empty($_POST["firstname"])) {
            $error['firstname'] = "Firstname is required";
        } else {
            $data['firstname'] = test_input($_POST["firstname"]);
        }

        if (empty($_POST["lastname"])) {
            $error['lastname'] = "Lastname is required";
        } else {
            $data['lastname'] = test_input($_POST["lastname"]);
        }

        if (empty($_POST["addressln1"])) {
            $error['addressln1'] = "Address is required";
        } else {
            $data['addressln1'] = test_input($_POST["addressln1"]);
        }

        if (empty($_POST["city"])) {
            $error['city'] = "City is required";
        } else {
            $data['city'] = test_input($_POST["city"]);
        }

        if (empty($_POST["state"])) {
            $error['state'] = "State is required";
        } else {
            $data['state'] = test_input($_POST["state"]);
        }

        if (empty($_POST["zip"])) {
            $error['zip'] = "Zip code is required";
        } else {
            if (!preg_match('/^([0-9]{5})(-[0-9]{4})?$/i', $_POST['zip'])) {
                $error['zip'] = 'US Postcodes: 99999 or 99999-9999';
            } else {
                $data['zip'] = test_input($_POST["zip"]);
            }
        }

        if (empty($_POST["phone"])) {
            $error['phone'] = "Phone number is required";
        } else {
            if (!preg_match('/^\D?(\d{3})\D?\D?(\d{3})\D?(\d{4})$/', $_POST['phone'])) {
                $error['phone'] = '123-456-7890 or (123)456-7890 or 1234567890';
            } else {
                $data['phone'] = test_input($_POST["phone"]);
            }
        }

        $data['email'] = test_input($_POST['email']);
        $data['addressln2'] = test_input($_POST['addressln2']);
        
        
        //check if there is error
        $isValid = TRUE;
        foreach ($error as $value) {
            if ($value) {
                $isValid = FALSE;
                break;
            }
        }

        //first address, set as primary address
        if ($_POST['cecky'] == "" && $pAddress == "") {
            $data['isPrimary'] = 1;
        //not the first address, "set as primary" unchecked
        } elseif ($_POST['cecky'] == "" && $pAddress != "") {
            $data['isPrimary'] = 0;
        } else {
        //"set as primary" checked
            $address->updatePA($pAddress['id'], 0);
            $data['isPrimary'] = $_POST['cecky'];
        }

        if ($isValid) {
            $address->insertAddress($data);
        }
    }
    
    //edit address
    if (isset($_POST['edit'])) {
        //delete address
        if($_POST['edit'] == 'delete'){
            $address->deleteAddress($_POST['id']);
        } 
        //set primary
        else if ($_POST['edit'] == 'setP'){
            $address->updatePA($pAddress['id'], 0);
            $address->updatePA($_POST['id'], 1);
        }
    }    
}

function test_input($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

//    unset($_POST);
//    header('Location: updateAddress.php');
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
        
        <style>
            .error {color: #FF0000;}
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

        <!-- Address book -->
        <div class="dash">    
            <div style="display:flex; flex-wrap:wrap; position:relative;">
                <?php
                $addressList = $address->getAddress($_SESSION['row']['email']);

                for ($i = 0; $i < count($addressList); $i++) {
                    if ($addressList[$i]['isPrimary'] == 1){
                        echo "<div class='paddresslabel'><div class='labelheader'><h5>" 
                            . $addressList[$i]['firstname'] . "  "
                            . $addressList[$i]['lastname'] . "</h5>";
                    } else {
                        echo "<div class='addresslabel'><div class='labelheader'><h5>" 
                            . $addressList[$i]['firstname'] . "  "
                            . $addressList[$i]['lastname'] . "&nbsp &nbsp
                            <form class='setprimary' action='";
                        echo htmlspecialchars($_SERVER["PHP_SELF"]);
                        echo "' method='post'>
                            <input type='hidden' name='id' value='" . $addressList[$i]["id"] ."'>                            
                            <select name='edit'onchange='this.form.submit()' class='select'>
                            <option>Edit</option>
                            <option value='delete'>Delete</option>
                            <option value='setP'>Set Primary</option></select></form></h5>  
                            ";                    
                    }
                    echo "<div class='sep' style='width:250px;'></div><p class='address'>"
                    . $addressList[$i]['addressln1'] . ", "
                    . $addressList[$i]['addressln2'] . "<br>"
                    . $addressList[$i]['city'] . "<br>" . $addressList[$i]['state']
                    . "&nbsp &nbsp &nbsp" . $addressList[$i]['zip'] . "<br>"
                    . $addressList[$i]['phone'] . "</p></div></div>  ";
                }
                ?>
            </div>
        </div>

        <div class="g-bd">
            <div class="m-aimg">
                <div class="modal-content">
                <div class="modal-header">
                    <h2 style="color:tan;">Add Shipping Address</h2>
                </div>
                <div class="modal-body">
                    <div class="dashcontainer">
                        <form id="modalform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="inputs">
                                <input type="hidden" name="email" value="<?php echo $_SESSION['row']['email'] ?>">
                                <input type="hidden" name="addNew" value=TRUE>
                                <input type="text" placeholder="Firstname" autofocus name="firstname">
                                    <?php if ($error['firstname']) echo '<span class="error">' . $error['firstname'].'</span>'; ?>
                                <input type="text" placeholder="Lastname" name="lastname">
                                    <?php if ($error['lastname']) echo '<span class="error">' . $error['lastname'].'</span>'; ?>
                                <input type="text" placeholder="Address Line 1" name="addressln1">
                                    <?php if ($error['addressln1']) echo '<span class="error">' . $error['addressln1'].'</span>'; ?>
                                <input type="text" placeholder="Address Line 2" name="addressln2">
                                <input type="text" placeholder="City" name="city">
                                    <?php if ($error['city']) echo '<span class="error">' . $error['city'].'</span>'; ?>
                                <input type="text" placeholder="State" name="state">
                                    <?php if ($error['state']) echo '<span class="error">' . $error['state'].'</span>'; ?>
                                <input type="text" placeholder="Zip Code" name="zip">
                                    <?php if ($error['zip']) echo '<span class="error">' . $error['zip'].'</span>'; ?>
                                <input type="text" placeholder="Phone Number" name="phone">
                                    <?php if ($error['phone']) echo '<span class="error">' . $error['phone'].'</span>'; ?>
                                <div class="checkboxy">
                                    <input type="checkbox" id="checky" value="1" name="cecky"/>
                                    <label class="terms">Set As Preferred Shipping Address</label>
                                </div>

                                <button id="submit" type="submit">UPDATE ADDRESS</button>
                            </div>
                        </form>
                    </div></div>
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
