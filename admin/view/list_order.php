<?php
if (!defined('PATH_SYSTEM')) die ('Bad Request');
    

        include_once PATH_SYSTEM.'/core/Model.php';
        
        //Khai bao utf-8 de hien thi duoc tieng viet
        header('Content-Type:text/html; charset=UTF-8');

        if (!isset($_SESSION['name']))
        die('Ban khong duoc phep thuc hien tac vu nay');
                
        //TÌM LIMIT VÀ CURRENT_PAGE
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

        //////////////////////////
        $limit = 10;
        //////////////////////////

        // Tìm Start
        $start = ($current_page - 1) * $limit;
        $stmt = $conn->prepare("SELECT count(id) as total FROM PAYMENT ");
        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_ASSOC);												
        $total_records = $total['total'];
        // tổng số trang
        $total_page = ceil($total_records / $limit);
        // Giới hạn current_page trong khoảng 1 đến total_page
        if ($current_page > $total_page){
            $current_page = $total_page;
        }
        else if ($current_page < 1){
            $current_page = 1;
        }

        // Get all payment 
        try
        {

            $stmt = $conn->prepare("SELECT * FROM PAYMENT ORDER BY time LIMIT $start,$limit");
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            $stmt->execute();

            $list = $stmt->fetchAll();
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
?>
<div class="grid_10">
        <div class="box round first">
            <h2>
                Danh Sách Đơn Đặt Hàng
            </h2>
            <div class="block">
                <table style="width:100%"> 
                    
                    <tr>
                        <td><b>ID</b> </td>
                        <td><b>Tên</b> </td>
                        <td><b>Số Điện Thoại</b> </td>
                        <td><b>Địa Chỉ</b> </td>
                        <td><b>Sản Phẩm/Số Lượng</b> </td>
                        <td><b>Ngày Đặt</b></td>
                        <td><b>Giảm Giá</b></td>
                        <td><b>Tình Trạng</b></td>
                        <td><b>Thao Tác</b></td>
                    </tr>
                    <!-- print payment -->
                    <?php
                        foreach ($list as $payment)
                        {
                           
                    ?>
                    <tr>
                        <td>
                            <?php
                                echo $payment['id'];
                            ?>
                        </td>
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
                        <td><?php if($payment['status']!='Xác Nhận') echo '<a href="?c=order&a=accept&id='.$payment['id'].'&sold='.$sold.'"><b>Xác Nhận</b></a>';?></td>
                    </tr>
                    <!-- end print and catch error db -->
                    <?php         
                    }?>
                </table>
                <div class="pagination">
                <?php
							$str='';
							if (isset($_GET['c']))
							$str .= 'c='.$_GET['c'].'&';
							if (isset($_GET['a']))
							$str .= 'a='.$_GET['a'].'&'; 
							// PHẦN HIỂN THỊ PHÂN TRANG
							// BƯỚC 7: HIỂN THỊ PHÂN TRANG
							
							// nếu current_page > 1 và total_page > 1 mới hiển thị nút prev
							if ($current_page > 1 && $total_page > 1){
								echo '<a href="admin.php?'.$str.'page='.($current_page-1).'">Prev</a> | ';
							}
							
							// Lặp khoảng giữa
							if ($total_page>1){
								for ($i = 1; $i <= $total_page; $i++){
									// Nếu là trang hiện tại thì hiển thị thẻ span
									// ngược lại hiển thị thẻ a
									if ($i == $current_page){
										echo '<span>'.$i.'</span> | ';
									}
									else{
										echo '<a href="admin.php?'.$str.'page='.$i.'">'.$i.'</a> | ';
									}
								}
							}
							
							// nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
							if ($current_page < $total_page && $total_page > 1){
								echo '<a href="admin.php?'.$str.'page='.($current_page+1).'">Next</a>';
							}
							?>
                </div>
            </div>
        </div>
</div>    
<div class="grid_5">
</div>
