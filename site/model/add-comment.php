<?php
if(!defined('PATH_SYSTEM')) die('Bad Request');

//connect db
include_once PATH_SYSTEM.'/core/Model.php';
//set vietnamese
header("Content-Type:text/html; charset:UTF-8");

//set data to insert
$name = $_SESSION['name'];
$product_id = (int)$_POST['product_id'];
$comment = $_POST['comment'];
$star = (int)$_POST['star'];

if(isset($_POST['parent']))
$parent = (int)$_POST['parent'];
else {
    $parent = 0;
}
//get rowCount comment of product
try{
    $stmt = $conn->prepare("SELECT id FROM COMMENT WHERE id = $product_id");
    $stmt->execute();
    $rowcount = $stmt->rowCount();
}
catch(PDOException $e)
{
    echo $e->getMessage();
}

//get current rate of product
try{
    $stmt = $conn->prepare("SELECT rate FROM PRODUCT WHERE id = $product_id");
    $stmt->execute();
    $rate = $stmt->fetch(PDO::FETCH_ASSOC);
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
$rate = (float)$rate['rate'];

$rate = (float)(($rate*$rowcount+$star)/($rowcount+1));
//insert to database

try{
    $stmt = $conn->prepare("INSERT INTO COMMENT(parent,product_id,comment,star,name)
                            VALUES (:parent,:product_id,:comment,:star,:name)");
    $stmt->bindParam(":parent",$parent,PDO::PARAM_INT);
    $stmt->bindParam(":product_id",$product_id,PDO::PARAM_INT);
    $stmt->bindParam(":comment",$comment,PDO::PARAM_STR);
    $stmt->bindParam(":star",$star,PDO::PARAM_INT);
    $stmt->bindParam(":name",$name,PDO::PARAM_STR);
    $stmt->execute();

    $stmt = $conn->prepare("UPDATE PRODUCT
                            SET rate = $rate
                            WHERE id = $product_id");
    $stmt->execute();
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
?>