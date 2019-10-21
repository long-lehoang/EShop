<?php
if (!defined('PATH_SYSTEM')) die ('Bad Request');

        
        include_once PATH_SYSTEM.'/core/Model.php';
        if(!empty($_POST["submit"])){
        //lay gia tri user va password
        $user = addslashes($_POST["username"]);
        $password = addslashes($_POST["password"]);
        
        //kiem tra nhap du hay chua
        if(!$user||!$password){
            echo "Please to enter full information login.<a href='javascript: history.go(-1)'>Trở lại</a>";
            exit;
        }
        //kiem tra tai khoan co ton tai trong database
        $stmt = $conn->prepare('SELECT * FROM USER WHERE username = :user AND password = :password');
        try{
        $password = md5($password);
    
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        $stmt -> execute([":user" => $user , ":password" => $password]);
        
        }
        catch(PDOException $e)
        {
            echo "Error";
            exit;
        }
        $data = $stmt->fetch();
        if(!$data)
        {
            echo "Login failed.Please to login again.<a href='javascript: history.go(-1)'>Trở lại</a>";
            exit;
        }
        $_SESSION['name']=$data['fullname'];
        $_SESSION['user']=$data['username'];
        $_SESSION['user_id']=$data['id'];
        }
        echo "<script language='javascript'>window.location='?' </script>";
?>
