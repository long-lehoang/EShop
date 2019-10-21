<?php
if (!defined('PATH_SYSTEM')) die ('Bad Request');

//connect db if.....
include_once PATH_SYSTEM.'/core/Model.php';

if(!isset($_SESSION['cart']))
exit();

$product_id = $_GET['id'];

try
{
    $stmt = $conn->prepare('DELETE FROM CART_PRODUCT WHERE cart_id = :cart_id AND product_id = :product_id');
    $stmt->execute([":cart_id"=>$_SESSION['cart'],":product_id"=>$product_id]);
}
catch(PDOException $e)
{
    echo "Có lỗi xảy ra, không thể xóa";
}

echo '<script language="javascript">window.history.go(-1) </script>';
