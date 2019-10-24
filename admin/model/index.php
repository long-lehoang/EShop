<?php 
if(!defined('PATH_SYSTEM')) die('Bad Request');
//connect db
include_once PATH_SYSTEM.'/core/Model.php';
header("Content-Type:html/text; charset:UTF-8");

$page = $_POST['page'];
$limit = 5;
            
// Tìm Start
$start = ($page - 1) * $limit;

if(isset($_POST['action']))
{

    $query = "SELECT * FROM VIEW_PRODUCT WHERE 1 ";
    if(isset($_POST['category']))
    {

        $category = implode("','",$_POST['category']);
        $query .= "
        AND category IN('".$category."') 
        ";

    }
    //Tim So Luong San Pham
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $total_records = $stmt->rowCount();
    // tổng số trang
    $total_page = ceil($total_records / $limit);
    // Giới hạn current_page trong khoảng 1 đến total_page
    if ($page > $total_page){
        $page = $total_page;
    }
    else if ($page < 1){
        $page = 1;
    }

    $query .= " LIMIT $start,$limit";

    try{
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }

}
?>                    
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
							// PHẦN HIỂN THỊ PHÂN TRANG
							// BƯỚC 7: HIỂN THỊ PHÂN TRANG
							
							// nếu current_page > 1 và total_page > 1 mới hiển thị nút prev
							if ($page > 1 && $total_page > 1){
								echo '<input type="button" class="page_number" onclick="pagination()" value="Prev"> | ';
							}
							
							// Lặp khoảng giữa
							if ($total_page>1){
								for ($i = 1; $i <= $total_page; $i++){
									// Nếu là trang hiện tại thì hiển thị thẻ span
									// ngược lại hiển thị thẻ a
									if ($i == $page){
										echo '<span>'.$i.'</span> | ';
									}
									else{
										echo '<input type="button" class="page_number" onclick="pagination()" value="'.$i.'"> | ';
									}
								}
							}
							// nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
							if ($page < $total_page && $total_page > 1){
								echo '<input type="button" class="page_number" onclick="pagination()" value="Next">';
							}
							?>
                </div>