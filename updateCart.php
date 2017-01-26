<?php

session_start();
require "./model/Cart.php";
require './model/Products.php';

$option = isset($_POST['cartqty']);
if ($option) {
    $data = array('id' => $_POST['id'], 'qty' => $_POST['cartqty']);
    $cart = new Cart();
    $product = new Products();
    $row = $product->getProducts($data['id']);
    
    //only update when selected qty less than stored qty
    if ($data['qty'] <= $row['store']){
        $cart->updateQty($data);
    }
}

header('Location: ShoppingCart.php');
exit;
?>

