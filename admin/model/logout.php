<?php 
if(!defined('PATH_SYSTEM')) die ('Bad Request');


        if (isset($_SESSION['name']))
        {
            unset($_SESSION['name']);
        }
        if (isset($_SESSION['user_id']))
        {
            unset($_SESSION['user_id']);
        }
        if (isset($_SESSION['user']))
        {
            unset($_SESSION['user']);
        }
        if (isset($_SESSION['is_admin']))
        {
            unset($_SESSION['is_admin']);
        }
        session_destroy();
?>
