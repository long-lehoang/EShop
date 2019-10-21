<?php 
    if (!defined('PATH_SYSTEM')) die ('Bad request');

    include_once PATH_SYSTEM . '/core/Model.php';

    
    //Khai bao utf-8 de hien thi duoc tieng viet
    header('Content-Type:text/html; charset=UTF-8');

    $id = $_GET['id'];

    try{
        $stmt = $conn->prepare('DELETE FROM PRODUCT WHERE PRODUCT.id = :id');
        $stmt->execute([":id"=>$id]);

        echo "<script language=javascript>window.location='?c=view&a=index'</script>";
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }

    