<?php 
	if (!defined('PATH_SYSTEM')) die ('Bad request');
	include_once PATH_SYSTEM . '/core/Model.php';
	header('Content-Type:text/html; charset=UTF-8');	

	//TÌM LIMIT VÀ CURRENT_PAGE
	$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
	$limit = 3;
		
	// Tìm Start
	$start = ($current_page - 1) * $limit;

	//bo loc
	if(isset($_POST['price'])||isset($_POST['productor']))
	{
		$price = $_POST['price'];
		$productor = $_POST['productor'];
		$sql .= "price < ".$price;
		if(isset($_POST['productor']))
		{
			$sql .=" AND "."productor_id IN(";
			foreach($productor as $val)
			{
				$sql .= $val.",";
			}
			$sql = substr($sql, 0, -1);
			$sql .=")";
		}
		
		$_SESSION['filter']=$sql;
	}
	if(isset($_POST['cancel']))
	unset($_SESSION['filter']);
	$sql = $_SESSION['filter'];

	$str='';
	if (isset($_GET['category']))
	$str .= 'category='.$_GET['category'];
	if (isset($_GET['search']))
	$str .= '&'.'search='.$_GET['search'].'&'; 
?>
	<div class="row">
		<div class="col-sm-8"></div>
		<div class="col-sm-3">
			<div class="search_box pull-right">
				<form action="" method="get">
					<input type="text" name="search" placeholder="Tìm Kiếm"/>
				</form>
			</div>
		</div>
	</div>
	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Danh Mục Sản Phẩm</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->
							<?php 
								$stmt = $conn->prepare('SELECT * FROM CATEGORY');
								$stmt->execute();
								$category = $stmt->fetchAll(PDO::FETCH_ASSOC);
								foreach($category as $ctgr_value)
								{
							?>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="?category=<?php echo $ctgr_value['id']; ?>"><?php echo $ctgr_value['name']; ?></a></h4>
								</div>
							</div>
							<?php } ?>
							
							<!--/category-productsr-->
						</div>
						<div >
							<h2>Lọc Sản Phẩm</h2>
							<form action="?<?php echo $str; ?>" method="post">
							<div class="panel-group category-products">
								<h5>Giá Sản Phẩm</h5>
								<div class="slidecontainer">
									<input type="range" min="0" max="50000000" value="25000000" name="price" class="slider" id="myRange">
									<p>Value: <span id="value"></span></p>	
								</div>
								<script>
									var slider = document.getElementById("myRange");
									var output = document.getElementById("value");
									output.innerHTML = slider.value;

									slider.oninput = function() {
									output.innerHTML = this.value + " VNĐ";
									}
								</script>
							</div>
							<?php 
								$stmt = $conn->prepare("SELECT * FROM PRODUCTOR");
								$stmt->execute();
								$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
							?>
							<div class="panel-group category-products">
								<h5>Xuất xứ</h5>
								<?php 
									foreach($row as $productor)
									{
								?>
								<input type="checkbox" name="productor[]" value="<?php echo $productor['id'] ?>" id=""> <?php echo $productor['name']; ?> <br>
								<?php
								  	}
								?>
							</div>
							<div>
								<center>
									<button type="submit" name="filter">Lọc</button>
									<button type="submit" name="cancel">Hủy</button>
								</center>
							</div>
							</form>
						</div>
					</div>
				</div>
				
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Danh Sách Sản Phẩm</h2>
						<div id="content">
						<?php 
							try{
								if(isset($_GET['category']))
								{
									if($sql!="")
									{
										$stmt = $conn->prepare("SELECT * FROM PRODUCT WHERE $sql AND category_id =:category_id LIMIT $start,$limit");
										$stmt1 = $conn->prepare("SELECT count(id) as total FROM PRODUCT WHERE $sql AND category_id =:category_id ");
									
									}
									else {
										$stmt = $conn->prepare("SELECT * FROM PRODUCT WHERE category_id =:category_id LIMIT $start,$limit");
										$stmt1 = $conn->prepare("SELECT count(id) as total FROM PRODUCT WHERE category_id =:category_id ");
									
									}
									$stmt->execute([":category_id"=>$_GET['category']]);

									$stmt1->execute([":category_id"=>$_GET['category']]);
								}
								elseif(isset($_GET['search']))
								{
									if($sql!="")
									{
										$stmt = $conn->prepare("SELECT * FROM PRODUCT WHERE $sql AND name LIKE :name LIMIT $start,$limit ");
										$stmt1 = $conn->prepare("SELECT count(id) as total FROM PRODUCT WHERE $sql AND name LIKE :name ");
									}
									else{
										$stmt = $conn->prepare("SELECT * FROM PRODUCT WHERE name LIKE :name LIMIT $start,$limit ");
										$stmt1 = $conn->prepare("SELECT count(id) as total FROM PRODUCT WHERE name LIKE :name ");
										
									}
									//die(var_dump($stmt));
									$stmt->execute([":name"=>'%'.$_GET['search'].'%']);

									$stmt1->execute([":name"=>'%'.$_GET['search'].'%']);
								}
								else
								{
									if ($sql!="")
									{
										
										$stmt = $conn->prepare("SELECT * FROM PRODUCT WHERE $sql LIMIT $start,$limit");
										$stmt1 = $conn->prepare("SELECT count(id) as total FROM PRODUCT WHERE $sql ");
									}
									else {
										$stmt = $conn->prepare("SELECT * FROM PRODUCT LIMIT $start,$limit");
										$stmt1 = $conn->prepare("SELECT count(id) as total FROM PRODUCT ");
									}
									$stmt->execute();

									
									$stmt1->execute();
								}
								
								$stmt->setFetchMode(PDO::FETCH_ASSOC);
								$list = $stmt->fetchAll();
								//Tim So Luong San Pham
								
								$total = $stmt1->fetch(PDO::FETCH_ASSOC);
								
								$total_records = (int)$total['total'];
								// tổng số trang
								$total_page = ceil($total_records / $limit);
								// Giới hạn current_page trong khoảng 1 đến total_page
								if ($current_page > $total_page){
									$current_page = $total_page;
								}
								else if ($current_page < 1){
									$current_page = 1;
								}
							}
							catch(PDOException $e)
							{
								//echo $e->getMessage();
								echo "<script language=javascript>window.location='?a=error'</script>";
							}
							
							foreach($list as $data)
							{

						?>
						<div class="col-sm-4">
							<div class="product-image-wrapper">
								<div class="single-products">
									<div class="productinfo text-center">
										<?php try{
											$stmt = $conn->prepare('SELECT image FROM IMAGE_PRODUCT WHERE id =:id');
											$stmt->execute([":id"=>$data['id']]);
											$image=$stmt->fetch(PDO::FETCH_ASSOC);
												
											}
											catch(PDOException $e){
												die("ERROR IMAGE");
											}
										?>
										<a href="?c=index&a=productdetail&id=<?php echo $data['id'] ?>">
										<img src= <?php echo $image['image']; ?> alt=""  /> </a>
										<h2> <?php echo $data['price']." đ"; ?></h2>
										<p><?php echo $data['name']; ?></p>
											<a href="?c=cart&a=add&id=<?php echo $data['id']; ?>"
											class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm Vào Giỏ</a>
									</div>
								</div>
							</div>
						</div>
							<?php }?>
						</div>

					</div>	<!--features_items-->
					<div class="pagination">
							<?php
							
							// PHẦN HIỂN THỊ PHÂN TRANG
							// BƯỚC 7: HIỂN THỊ PHÂN TRANG
							
							// nếu current_page > 1 và total_page > 1 mới hiển thị nút prev
							if ($current_page > 1 && $total_page > 1){
								echo '<a href="index.php?'.$str.'&page='.($current_page-1).'">Prev</a> | ';
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
										echo '<a href="index.php?'.$str.'&page='.$i.'">'.$i.'</a> | ';
									}
								}
							}
							
							// nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
							if ($current_page < $total_page && $total_page > 1){
								echo '<a href="index.php?'.$str.'&page='.($current_page+1).'">Next</a>';
							}
							?>
						</div>						
				</div>
			</div>
		</div>
	</section>


