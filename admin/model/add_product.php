<?php
if (!defined('PATH_SYSTEM')) die ('Bad Request');

    //connect database
    include_once PATH_SYSTEM.'/core/Model.php';

    //Khai bao utf-8 de hien thi duoc tieng viet
    header('Content-Type:text/html; charset=UTF-8');
        //Kiem tra su kien dang ky
    if(!isset($_POST['upload']))
    {
        die('ERROR');
    }

    
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];
    $productor = $_POST['productor'];
    $info = $_POST['info'];
    //kiem tra san pham co trung ten hay khong
    try{
        $stmt = $conn->prepare('SELECT name FROM PRODUCT WHERE name = :name');
        $stmt->execute([":name"=>$name]);

        if(!empty($stmt->fetch(PDO::FETCH_ASSOC)))
        die ('Sản Phẩm Đã Tồn Tại');

    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
    //load file den thu muc trong server
    if(($_FILES["image"]["name"][0])=='')
    die("<script language=javascript>alert('Hãy thêm ảnh'); window.location='?c=view&a=addproduct'</script>");

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

 

    if(!$name||!$price||!$quantity||!$dst||!$category||!$productor||!$info)
    {
        die ("<script language=javascript>alert('Vui lòng điền đầy đủ thông tin sản phẩm'); window.location='?a=addproduct'</script>");
    }
    try
    {
        //Get category_id
        $stmt = $conn->prepare('SELECT id FROM CATEGORY WHERE name = :name ');
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

        //INSERT PRODUCT
        $stmt = $conn->prepare('INSERT INTO PRODUCT (name,price,quantity,category_id,productor_id,info) 
        values(:name,:price,:quantity,:category_id,:productor_id,:info)');
        //
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':price',$price);
        $stmt->bindParam(':quantity',$quantity);
        $stmt->bindParam(':category_id',$category_id);
        $stmt->bindParam(':productor_id',$productor_id);
        $stmt->bindParam(':info',$info);
        $stmt->execute();

        //INSERT IMAGE
        //get id product
        $stmt = $conn->prepare('SELECT MAX(id) as id  FROM PRODUCT');
        $stmt->execute();
        $id = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $id['id'];
        //insert image
        $stmt = $conn->prepare('INSERT INTO IMAGE_PRODUCT(id,image) VALUES(:id,:image)');
        foreach($dst as $image)
        {
            $stmt->execute([":id"=>$id,":image"=>$image]);            
        }
        echo "<script language=javascript>alert('Thêm Sản Phẩm Thành Công'); window.location='?a=addproduct'</script>";
    }
    catch(PDOException $e)
    {
        die ($e->getMessage());
    }
 
