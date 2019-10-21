<?php
if (!defined('PATH_SYSTEM')) die ('Bad Request');

//connect db
include_once PATH_SYSTEM.'/core/Model.php';
//display vietnamese language
header("Content-Type:text/html; charset:UTF-8");

//if don't have cart_id, create cart
if(!isset($_SESSION['cart']))
{
    try
    {
        //$price = 0;
        $stmt = $conn->prepare('INSERT INTO CART(price) VALUES(0)');
        $stmt->execute();
        $stmt = $conn->prepare('SELECT MAX(id) as id FROM CART');
        $stmt->execute();
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION['cart']=$cart['id'];
    }
    catch(PDOException $e)
    {
        echo "ERROR";
    }
}


if(!isset($_GET['id']))
    exit('<script language=javascript> window.history.go(-1) </script>');
if (isset($_POST['quantity']))
$quantity = $_POST['quantity'];
else {
    $quantity = 1;
}
$product = $_GET['id'];
$cart = $_SESSION['cart'];

$stmt = $conn->prepare('SELECT * FROM CART_PRODUCT WHERE cart_id = :cart_id AND product_id = :product_id');
$stmt->execute([":cart_id"=>$cart,":product_id"=>$product]);
if($stmt->fetch(PDO::FETCH_ASSOC))
{
    $stmt = $conn->prepare('UPDATE CART_PRODUCT
                            SET quantity = quantity + :quantity
                            WHERE cart_id = :cart_id AND product_id = :product_id');
    $stmt->execute([":cart_id"=>$cart,":product_id"=>$product,":quantity"=>$quantity]);
}
else {
    $stmt = $conn->prepare('INSERT INTO CART_PRODUCT (cart_id,product_id,quantity) VALUES (:cart_id,:product_id,:quantity)');
    $stmt->execute([":cart_id"=>$cart,":product_id"=>$product,":quantity"=>$quantity]);
}
echo '<script language=javascript> window.history.go(-1) </script>';