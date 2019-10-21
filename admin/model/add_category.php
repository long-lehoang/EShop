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
//get url image
$img = $_FILES["image"]["name"];

//check form
if(!$name||!$img)
{
    die('Enter full information');
}

//create url to save image on server
$dst = 'upload/'.$img;

//check extension of image
$allowed = array('jpg','png','gif','jpeg');
$ext=pathinfo($img,PATHINFO_EXTENSION);

if(!in_array($ext,$allowed))
{
    die('Image invalid');
}
//save file to server
if(!move_uploaded_file($_FILES["image"]["tmp_name"],$dst))
    die("Error upload!");

//insert category
try{
    $stmt = $conn->prepare('INSERT INTO CATEGORY(name,image) VALUES(:name,:image)');
    $stmt->execute([":name"=>$name,":image"=>$dst]);
    echo "<script language='javascript'>alert('Thêm Thể Loại Thành Công'); window.location='?c=view&a=addcategory'</script>";
}
catch(PDOException $e){
    echo $e->getMessage;
}
