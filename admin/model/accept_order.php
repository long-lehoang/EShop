<?php 
    if (!defined('PATH_SYSTEM')) die ('Bad request');

    include_once PATH_SYSTEM . '/core/Model.php';
    
    //Khai bao utf-8 de hien thi duoc tieng viet
    header('Content-Type:text/html; charset=UTF-8');

    if(!isset($_GET['id']))
    die('ERROR');
    $id = $_GET['id'];
    $sold = $_GET['sold'];
    $sold = explode(" ",$sold);
    try{
       
        //update quantity product
        foreach($sold as $product)
        {
            $product = explode("_",$product);
            //check quantity available
            $stmt = $conn->prepare('SELECT quantity FROM PRODUCT WHERE id =:id');
            $stmt->execute([":id"=>$product[0]]);
            $qtt = $stmt->fetch(PDO::FETCH_ASSOC);
            if($qtt['quantity']<$product[1])
            die("<script language=javascript>alert('Sản phẩm đã hết hàng, hãy thêm hàng.');window.location='?a=neworder';</script>");

            $stmt = $conn->prepare('
            UPDATE PRODUCT
            SET quantity=quantity-:quantity,sold=sold+:quantity
            WHERE id=:id');
            $stmt->execute([":quantity"=>$product[1],":id"=>$product[0]]);

             //update status of payment
            $stmt = $conn->prepare("
            UPDATE PAYMENT
            SET status = 'Xác Nhận'
            WHERE id=:id");
            $stmt->execute([":id"=>$id]);
        }
        
        echo "<script language=javascript>window.location='?a=neworder';</script>";
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }

    