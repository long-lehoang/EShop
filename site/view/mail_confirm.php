<?php 
if(!defined('PATH_SYSTEM')) die ('Bad Request');

//connect db
if(@include(PATH_SYSTEM.'/core/Model.php'))
{
    include_once PATH_SYSTEM.'/core/Model.php';
}
header("Content-Type:html/text; charset:UTF-8");
$cart_id = (int)$_SESSION['cart'];
//get total_price
$stmt = $conn->prepare("SELECT price FROM CART WHERE id = $cart_id");
try{
    $stmt->execute();
    $total = $stmt->fetch(PDO::FETCH_ASSOC);  
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
$total = (int)$total['price'];

//get voucher
if(isset($_SESSION['voucher']))
{
    $voucher_id = (int)$_SESSION['voucher'];
    try{
        $stmt = $conn->prepare("SELECT discount FROM VOUCHER WHERE id = $voucher_id");
        $stmt->execute();
        $discount = $stmt->fetch(PDO::FETCH_ASSOC);
        $discount = (int) $discount['discount'];
        $discount = $discount*$total/100;
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
}
else {
    $discount = 0;
}
$total_current = $total-$discount;
//get cart_product
try{
    $stmt = $conn->prepare("SELECT * FROM CART_PRODUCT WHERE cart_id = $cart_id");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);    
}
catch(PDOException $e)
{
    echo $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Confirm Order</title>
</head>
<body style="width: 600px;height: 400;">
        <table align="center" bgcolor="#dcf0f8" border="0" cellpadding="0" cellspacing="0" style="margin:0;padding:0;background-color:#f2f2f2;width:100%!important;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px" width="100%">
                <tbody>
                    <tr>
                        <td align="center" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top">
                        <table border="0" cellpadding="0" cellspacing="0" style="margin-top:15px" width="600">
                            <tbody>
                                <tr style="background:#fff">
                                    <td align="left" height="auto" style="padding:15px" width="600">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <a href="index.php"><img src="public/images/home/logo.png" alt="" /></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                <h1 style="font-size:17px;font-weight:bold;color:#444;padding:0 0 5px 0;margin:0">Cảm ơn quý khách <?php echo $_POST['name'];?> đã đặt hàng tại <span class="il">EShop</span>,</h1>
                                                
                                                <p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"><span class="il">EShop</span> rất vui thông báo đơn hàng của quý khách đã được tiếp nhận và đang trong quá trình xử lý. <span class="il">EShop</span> sẽ thông báo đến quý khách ngay khi hàng chuẩn bị được giao.</p>
                                                
                                                <h3 style="font-size:13px;font-weight:bold;color:#02acea;text-transform:uppercase;margin:20px 0 0 0;border-bottom:1px solid #ddd">Thông tin đơn hàng <span style="font-size:12px;color:#777;text-transform:none;font-weight:normal">(<?php echo 'Thời gian đặt hàng:'.date('d-m-y');?>)</span></h3>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th align="left" style="padding:6px 9px 0px 9px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:bold" width="50%">Thông tin thanh toán</th>
                                                            <th align="left" style="padding:6px 9px 0px 9px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:bold" width="50%"> Địa chỉ giao hàng </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="padding:3px 9px 9px 9px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top"><span style="text-transform:capitalize"><?php echo $_POST['name'];?></span><br>
                                                            <a href="mailto:hoanglongherobook@gmail.com" target="_blank"><?php echo $_POST['email'];?></a><br>
                                                            <?php echo $_POST['phone'];?></td>
                                                            <td style="padding:3px 9px 9px 9px;border-top:0;border-left:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top"><span style="text-transform:capitalize"><?php echo $_POST['name'];?></span><br>
                                                            <br>
                                                            <?php echo $_POST['address'];?>
                                                            <br>
                                                             T: <?php echo $_POST['phone'];?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="padding:7px 9px 0px 9px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444" valign="top">
                                                            <p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"><strong>Phương thức thanh toán: </strong> Thanh toán tiền mặt khi nhận hàng<br>
                                                            <strong>Phí vận chuyển: </strong> 0&nbsp;₫<br>
                                                             </p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                <p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"><i>Lưu ý: Đối với đơn hàng đã được thanh toán trước, nhân viên giao nhận có thể yêu cầu người nhận hàng cung cấp CMND / giấy phép lái xe để chụp ảnh hoặc ghi lại thông tin.</i></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                <h2 style="text-align:left;margin:10px 0;border-bottom:1px solid #ddd;padding-bottom:5px;font-size:13px;color:#02acea">CHI TIẾT ĐƠN HÀNG</h2>
            
                                                <table border="0" cellpadding="0" cellspacing="0" style="background:#f5f5f5" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th align="left" bgcolor="#02acea" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Sản phẩm</th>
                                                            <th align="left" bgcolor="#02acea" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Đơn giá</th>
                                                            <th align="left" bgcolor="#02acea" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Số lượng</th>
                                                            <th align="left" bgcolor="#02acea" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Giảm giá</th>
                                                            <th align="right" bgcolor="#02acea" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Tổng tạm</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody bgcolor="#eee" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">											
                                                        <?php //data biding 
                                                            foreach($result as $cart)
                                                            {
                                                                $product_id = (int)$cart['product_id'];
                                                                try{
                                                                    $stmt = $conn->prepare("SELECT name,price FROM PRODUCT WHERE id = $product_id");
                                                                    $stmt->execute();
                                                                    $product = $stmt->fetch(PDO::FETCH_ASSOC);
                                                                }
                                                                catch(PDOException $e)
                                                                {
                                                                    echo $e->getMessage();
                                                                }
                                                        ?>
                                                        <tr>
                                                            <td align="left" style="padding:3px 9px" valign="top"><span><?php echo $product['name'];?></span><br>
                                                            </td>
                                                            <td align="left" style="padding:3px 9px" valign="top"><span><?php echo $product['price'];?>&nbsp;₫</span></td>
                                                            <td align="left" style="padding:3px 9px" valign="top"><?php echo $cart['quantity'];?></td>
                                                            <td align="left" style="padding:3px 9px" valign="top"><span><?php echo $discount;?>&nbsp;₫</span></td>
                                                            <td align="right" style="padding:3px 9px" valign="top"><span><?php echo $product['price']*$cart['quantity'];?>&nbsp;₫</span></td>
                                                        </tr>
                                                        <?php //end for
                                                            } 
                                                        ?>
                                                    </tbody>
                                                    <tfoot style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">											<tr>
                                                            <td align="right" colspan="4" style="padding:5px 9px">Tổng tạm tính</td>
                                                            <td align="right" style="padding:5px 9px"><span><?php echo $total_current;?>&nbsp;₫</span></td>
                                                        </tr>
                                                                                                    <tr>
                                                            <td align="right" colspan="4" style="padding:5px 9px">Phí vận chuyển</td>
                                                            <td align="right" style="padding:5px 9px"><span>0&nbsp;₫</span></td>
                                                        </tr>
                                                                                                    <tr bgcolor="#eee">
                                                            <td align="right" colspan="4" style="padding:7px 9px"><strong><big>Tổng giá trị đơn hàng</big> </strong></td>
                                                            <td align="right" style="padding:7px 9px"><strong><big><span><?php echo $total_current;?>&nbsp;₫</span> </big> </strong></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
            
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;                                                                                                
                                                <p style="margin:10px 0 0 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">Bạn cần được hỗ trợ ngay? Chỉ cần email <a href="mailto:long.bk.khmt@gmail.com" style="color:#099202;text-decoration:none" target="_blank"> <strong>long.bk.khmt@<span class="il">gmail</span>.com</strong> </a>, hoặc gọi số điện thoại <strong style="color:#099202">0938186100</strong> (8-21h cả T7,CN).<span class="il">EShop</span> luôn sẵn sàng hỗ trợ bạn bất kì lúc nào.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;
                                                <p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;line-height:18px;color:#444;font-weight:bold">Một lần nữa <span class="il">EShop</span> cảm ơn quý khách.</p>
                                                <p align="right"><strong>EShop</strong></p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
</body>
</html>