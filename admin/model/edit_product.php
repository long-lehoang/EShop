<?php
if (!defined('PATH_SYSTEM')) die ('Bad Request');

    //connect database
    include_once PATH_SYSTEM.'/core/Model.php';

    //Khai bao utf-8 de hien thi duoc tieng viet
    header('Content-Type:text/html; charset=UTF-8');
        //Kiem tra su kien dang ky
    if(!isset($_POST['edit']))
    {
        die('ERROR');
    }
    if (!isset($_SESSION['name']))
    die('Ban khong duoc phep thuc hien tac vu nay');
    
    //die(var_dump($_POST['info']));

    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];
    $productor = $_POST['productor'];
    $info = $_POST['info'];
    //load file den thu muc trong server
    if(($_FILES["image"]["name"][0])!='')
    {
        //so luong file
        $num=count($_FILES["image"]["name"]);
    
        for($i = 0;$i < $num; $i++){
            $img = $_FILES["image"]["name"][$i];
            
            //tao duong dan chua file
            $dst[$i] = 'upload/'.$img;

            //check file type
            $allowed =  array('gif','png' ,'jpg');
            $ext = pathinfo($img, PATHINFO_EXTENSION);
            if(!in_array($ext,$allowed) ) {
                die('invalid');
            }

            //chuyen file den thu muc

            if(!move_uploaded_file($_FILES["image"]["tmp_name"][$i],$dst[$i]))
            die("Error upload!");
        }
    }
    
    
 

    if(!$name||!$price||!$quantity||!$category||!$productor||!$info)
    {
        die ("Please enter full information of Product");
    }
    try
    {
        //Get category_id
        $stmt = $conn->prepare('SELECT id FROM CATEGORY WHERE name = :name');
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute([":name"=>$category]);
        $category_id = $stmt->fetch();
        $category_id = $category_id['id'];
        
        //Get productor_id
        $stmt = $conn->prepare('SELECT id FROM PRODUCTOR WHERE name = :name');
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute([":name"=>$productor]);
        $productor_id = $stmt->fetch();
        $productor_id = $productor_id['id'];
        
        //UPDATE PRODUCT
        $stmt = $conn->prepare('UPDATE PRODUCT
        SET name=:name,price=:price,quantity=:quantity,category_id=:category_id,productor_id=:productor_id,info=:info
        WHERE id=:id');
        //
        
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':price',$price);
        $stmt->bindParam(':quantity',$quantity);
        $stmt->bindParam(':category_id',$category_id);
        $stmt->bindParam(':productor_id',$productor_id);
        $stmt->bindParam(':info',$info);
        $stmt->bindParam(':id',$id);
        $stmt->execute();

        //if image null, do nothing
        if(($_FILES["image"]["name"][0])!='')
        {
            //delete image 
            $stmt = $conn->prepare('DELETE FROM IMAGE_PRODUCT WHERE id=:id');
            $stmt->execute([":id"=>$id]);
            //INSERT IMAGE
            //insert image
            $stmt = $conn->prepare('INSERT INTO IMAGE_PRODUCT(id,image) VALUES(:id,:image)');
            foreach($dst as $image)
            {
                $stmt->execute([":id"=>$id,":image"=>$image]);            
            }
        }
        
        echo "<script language=javascript>alert('Thay Đổi Thành Công'); window.location='?c=view&a=index'</script>";
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
 
