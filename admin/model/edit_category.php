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

if(!$name)
{
    die('Enter full information');
}

//get url image
if(!empty($_FILES["image"]["name"]))
{
    $img = $_FILES["image"]["name"];

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
        $stmt = $conn->prepare('UPDATE CATEGORY SET name = :name,image =:image WHERE id = :id');
        $stmt->execute([":name"=>$name,"image"=>$dst,":id"=>$id]);
        echo "<script language='javascript'>alert('Thay Đổi Thành Công'); window.location='?c=view&a=category'</script>";
    }
    catch(PDOException $e){
        echo $e->getMessage;
    }
}
else{
    try{
        $stmt = $conn->prepare('UPDATE CATEGORY SET name = :name WHERE id = :id');
        $stmt->execute([":name"=>$name,":id"=>$id]);
        echo "<script language='javascript'>alert('Thay Đổi Thành Công'); window.location='?c=view&a=category'</script>";
    }
    catch(PDOException $e){
        echo $e->getMessage;
    }
}
