<?php
    
    // Đường dẫn tới hệ  thống
    define('PATH_SYSTEM', __DIR__ .'/system');
    define('PATH_APPLICATION', __DIR__ . '/admin');
    define('PATH_TEMPLATE',__DIR__.'/public/templates/admin');
    
    // $VALID_IMAGE = array('jpg','png','gif','jpeg');

    // Lấy thông số cấu hình
    require PATH_SYSTEM . '/config/config.php';
    
    //mở file Common.php, file này chứa hàm Load() chạy hệ thống
    include_once PATH_SYSTEM . '/core/Common.php';
    session_start();
    if(isset($_SESSION['is_admin'])&&($_GET['a']!='register')&&($_GET['c']!='ajax'))
    {

        include PATH_TEMPLATE.'/header.php';
        include PATH_TEMPLATE.'/menu.php';

    }
    // Chương trình chính
    load();
    if(isset($_SESSION['is_admin'])&&($_GET['a']!='register')&&($_GET['c']!='ajax'))
    {
        include PATH_TEMPLATE.'/footer.php';
    }


