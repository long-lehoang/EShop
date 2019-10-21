<?php
if (!defined('PATH_SYSTEM')) die ('Bad Request');
    
        include_once PATH_SYSTEM.'/core/Model.php';
        //Kiem tra su kien dang ky
        if (!isset($_SESSION['name']))
        die('Ban khong duoc phep thuc hien tac vu nay');
                
        //Khai bao utf-8 de hien thi duoc tieng viet
        header('Content-Type:text/html; charset=UTF-8');
        //TÌM LIMIT VÀ CURRENT_PAGE
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 20;
            
        // Tìm Start
        $start = ($current_page - 1) * $limit;

        try
        {
            $stmt = $conn->prepare("SELECT * FROM VIEW_PRODUCT LIMIT $start,$limit");
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $list = $stmt->fetchAll();
        }
        catch(PDOException $e)
        {
            die($e->getMessage);
        }
        //Tim So Luong San Pham
		$stmt = $conn->prepare("SELECT count(id) as total FROM VIEW_PRODUCT ");
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
?>
<div class="grid_10">
        <div class="box round first">
            <h2>
                Danh Sách Sản Phẩm
            </h2>
            <div class="block">
                <table style="width:100%"> 
                    <tr>
                        <td><b>ID</b> </td>
                        <td><b>Tên</b> </td>
                        <td><b>Giá</b> </td>
                        <td><b>Số Lương</b> </td>
                        <td><b>Danh Mục</b> </td>
                        <td><b>Nhà Sản Xuất</b></td>
                        <td><b>Thao Tác</b></td>
                    </tr>   
                    <?php
                        foreach ($list as $data){
                    ?>
                    <tr>
                        <td>
                            <?php
                                echo $data['id'];
                            ?>
                        </td>
                        <td>
                            <a href="?c=view&a=editproduct&id=<?php echo $data['id'] ?>">
                            <?php
                                echo $data['name'];
                            ?>
                            </a>
                        </td>
                        <td>
                            <?php
                                echo $data['price'].' VNĐ';          
                            ?>
                        </td>
                        <td>
                            <a href="?c=product&a=subquantity&id=<?php echo $data['id']; ?>"><button >-</button></a>
                            <?php
                                echo $data['quantity'];
                            ?>
                            <a href="?c=product&a=addquantity&id=<?php echo $data['id']; ?>"><button >+</button></a>
                        </td>
                        <td>
                            <?php
                                echo $data['category'];
                            ?>
                        </td>
                        <td>
                            <?php
                                echo $data['productor']
                            ?>
                        </td>
                        <td><a href="?c=product&a=delete&id=<?php echo $data['id'] ?>"><b>Xóa</b></a></td>
                    </tr>
                    <?php }?>
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
								echo '<a href="admin.php?page='.($current_page-1).'">Prev</a> | ';
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
