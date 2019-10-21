<?php
if (!defined('PATH_SYSTEM')) die ('Bad Request');

include_once PATH_SYSTEM.'/core/Model.php';

//load cart
try{
    //get cart_id
    $stmt = $conn->prepare('SELECT MAX(id) as id FROM CART WHERE user_id = :user_id');
    $stmt->execute([":user_id"=>$_SESSION['user_id']]);
    $id = $stmt->fetch(PDO::FETCH_ASSOC);
    $id = $id['id'];
    if (empty($id))
    {
        //create new cart
        $price = 0;
        $stmt = $conn->prepare('INSERT INTO CART(user_id,price) VALUES(:user_id,:price)');
        $stmt->execute([":user_id"=>$_SESSION['user_id'],":price"=>$price]);
        
        //set cart_id to session[cart]
        $stmt =$conn->prepare('SELECT MAX(id) as id FROM CART WHERE user_id =:user_id');
        $stmt->execute([":user_id"=>$_SESSION['user_id']]);
        $new_cart = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['cart'] = $new_cart['id'];
        exit('<script language=javascript> window.location="?a=index" </script>');
    }
    //check cart 
    $stmt = $conn->prepare('SELECT * FROM PAYMENT WHERE cart_id = :cart_id AND user_id = :user_id');
    $stmt->execute([":cart_id"=>$id,":user_id"=>$_SESSION['user_id']]);
    if(!empty($stmt->fetch(PDO::FETCH_ASSOC)))
    {
        //create new cart
        $price = 0;
        $stmt = $conn->prepare('INSERT INTO CART(user_id,price) VALUES(:user_id,:price)');
        $stmt->execute([":user_id"=>$_SESSION['user_id'],":price"=>$price]);
        
        //set cart_id to session[cart]
        $stmt =$conn->prepare('SELECT MAX(id) as id FROM CART WHERE user_id =:user_id');
        $stmt->execute([":user_id"=>$_SESSION['user_id']]);
        $new_cart = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['cart'] = $new_cart['id'];
    }
    //set cart_id 
    else
        $_SESSION['cart'] = $id;    
}
catch(PDOException $e)
{
    echo "Khong the load cart";
}        
echo '<script language=javascript> window.location="?a=index" </script>' ;