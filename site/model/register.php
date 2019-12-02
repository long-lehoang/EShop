<?php
if (!defined('PATH_SYSTEM')) die ('Bad Request');
    
        include_once PATH_SYSTEM.'/core/Model.php';
        //Kiem tra su kien dang ky
        if(!isset($_POST['username']))
        {
            die('Enter full information');
        }
        
        //Khai bao utf-8 de hien thi duoc tieng viet
        header('Content-Type:text/html; charset=UTF-8');

        //Lay du lieu dang ky
        $name       =   addslashes($_POST['fullname']); 
        $user       =   addslashes($_POST['username']);
        $password   =   addslashes($_POST['password']);
        $c_password =   addslashes($_POST['c_password']);
        $phone      =   addslashes($_POST['phone']);
        $email      =   addslashes($_POST['email']);
        $birthday   =   addslashes($_POST['birthday']);
        $sex        =   addslashes($_POST['gender']);
        $address    =   addslashes($_POST['address']);
        //Kiem tra thong tin day du chua
        if(!$name||!$user||!$password||!$c_password||!$email||!$birthday||$sex='n'|!$phone|!$address)
        {
            echo "Please to enter full information!";
            exit;
        }
        
        //Kiem tra password
        if($password!=$c_password){
            echo "Check password";
            exit;
        }

        //ma hoa password
        $password = md5($password);
        
        //Kiem tra ten dang nhap
        $stmt = $conn->prepare('SELECT * FROM USER WHERE username = :user'); 
        try{
        
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute([":user" => $user]);

        }
        catch(PDOException $e){
            $e->getMessage();
        }
        
        if ($stmt->fetch()){
            echo "Username has already exist.Please to enter username again. <a href='javascript: history.go(-1)'>Return</a>";
            exit;
        }
        
        //Kiem tra email co ton tai
        $stmt = $conn->prepare('SELECT * FROM USER WHERE email = :email');
        try{
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute([":email" => $email]);
        
        }
        
        catch(PDOException $e)
        {
            echo "ERROR";
            exit;
        }
        
        //kiem tra du lieu tra ve co null
        if ($stmt->fetch()){
            
            echo "Email has already exist.Please to enter different email. <a href='javascript: history.go(-1)'>Return</a> ";
            exit;
        }
        
        //Kiem tra ngay sinh
        //Kiểm tra dạng nhập vào của ngày sinh
        try{
        $stmt = $conn->prepare('INSERT INTO USER (username,password,email,phone,fullname,birthday,sex,address) 
        VALUES (:user,:password,:email,:phone,:fullname,:birthday,:sex,:address)');
        //Set values
        $stmt->bindParam(':user',$user);
        $stmt->bindParam(':password',$password);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':phone',$phone);
        $stmt->bindParam(':fullname',$name);
        $stmt->bindParam(':birthday',$birthday);
        $stmt->bindParam(':sex',$sex);
        $stmt->bindParam(':address',$address);

        //execute
        
        $stmt->execute();
            
        echo "Dang Ki Thanh Cong.<a href='?c=index'>Về trang chủ</a>";
        }
        catch(PDOException $e){
            echo "Khong the them tai khoan!\n";
            exit;
        }
 
?>