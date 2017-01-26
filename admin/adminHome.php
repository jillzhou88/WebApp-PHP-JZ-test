<?php
session_start();
require "../model/Address.php";
require "../model/Order.php";
require "../model/Products.php";
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Homepage</title>
        
        <link type="text/css" rel="stylesheet" href="../admin/admincss.css">
        
        <link rel="stylesheet" href="../jquery-ui-1.12.1/jquery-ui.css">
        <link rel="stylesheet" href="../jquery-ui-1.12.1/jquery-ui.min.css">
        <link rel="stylesheet" href="../jquery-ui-1.12.1/jquery-ui.structure.css">
        <link rel="stylesheet" href="../jquery-ui-1.12.1/jquery-ui.structure.min.css">
        <link rel="stylesheet" href="../jquery-ui-1.12.1/jquery-ui.theme.css">
        <link rel="stylesheet" href="../jquery-ui-1.12.1/jquery-ui.theme.min.css">
                
        <script src="../jquery-ui-1.12.1/external/jquery/jquery.js"></script>
        <script src="../jquery-ui-1.12.1/jquery-ui.js"></script>
        <script src="../jquery-ui-1.12.1/jquery-ui.min.js"></script>
        <script>
        $( function() {
            $( "#tabs" ).tabs();
        } );
        </script>
    </head>
    <body>        
        <div id="tabs">
  <ul>
    <li><a href="#tabs-1">Orders Processing</a></li>
    <li><a href="#tabs-2">Products Management</a></li>
    <li><a href="#tabs-3">Aenean lacinia</a></li>
  </ul>
  <div id="tabs-1">
      <p>
      <table>
          <tr>                                    
              <th><b>Order Number</b></th>
              <th><b>Products</b></th>
              <th><b>Shipping Address</b></th>
              <th><b>Status</b></th>              
          </tr>
          <?php
          //get order table
          $order = new Order();
          $orders = $order->getOrder();

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
          }
          ?>
      </table>
  </p>
  </div>
  <div id="tabs-2">
      <p></p>
  </div>
  <div id="tabs-3">
      <p></p>
  </div>
</div>
    </body>
</html>
