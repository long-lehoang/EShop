<?php 
if(!defined('PATH_SYSTEM')) die ('Bad Request');


        if (isset($_SESSION['name']))
        {
            unset($_SESSION['cart']);
            unset($_SESSION['name']);
            
        }
        if (isset($_SESSION['voucher']))
        {
            unset($_SESSION['voucher']);
        }
        if (isset($_SESSION['user_id']))
        {
            unset($_SESSION['user_id']);
        }
        if (isset($_SESSION['user']))
        {
            unset($_SESSION['user']);
        }
        session_destroy();
        echo "<script language=javascript>window.location='?a=index' </script>";
?>
