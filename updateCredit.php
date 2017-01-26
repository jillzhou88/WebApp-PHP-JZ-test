<?php 
//session_start();
//require "./model/CreditCard.php";
//
//$data = array('email', 'cName', 'cNumber', 'sCode', 'isPrimary');
//$card = new CreditCard();
//$pCard = $card->getPC($_POST['email']);
//
////insert card
//$data = array('email' => $_POST['email'], 'cName' => $_POST['cName'],
//    'cNumber' => $_POST['cNumber'], 'sCode' => $_POST['sCode']);
//
////first card, set as primary
//if ($_POST['cecky'] == "" && $pCard == "") {
//    $data['isPrimary'] = 1;
////not the first card, "set as primary" unchecked
//} elseif ($_POST['cecky'] == "" && $pCard != "") {
//    $data['isPrimary'] = 0;
//} else {
////"set as primary" checked
//    $card->updatePC($pCard['id']);
//    $data['isPrimary'] = $_POST['cecky'];
//}
//
//$card->insertCard($data);
//
//header('Location: AccountHome.php');
//exit;

?>

<?php
session_start();
require "./model/CreditCard.php";

if (!isset($_SESSION['check']) || ($_SESSION['check'] == FALSE)) {
    header('Location:WebApp.php');
}

$data = array('email'=>'', 'name'=>'', 'number'=>'', 'date'=>'', 'scode'=>'', 'isPrimary'=>'');
$error = array('name'=>'', 'number'=>'', 'date'=>'', 'scode'=>'');
$card = new CreditCard();
$pCard = $card->getPC($_SESSION['row']['email']);

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
    //change primary card
//    if ($_POST['setPrimary'] == TRUE) {
//        $card->updatePA($pCard['id'], 0);
//        $card->updatePA($_POST['id'], 1);
//    }

    //add new card
    if ($_POST['addNew'] == TRUE) {
        //validate form
        if (empty($_POST["name"])) {
            $error['name'] = "Card holder's name is required";
        } else {
            $data['name'] = test_input($_POST["name"]);
        }       

        if (empty($_POST["number"])) {
            $error['number'] = "Card number is required";
        } else {
             if (!preg_match('/^4\d{15}$/', $_POST['number']) 
                     && !preg_match('/^5[1-5][0-9]{14}$/', $_POST['number'])) {
                $error['number'] = 'We only accept Visa or MasterCard';
            } else {
                $data['number'] = test_input($_POST["number"]);
            }
        }
        
        if (empty($_POST['date'])){
            $error['date'] = "Please enter card expired date";
        } else {
            $dateArr = str_split($_POST['date']);
            $month = $dateArr[0] . $dateArr[1];
            $year = $dateArr[3] . $dateArr[4] . $dateArr[5] . $dateArr[6];
            $exDate = $year . "-" . $month . "-01";
            $inputDate = strtotime($exDate);
            $inputDate = date('Y-m', $inputDate);
            $today = date('Y-m');
            
            if ($inputDate >= $today){
                $data['date'] = $exDate;
            } else {
                $error['date'] = "Please enter a valid date";
            }
        }

        if (empty($_POST["scode"])) {
            $error['scode'] = "Security code is required";
        } else {
            if (!preg_match('/^\d{3}/', $_POST['scode'])) {
                $error['scode'] = 'Security code should be three digits';
            } else {
                $data['scode'] = test_input($_POST["scode"]);
            }
        }        
        
        $data['email'] = test_input($_POST['email']);
        
        //check if there is error
        $isValid = TRUE;
        foreach ($error as $value) {
            if ($value) {
                $isValid = FALSE;
                break;
            }
        }

        //first card, set as primary card
        if ($_POST['cecky'] == "" && $pCard == "") {
            $data['isPrimary'] = 1;
        //not the first card, "set as primary" unchecked
        } elseif ($_POST['cecky'] == "" && $pCard != "") {
            $data['isPrimary'] = 0;
        } else {
        //"set as primary" checked
            $card->updatePC($pCard['id'], 0);
            $data['isPrimary'] = $_POST['cecky'];
        }

        if ($isValid) {
            $card->insertCard($data);
        }
    }
    
    //edit card
    if (isset($_POST['edit'])) {
        //delete card
        if($_POST['edit'] == 'delete'){
            $card->deleteCard($_POST['id']);
        } 
        //set primary
        else if ($_POST['edit'] == 'setP'){
            $card->updatePC($pCard['id'], 0);
            $card->updatePC($_POST['id'], 1);
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
                            <a href="account.php" class="txt" id="username" hidefocus="hidefocus">';
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
                $cardList = $card->getCard($_SESSION['row']['email']);

                for ($i = 0; $i < count($cardList); $i++) {
                    if ($cardList[$i]['isPrimary'] == 1) {
                        echo "<div class='paddresslabel'><div class='labelheader'><h5>"
                        . $cardList[$i]['name'] . "</h5>";
                    } else {
                        echo "<div class='addresslabel'><div class='labelheader'><h5>"
                        . $cardList[$i]['name'] . "&nbsp &nbsp
                            <form class='setprimary' action='";
                        echo htmlspecialchars($_SERVER["PHP_SELF"]);
                        echo "' method='post'>
                            <input type='hidden' name='id' value='" . $cardList[$i]["id"] . "'>                            
                            <select name='edit'onchange='this.form.submit()' class='select'>
                            <option>Edit</option>
                            <option value='delete'>Delete</option>
                            <option value='setP'>Set Primary</option></select></form></h5>  
                            ";
                    }
                    echo "<div class='sep' style='width:250px;'></div><p class='address'>";
                    $numberArr = str_split($cardList[$i]['number']);
                    echo "********" . $numberArr[count($numberArr) - 4]
                    . $numberArr[count($numberArr) - 3]
                    . $numberArr[count($numberArr) - 2]
                    . $numberArr[count($numberArr) - 1];
                    $date = DateTime::createFromFormat('Y-m-d', $cardList[$i]['date']);
                    $monthyear = $date->format('m/Y');
                    echo "<br>" . $monthyear;
                    echo "<br>" . "</p></div></div>  ";
                }
                ?>
            </div>
        </div>

        <div class="g-bd">
            <div class="m-aimg">
                <div class="modal-content">
                <div class="modal-header">
                    <h2 style="color:tan;">Add Credit/Debit Card</h2>
                </div>
                <div class="modal-body">
                    <div class="dashcontainer">
                        <form id="modalform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="inputs">
                                <input type="hidden" name="email" value="<?php echo $_SESSION['row']['email'] ?>">
                                <input type="hidden" name="addNew" value=TRUE>
                                <input type="text" placeholder="Name" autofocus name="name">
                                    <?php if ($error['name']) echo '<span class="error">' . $error['name'].'</span>'; ?>
                                <input type="text" placeholder="Card Number" name="number">
                                    <?php if ($error['number']) echo '<span class="error">' . $error['number'].'</span>'; ?>
                                <input type="text" placeholder="Expire Date MM/YYYY" name="date">
                                    <?php if ($error['date']) echo '<span class="error">' . $error['date'].'</span>'; ?>                                
                                <input type="text" placeholder="Security Code" name="scode">
                                    <?php if ($error['scode']) echo '<span class="error">' . $error['scode'].'</span>'; ?>
                                
                                <div class="checkboxy">
                                    <input type="checkbox" id="checky" value="1" name="cecky"/>
                                    <label class="terms">Set As Preferred Payment Option</label>
                                </div>

                                <button id="submit" type="submit">UPDATE PAYMENT</button>
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
