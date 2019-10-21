<?php
if (!defined('PATH_SYSTEM')) die ('Bad request');

        require_once PATH_SYSTEM . '/config/config.php';
        $DSN = "mysql:host = " . DB_HOST . ";dbname=" . DB_NAME;
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
        //Nhánh kết nối thành công
        try{
            //Kết nối

            $conn = new PDO($DSN,DB_USER,DB_PASSWORD,$options);
        }
        catch(PDOException $e){
            echo "Connect to database was failed." . $e->getMessage();
            exit;
        }
