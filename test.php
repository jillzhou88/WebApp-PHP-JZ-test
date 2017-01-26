<?php
session_start();
print_r($_POST);
echo "<br>";
echo "aid = ".$_SESSION['aid'];
echo "<br>";
echo "cid = ".$_SESSION['cid'];
echo "<br><br>";

    if (array_key_exists('aid', $_POST) == TRUE)
    $_SESSION['aid'] = $_POST['aid'];


    if (array_key_exists('cid', $_POST) == TRUE)
    $_SESSION['cid'] = $_POST['cid'];

echo "aid = ".$_SESSION['aid'];
echo "<br>";
echo "cid = ".$_SESSION['cid'];

echo "<form name='aaa' action='test.php' method='post'>"
. "<select name='aid' onchange='this.form.submit()'>";
echo "<option value=''>--select aid--</option>";
echo "<option value='1'>1</option><option value='2'>2</option><option value='3'>3</option>"
. "<option value='4'>4</option><option value='5'>5</option>";
echo "</select></form>";

echo "<br><br><br>";

echo "<form action='test.php' method='post'>"
. "<select name='cid' onchange='this.form.submit()'>";
echo "<option value=''>--select aid--</option>";
echo "<option value='1'>1</option><option value='2'>2</option><option value='3'>3</option>"
. "<option value='4'>4</option><option value='5'>5</option>";
echo "</select></form>";


//require "./model/Order.php";
//$orderId = time() . rand(10*45, 100*98);
//$data = array('id' => $orderId, "email" => $orderId, 'addressId'=>'111','cardId'=>'111','shipping'=>'111','total'=>'111');
//$order = new Order();
//$order->insertOrder($data);
//
//echo $orderId;

//echo uniqid();
//printf("uniqid(): %s\r\n", uniqid());

//if (isset($_POST['submit'])){
//echo password_hash("12345", PASSWORD_BCRYPT);
//}

//echo "<form action='test.php' method='post'>
//      <input type='text' name='pw'>
//      <input type='submit' name='submit' value='submit'><br>";
//
//echo $pw;
//require "./model/Address.php";
//require "./model/CreditCard.php";
//
//if($_POST['sPrice'] == null | $_POST['sPrice'] == 0){
//    header('Location: CheckOut.php');
//    exit;
//} else {
//    $data = array('email' => $_POST['email'], 'addressId' => $_POST['addressId'], 
//        'cardId' => $_POST['cardId'], 'shipping' => $_POST['shipping'], 
//        'total' => $_POST['total']);
//    
//    echo $data['email']. " " . $data['addressId'] . " ".$data['cardId'] . " "
//            .$data['shipping'] . " ".$data['total'];
    
//    $order = new Order();
//    
//    $order->insertOrder($data);
    
//    $cart = new Cart();
//    $cart->deleteCart($_POST['email']);
    
//}


//if (isset($_POST['shipping'])){
//    $shipping = $_POST['shipping'];
//    if ($shipping == 1){
//        $sPrice = 5.99;
//    } else if ($shipping == 2){
//        $sPrice = 23.99;
//    } else if ($shipping == 3){
//        $sPrice = 33.99;
//    } else {
//        $sPrice = null;
//    }
//}
//
//echo '<form action="test.php" method="post">
//      <input type="radio" name="shipping" ';
//if (isset($shipping) && $shipping==1) echo "checked";
//echo ' value="1" onclick="this.form.submit()"> Ground Shipping 5-7 days -- $5.99</input><br>
//      <input type="radio" name="shipping" ';
//if (isset($shipping) && $shipping==2) echo "checked";
//echo ' value="2" onclick="this.form.submit()"> Two Day Shipping  -- $23.99</input><br>
//      <input type="radio" name="shipping" ';
//      if (isset($shipping) && $shipping==3) echo "checked";
//echo ' value="3" onclick="this.form.submit()"> One Day Shipping  -- $33.99</input><br>
//      </form>';
//
//echo "<br><br>". $sPrice;

//$card = new CreditCard();
//$cardList = $card->getCard("admin@xx.com");
//if (isset($_POST['cardChoose'])) {
//    $cid = $_POST['cardChoose'];
//    $cardChoose = $card->findCard($cid);
//    echo"<p>" . $cardChoose['name'] . "<br>";
//    $numberArr = str_split($cardChoose['number']);
//    echo "Card ending in " . $numberArr[count($numberArr) - 4]
//    . $numberArr[count($numberArr) - 3]
//    . $numberArr[count($numberArr) - 2]
//    . $numberArr[count($numberArr) - 1];
//    echo "<br>";
//    $date = DateTime::createFromFormat('Y-m-d', $cardChoose['date']);
//    $monthyear = $date->format('m/Y');
//    $exDate = $date->format('Y-m');
//    $today = date("Y-m");
//    //compare expire date with today
//    if ($exDate >= $today) {
//        echo $monthyear;
//    } else {
//        echo "<span style='color:red;'>" . $monthyear . " Expired</span>";
//    }
//    echo "</p>";
//} else {
//    $pCard = $card->getPC("admin@xx.com");
//    echo "<p>"
//    . $pCard['name'] . "<br>";
//    $numberArr = str_split($pCard['number']);
//    echo "Card ending in " . $numberArr[count($numberArr) - 4]
//    . $numberArr[count($numberArr) - 3]
//    . $numberArr[count($numberArr) - 2]
//    . $numberArr[count($numberArr) - 1];
//    echo "<br>";
//    $date = DateTime::createFromFormat('Y-m-d', $pCard['date']);
//    $monthyear = $date->format('m/Y');
//    $exDate = $date->format('Y-m');
//    $today = date("Y-m");
//    if ($exDate >= $today) {
//        echo $monthyear;
//    } else {
//        echo "<span style='color:red;'>" . $monthyear . " Expired</span>";
//    }
//    //echo $monthyear;
//    echo "</p>";
//}
//
////select card
//echo "<div class='selectAddress'><form action='CheckOut.php' method='post'>"
// . "<select name='cardChoose' onchange='this.form.submit()' >";
//echo "<option value=''> -- select your payment -- </option>";
//for ($i = 0; $i < count($cardList); $i++) {
//    echo "<option value='" . $cardList[$i]['id']
//    . "'>";
//    $numberArr = str_split($cardList[$i]['number']);
//    echo "Card ending in " . $numberArr[count($numberArr) - 4]
//    . $numberArr[count($numberArr) - 3]
//    . $numberArr[count($numberArr) - 2]
//    . $numberArr[count($numberArr) - 1];
//    echo "</option>";
//}
//echo "</select></form></div>";

//$card = new CreditCard();
//$pCard = $card->getPC("admin@xx.com");
//$date = DateTime::createFromFormat('Y-m-d', $pCard['date']);
//$monthyear = $date->format('m/Y');
//$exDate = $date->format('Y-m');
//$today = date("Y-m");
//
//if ($exDate <= $today) {
//    echo $monthyear . "<" . $today;
//} else {
//    echo $monthyear . ">" . $today;
//}

//$address = new Address();
//$addressList = $address->getAddress("admin@xx.com");
//if (isset($_POST['addressChoose'])){
////    echo $_POST['addressChoose'];
////}
//    $id = $_POST['addressChoose'];
//    $addressChoose = $address->findAddress($id);
//    echo"<p>".$addressChoose['firstname']. "  " . $addressChoose['lastname']
// . "<br>" . $addressChoose['addressln1']
// . ", " . $addressChoose['addressln2'] . "<br>"
// . $addressChoose['city'] . ", "
// . $addressChoose['state'] . " " . $addressChoose['zip']
// . "</p>";
//} else {
//$pAddress = $address->getPA("admin@xx.com");
//echo "<p>"
// . $pAddress['firstname'] . "  " . $pAddress['lastname']
// . "<br>" . $pAddress['addressln1']
// . ", " . $pAddress['addressln2'] . "<br>"
// . $pAddress['city'] . ", "
// . $pAddress['state'] . " " . $pAddress['zip']
// . "</p>";
//}
//
//echo "<form action='test.php' method='post'>"
//. "<select name='addressChoose' onchange='this.form.submit()'>";
//echo "<option value=''> -- select your shipping address -- </option>";
////echo "<option value='1'>1</option><option value='2'>2</option><option value='3'>3</option>";
//for ($i=0;$i<count($addressList); $i++){
//    echo "<option value='".$addressList[$i]['id']."'>".$addressList[$i]['addressln1'];
//    if($addressList[$i]['addressln2'] == ""){
//        echo ", ";
//    } else {
//        echo ", ". $addressList[$i]['addressln2'].", ";
//    }
//    echo $addressList[$i]["city"].", ".$addressList[$i]['state']." ".$addressList[$i]['zip']."</option>";
////        echo "<option value='".$addressList[$i]['id']."'>".$addressList[$i]['id']."</option>";
//}

//require "./model/CreditCard.php";
//
//$today = date("Y-m");
//$exdate = strtotime('2016-09');
//$exdate = date('Y-m', $exdate);
//
//if ($exdate >= $today){
//echo $exdate;
//}else{
//    echo 'invalid';
//}
    


//if ($_SERVER['REQUEST_METHOD'] == 'POST'){
//    
//    $dateArr = str_split($_POST['date']);
//    $month = $dateArr[0] . $dateArr[1];
//    $year = $dateArr[3] . $dateArr[4] . $dateArr[5] . $dateArr[6];
//    
//    echo $year . "-" . $month;
    
    
    
//    if (!preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/', $_POST['number']) && !preg_match('/^5[1-5][0-9]{14}$/', $_POST['number']) ){
//    echo 'wrong';}
//    else {
//        echo $_POST['number'];
//    }
//}
//echo "<form method='post' action='test.php'><input type='text' name='date'/>";
//echo "<input type='submit'></form>";



//$card = new CreditCard();

//$cardList = $card->getCard('admin@xx.com');
//for ($i = 0; $i < count($cardList); $i++) {
//    if($cardList[$i]['isPrimary'] == 1){
//    echo $cardList[$i]['isPrimary'];
//}
//}

//$pCard = $card->getPC('admin@xx.com');  
//
//$numberArr = str_split($pCard['number']);
//echo "*********" . $numberArr[count($numberArr) - 4] . $numberArr[count($numberArr) - 3];



//
//$date = DateTime::createFromFormat('Y-m-d', $pCard['date']);
//
//$monthyear = $date->format('m/Y');
//
//echo $monthyear;

//$today = date('Y m');
//
//if ($monthyear <= $today) {
//    echo "True";
//} else{
//    echo "False";
//}