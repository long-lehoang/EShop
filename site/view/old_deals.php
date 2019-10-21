<?php
if (!defined('PATH_SYSTEM')) die('Bad Request');

//connect 
include_once PATH_SYSTEM.'/core/Model.php';

header("Content-Type:text/html; charset:UTF-8");

try
        {

            $stmt = $conn->prepare('SELECT * FROM PAYMENT WHERE user_id = :user_id ORDER BY id');
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            $stmt->execute([":user_id"=>$_SESSION['user_id']]);
            $list = $stmt->fetchAll();
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
?>
<section>
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
    <table style="width:100%"> 
                    <tr>
                        <td><b>Tên</b> </td>
                        <td><b>Số Điện Thoại</b> </td>
                        <td><b>Địa Chỉ</b> </td>
                        <td><b>Sản Phẩm/Số Lượng</b> </td>
                        <td><b>Ngày Đặt</b></td>
                        <td><b>Giảm Giá</b></td>
                        <td><b>Tình Trạng</b></td>
                    </tr>
                    <!-- print payment -->
                    <?php
                        foreach ($list as $payment)
                        {
                           
                    ?>
                    <tr>
                        
                        <td>
                            <?php
                                echo $payment['name'];
                            ?>
                        </td>
                        <td>
                            <?php
                                echo $payment['phone'];          
                            ?>
                        </td>
                        <td>
                            <?php
                                echo $payment['address'];
                            ?>
                        </td>
                        <td>
                        <table>
                        <!-- print data of cart -->
                        <?php 
                            $stmt = $conn->prepare('SELECT PRODUCT.name as product_name,PRODUCT.id as product_id,CART_PRODUCT.quantity as quantity
                                                    FROM CART_PRODUCT,PRODUCT WHERE CART_PRODUCT.cart_id = :cart_id 
                                                    AND CART_PRODUCT.product_id=PRODUCT.id ');
                            $stmt->execute([":cart_id"=>$payment['cart_id']]);
                            $list1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            $sold = '';
                            foreach ($list1 as $cart)
                                {
                                    $sold .= $cart['product_id'].'_'.$cart['quantity'].' ';
                        ?>
                            <tr>
                                <td>
                                <?php
                                    echo $cart['product_name'];
                                ?>
                                -
                                </td>
                                <td>
                                <?php
                                    echo $cart['quantity'];
                                ?>
                                
                                </td>
                            </tr>
                            <?php }?>
                            </table>
                        </td>
                        <td>
                            <?php
                                echo $payment['time'];
                            ?>
                        </td>
                        <td>
                        <!-- print value of voucher -->
                            <?php 
                                $stmt = $conn->prepare('SELECT VOUCHER.discount FROM VOUCHER WHERE VOUCHER.id= :voucher_id');
                                $stmt->execute([":voucher_id"=>$payment['voucher_id']]);
                                $discount = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo $discount['discount'].'%';
                            ?>
                        </td>
                        <td>
                            <?php
                                echo $payment['status'];
                            ?>
                        </td>
                    </tr>
                    <!-- end print and catch error db -->
                    <?php         
                    }?>
                </table>
    </div>
</section>