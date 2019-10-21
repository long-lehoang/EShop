<?php
//statistic 
if (!defined('PATH_SYSTEM')) die ('Bad request');
        
//connect db 
include_once PATH_SYSTEM . '/core/Model.php';
/********Lấy dữ liệu lưu vào mảng**********/
        
//lấy danh sách đơn hàng trong 7 ngày trước
        
//duyệt tất cả hóa đơn
try{
    $stmt = $conn->prepare("SELECT date(time) as time,cart_id FROM PAYMENT WHERE status !='Chờ Xác Nhận' AND day(now())-day(time) < 31 ORDER BY time");
    $stmt->execute();
    $data_payment = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare('SELECT * FROM CATEGORY');
    $stmt->execute();
    $data_category = $stmt->fetchAll(PDO::FETCH_ASSOC);

}
catch(PDOException $e)
{
    echo $e->getMessage();
}

foreach($data_payment as $payment)
{
    //lấy dữ liệu giỏ hàng của đơn đặt hàng
    try{
        $stmt = $conn->prepare("SELECT * FROM CART_PRODUCT WHERE  CART_PRODUCT.cart_id = :cart_id ");
        $stmt->execute([":cart_id"=>$payment['cart_id']]);
        $data_cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
    
    //duyệt danh sách giỏ hàng đã đặt, thêm sản phẩm vào list 
    foreach($data_cart as $cart)
    {
        //lấy danh mục của sản phẩm để so sánh 
        try{
            $stmt = $conn->prepare('SELECT category_id FROM PRODUCT WHERE id = :id');
            $stmt->execute([":id"=>$cart['product_id']]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        
        //duyệt tất cả danh mục
        foreach($data_category as $category)
        {
            if(empty($list[$category['name']][$payment['time']]))
            $list[$category['name']][$payment['time']] = 0;
            //Tăng số lượng sản phẩm theo danh mục
            if ($category['id']==$product['category_id'])
            {
                $list[$category['name']][$payment['time']] += $cart['quantity'];
            }
        }
    }
}
/* Lưu dữ liệu vào file */
//Mở file để ghi 
//
//tạo dòng dữ liệu đầu tiên: list ngày 
$data_file = 'Danh Mục';
foreach($list as $category=>$data)
{
    foreach($data as $date => $quantity){
        $data_file .= ';'.$date;
    }
    $data_file .= '
';
    break;
}
//tạo dòng dữ liệu tiếp theo
foreach($list as $category =>$data)
{
    $data_file .= $category;
    foreach($data as $value)
    {
        $data_file .= ';'.$value;
    }
    $data_file .= '
';
}
        
$fp = @fopen('public/csv/data.csv','w');
        
// Kiểm tra file mở thành công hay chưa
if (!$fp) {
    echo 'Mở file không thành công ';
}
else
{
    fwrite($fp, $data_file);
    fclose($fp);
}
        

?>
<div class="grid_10">
    <div class="box round first">
        <div id="category-chart" style="min-width: 310px; height: 500px; margin: 0 auto">
        </div>
    </div>
</div>
