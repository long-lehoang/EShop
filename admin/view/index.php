<?php
if (!defined('PATH_SYSTEM')) die ('Bad Request');
    
        include_once PATH_SYSTEM.'/core/Model.php';
        //Kiem tra su kien dang ky
        if (!isset($_SESSION['name']))
        die('Ban khong duoc phep thuc hien tac vu nay');
                
        //Khai bao utf-8 de hien thi duoc tieng viet
        header('Content-Type:text/html; charset=UTF-8');
?>
<div class="grid_10">
        <div class="box round first">
            <h2>
                Danh Sách Sản Phẩm:
                <?php 
					$stmt = $conn->prepare('SELECT * FROM CATEGORY');
					$stmt->execute();
					$category = $stmt->fetchAll(PDO::FETCH_ASSOC);
					foreach($category as $ctgr_value)
					    {
				?>
					<label><input type="checkbox" class="common_selector category" value="<?php echo $ctgr_value['name']; ?>">
					<?php
						echo $ctgr_value['name'];
					?>
					</label>
				<?php } ?>
            </h2>
            <div class="block filter_data">
                <!-- load data using ajax -->
            </div>
        </div>
</div>    
<div class="grid_5">
</div>
