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
$id = $_POST['id'];
//get name
$name = $_POST['name'];
//get info
$info = $_POST['info'];
//check form
if(!$name||!$info||!$id)
{
    die('Enter full information');
}

//insert productor
try{
    $stmt = $conn->prepare('UPDATE PRODUCTOR SET name = :name,info = :info WHERE id= :id');
    $stmt->execute([":name"=>$name,":info"=>$info,":id"=>$id]);
    echo "<script language='javascript'>alert('Thay Đổi Thành Công'); window.location='?c=view&a=productor'</script>";
}
catch(PDOException $e){
    echo $e->getMessage;
}
