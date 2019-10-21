<?php
if (!defined('PATH_SYSTEM')) die ('Bad Request');

include_once PATH_SYSTEM.'/core/Model.php';

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