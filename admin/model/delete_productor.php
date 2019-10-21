<?php 
    if (!defined('PATH_SYSTEM')) die ('Bad request');

    include_once PATH_SYSTEM . '/core/Model.php';
    //Khai bao utf-8 de hien thi duoc tieng viet
    header('Content-Type:text/html; charset=UTF-8');
    
    if (!isset($_SESSION['name']))
    die('Ban khong duoc phep thuc hien tac vu nay');
    
    

    $id = $_GET['id'];

    try{
        $stmt = $conn->prepare('DELETE FROM PRODUCTOR WHERE PRODUCTOR.id = :id');
        $stmt->execute([":id"=>$id]);

        echo "<script language=javascript>window.location='?c=view&a=productor'</script>";
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }

    