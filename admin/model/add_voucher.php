<?php 
if (!defined('PATH_SYSTEM')) die ('Bad request');
//connect db
include_once PATH_SYSTEM.'/core/Model.php';
//declare to use vietnamese language
header('Content-Type:text/html; charset=UTF-8');

//check event upload
if (!isset($_POST['upload']))
{
    die('ERROR');
}

$id = $_POST['code'];
$discount = $_POST['discount'];
$expire = $_POST['expire'];

if(!$id||!$discount||!$expire)
{

    die('<script language="javascript">
            alert("Vui lòng nhập đầy đủ thông tin");
            window.history.go(-1); </script>');
}

try
{
    $stmt = $conn->prepare('INSERT INTO VOUCHER(id,discount,expire) VALUES(:id,:discount,:expire)');
    $stmt->execute([":id"=>$id,":discount"=>$discount,":expire"=>$expire]);
    echo '<script language="javascript">
    alert("Thêm Mã Thành Công");
    window.history.go(-1); </script>';
}
catch(PDOException $e)
{
    echo $e->getMessage();
}