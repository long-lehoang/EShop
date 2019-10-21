<?php 
if (!defined('PATH_SYSTEM')) die ('Bad request');
//connect db
include_once PATH_SYSTEM.'/core/Model.php';
//declare to use vietnamese language
header('Content-Type:text/html; charset=UTF-8');

//check event upload
if (!isset($_POST['upload']))
{
    die('ERROR');
}

//get data from form

//get name
$name = $_POST['name'];
//get info
$info = $_POST['info'];
//check form
if(!$name||!$info)
{
    die('Enter full information');
}

//insert productor
try{
    $stmt = $conn->prepare('INSERT INTO PRODUCTOR(name,info) VALUES(:name,:info)');
    $stmt->execute([":name"=>$name,":info"=>$info]);
    echo "<script language='javascript'>alert('Thêm Nhà Sản Xuất Thành Công'); window.location='?c=view&a=addproductor'</script>";
}
catch(PDOException $e){
    echo $e->getMessage;
}
