<?php
if (!defined('PATH_SYSTEM')) die ('Bad Request');

//connect db if.....
include_once PATH_SYSTEM.'/core/Model.php';

if(!isset($_SESSION['cart']))
exit();

if(!isset($_POST['submit']))
    exit('<script language="javascript">window.history.go(-1) </script>');

$stmt = $conn->prepare('UPDATE CART_PRODUCT
                        SET quantity = :quantity
                        WHERE cart_id = :cart_id AND product_id =:product_id');
foreach($_POST['quantity'] as $product_id=>$quantity)
{
    if($quantity>0)
    {
        $stmt->execute([":quantity"=>$quantity,":cart_id"=>$_SESSION['cart'],":product_id"=>$product_id]);
    }
}

echo '<script language="javascript">window.history.go(-1) </script>';

