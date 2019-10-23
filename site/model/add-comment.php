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
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
?>