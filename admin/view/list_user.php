<?php

if (!defined('PATH_SYSTEM')) die ('Bad Request');
     

include_once PATH_SYSTEM.'/core/Model.php';
//Kiem tra su kien dang ky
if (!isset($_SESSION['name']))
die('Ban khong duoc phep thuc hien tac vu nay');
                 
//Khai bao utf-8 de hien thi duoc tieng viet
header('Content-Type:text/html; charset=UTF-8');
try
{
    $stmt = $conn->prepare('SELECT * FROM USER WHERE is_admin = 1');
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    $list = $stmt->fetchAll();
}
catch(PDOException $e)
{
    echo 'error';
}

?>
<div class="grid_10">
    <div class="box round first">
        <h2>Danh Sách Tài Khoản Admin</h2>
        <table style="width:100%">
            <tr>
                <td><b>ID</b></td>
                <td><b>Tên Đăng Nhập</b></td>
                <td><b>Họ Và Tên</b></td>
                <td><b>Thao Tác</b></td>
            </tr>
            <?php
                foreach($list as $user)
                {
            ?>
            <tr>
                <td>
                    <?php echo $user['id'];?>
                </td>
                <td>
                    <?php echo $user['username'];?>
                </td>
                <td>
                    <?php echo $user['fullname'];?>
                </td>
                <td>
                    <a href="?c=user&a=delete&id=<?php echo $user['id']; ?>">Xóa</a>
                </td>
            </tr>
            <?php
                }
            ?>
        </table>
    </div>
</div>