<?php
if (!defined('PATH_SYSTEM')) die ('Bad Request');

    //connect database
    include_once PATH_SYSTEM.'/core/Model.php';

    //Khai bao utf-8 de hien thi duoc tieng viet
    header('Content-Type:text/html; charset=UTF-8');

    $id = $_GET['id'];
try
{
    $stmt = $conn->prepare('SELECT quantity FROM PRODUCT WHERE id =:id');
    $stmt->execute([":id"=>$id]);
    $qtt = $stmt->fetch(PDO::FETCH_ASSOC);
    if($qtt['quantity']>0)
    {
        //UPDATE PRODUCT
        $stmt = $conn->prepare('UPDATE PRODUCT
        SET quantity=quantity -1
        WHERE id=:id');
        $stmt->execute([":id"=>$id]);
    }
    echo "<script language=javascript> window.location='?'</script>";
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
    