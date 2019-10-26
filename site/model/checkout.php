<?php
if (!defined('PATH_SYSTEM')) die ('Bad Request');

//connect db
if(@include(PATH_SYSTEM.'/core/Model.php'))
{
    include_once PATH_SYSTEM.'/core/Model.php';
}
header('Content-Type:text/html; charset:UTF-8');
if(!isset($_SESSION['cart']))
exit('Không có sản phẩm để thanh toán');
//get form
$name = $_POST['name'];
$phone = $_POST['phone'];
$address = $_POST['address'];
if(!$name||!$phone||!$address)
die('<script language=javascript>alert("Vui lòng nhập đầy đủ thông tin"); window.history.go(-1) </script>');
//update info user
if (isset($_SESSION['user_id']))
{
    try
    {
        $stmt = $conn->prepare('SELECT fullname,phone,address FROM USER WHERE id=:user_id');
        $stmt->execute([":user_id"=>$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user['fullname']!=$name&&$user['phone']!=$phone&&$user['address']!=$address)
        {
            try
            {
                $stmt = $conn->prepare('UPDATE USER
                                        SET fullname =:fullname AND phone =:phone AND address =:address
                                        WHERE id=:user_id ');
                $stmt->execute([":fullname"=>$name,":phone"=>$phone,":address"=>$address,":user_id"=>$_SESSION['user_id']]);
            }
            catch(PDOException $e)
            {
                echo "ERROR";
            }
        }
        elseif($user['fullname']!=$name&&$user['phone']!=$phone)
        {
            try
            {
                $stmt = $conn->prepare('UPDATE USER
                                        SET fullname =:fullname AND phone =:phone
                                        WHERE id=:user_id ');
                $stmt->execute([":fullname"=>$name,":phone"=>$phone,":user_id"=>$_SESSION['user_id']]);
            }
            catch(PDOException $e)
            {
                echo "ERROR";
            }
        }
        elseif($user['phone']!=$phone&&$user['address']!=$address)
        {
            try
            {
                $stmt = $conn->prepare('UPDATE USER
                                        SET phone =:phone AND address =:address
                                        WHERE id=:user_id ');
                $stmt->execute([":phone"=>$phone,":address"=>$address,":user_id"=>$_SESSION['user_id']]);
            }
            catch(PDOException $e)
            {
                echo "ERROR";
            }
        }
        elseif($user['address']!=$address&&$user['fullname']!=$name)
        {
            try
            {
                $stmt = $conn->prepare('UPDATE USER
                                        SET fullname =:fullname AND address =:address
                                        WHERE id=:user_id ');
                $stmt->execute([":fullname"=>$name,":address"=>$address,":user_id"=>$_SESSION['user_id']]);
            }
            catch(PDOException $e)
            {
                echo "ERROR";
            }
        }
        elseif($user['fullname']!=$name)
        {
            try
            {
                $stmt = $conn->prepare('UPDATE USER
                                        SET fullname =:fullname
                                        WHERE id=:user_id ');
                $stmt->execute([":fullname"=>$name,":user_id"=>$_SESSION['user_id']]);
            }
            catch(PDOException $e)
            {
                echo "ERROR";
            }
        }
        elseif($user['phone']!=$phone)
        {
            try
            {
                $stmt = $conn->prepare('UPDATE USER
                                        SET phone =:phone
                                        WHERE id=:user_id ');
                $stmt->execute([":phone"=>$phone,":user_id"=>$_SESSION['user_id']]);
            }
            catch(PDOException $e)
            {
                echo "ERROR";
            }
        }
        elseif($user['address']!=$address)
        {
            try
            {
                $stmt = $conn->prepare('UPDATE USER
                                        SET address =:address
                                        WHERE id=:user_id ');
                $stmt->execute([":address"=>$address,":user_id"=>$_SESSION['user_id']]);
            }
            catch(PDOException $e)
            {
                echo "ERROR";
            }
        }
    }
    catch(PDOException $e)
    {
        echo "ERROR";
    }
}

//create payment


if(!isset($_SESSION['voucher'])&&!isset($_SESSION['user_id']))
{
    try
    {
        $stmt = $conn->prepare('INSERT INTO PAYMENT(cart_id,name,phone,address) VALUES(:cart_id,:name,:phone,:address)');

        $stmt->execute([":cart_id"=>$_SESSION['cart'],":name"=>$name,":phone"=>$phone,":address"=>$address]);
        
    }
    catch(PDOException $e)
    {
        echo '<script language=javascript>alert("Thanh Toán thất bại") window.history.go(-1) </script>';
    }
}
elseif(!isset($_SESSION['voucher'])) 
{
    try
    {
        $stmt = $conn->prepare('INSERT INTO PAYMENT(cart_id,user_id,time,name,phone,address) VALUES(:cart_id,:user_id,now(),:name,:phone,:address)');
        $stmt->execute([":cart_id"=>$_SESSION['cart'],":user_id"=>$_SESSION['user_id'],":name"=>$name,":phone"=>$phone,":address"=>$address]);
    }
    catch(PDOException $e)
    {
        echo '<script language=javascript>alert("Thanh Toán thất bại") window.history.go(-1) </script>';
    }
}
elseif(!isset($_SESSION['user_id']))
{
    try
    {
        $stmt = $conn->prepare('INSERT INTO PAYMENT(cart_id,voucher_id,time,name,phone,address) VALUES(:cart_id,:voucher_id,now(),:name,:phone,:address)');
        $stmt->execute([":cart_id"=>$_SESSION['cart'],":voucher_id"=>$_SESSION['voucher'],":name"=>$name,":phone"=>$phone,":address"=>$address]);
    }
    catch(PDOException $e)
    {
        echo '<script language=javascript>alert("Thanh Toán thất bại") window.history.go(-1) </script>';
    }
}
else {
    try
    {
        $stmt = $conn->prepare('INSERT INTO PAYMENT(cart_id,user_id,voucher_id,time,name,phone,address) VALUES(:cart_id,:user_id,:voucher_id,now(),:name,:phone,:address)');
        $stmt->execute([":cart_id"=>$_SESSION['cart'],":user_id"=>$_SESSION['user_id'],":voucher_id"=>$_SESSION['voucher'],":name"=>$name,":phone"=>$phone,":address"=>$address]);
    }
    catch(PDOException $e)
    {
        echo '<script language=javascript>alert("Thanh Toán thất bại") window.history.go(-1) </script>';
    }
}
//destroy cart
unset($_SESSION['cart']);
//new cart of user
if(isset($_SESSION['user_id']))
{
    try{
        $stmt = $conn->prepare('INSERT INTO CART(user_id,price) VALUES(:user_id,0)');
        $stmt->execute([":user_id"=>$_SESSION['user_id']]);
            
        //set cart_id to session[cart]
        $stmt =$conn->prepare('SELECT MAX(id) as id FROM CART WHERE user_id =:user_id');
        $stmt->execute([":user_id"=>$_SESSION['user_id']]);
        $new_cart = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['cart'] = $new_cart['id'];
    }
    catch(PDOException $e)
    {
        echo "ERROR";
    }
}

echo '<script language=javascript>alert("Thanh Toán thành công"); window.location="?" </script>';