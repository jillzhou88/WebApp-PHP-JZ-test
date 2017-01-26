<?php

session_start();
require "./model/Cart.php";

//insert into shopping cart table
if (!isset($_SESSION['check']) || ($_SESSION['check'] == FALSE)) {
    header('Location: login.php');
} else {
    $data = array('email' => $_SESSION['row']['email'], 'id' => $_GET['id'], 'qty' => $_GET['qty']);
    $cart = new Cart();

    //check if item is already in cart
    if ($cart->findItem($data) == FALSE) {
        $cart->addCart($data);
    } else {
        $qty = $cart->getQty($data);
        
        //check whether qty reach limit
        if ($qty['qty'] >= 5) {
            header('Location: ShoppingCart.php');
            exit;
        } else {
            $data['qty'] = $qty['qty'];
            $data['qty'] ++;
            $cart->updateQty($data);
        }
    }
    header('Location: ShoppingCart.php');
    exit;
}
?>