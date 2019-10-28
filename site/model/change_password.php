<?php
if (!defined('PATH_SYSTEM')) die ('Bad Request');

//connect db
include_once PATH_SYSTEM.'/core/Model.php';

header('Content-Type:text/html; charset:UTF-8');

//check event
if (!isset($_POST['change_pass']))
die ('<script language="javascript"> alert("Không được phép truy cập!");window.location="?"; </script>"');
//check pass
$password = $_POST['password'];
$new_password = $_POST['new_password'];
//
$password = md5($password);
$new_password = md5($new_password);
try
{
    $stmt = $conn->prepare('SELECT password FROM USER WHERE id =:user_id AND password =:password');
    $stmt->execute([":user_id"=>$_SESSION['user_id'],":password"=>$password]);
    if($stmt->fetch(PDO::FETCH_ASSOC))
    {
        $stmt = $conn->prepare('UPDATE USER
                                SET password =:newpassword
                                WHERE id = :user_id');
        $stmt->execute([":newpassword"=>$new_password,":user_id"=>$_SESSION['user_id']]);
        die ('<script language="javascript">alert("Đổi Mật Khẩu Thành Công");window.history.go(-2); </script>"');
    }
    else {
        die ('<script language="javascript">alert("Sai mật khẩu!");window.location="?a=change_pass"; </script>"');
    }
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
