<?php 
	if (!defined('PATH_SYSTEM')) die ('Bad request');
	include_once PATH_SYSTEM . '/core/Model.php';
	header('Content-Type:text/html; charset=UTF-8');	

?>
	<div class="row">
		<div class="col-sm-8"></div>
		<div class="col-sm-3">
			<div class="search_box pull-right">
				<input type="text" id="search" placeholder="Tìm Kiếm"/>
			</div>
		</div>
	</div>
	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Danh Mục Sản Phẩm</h2>
						<div class="list-group"><!--category-productsr-->
							<?php 
								$stmt = $conn->prepare('SELECT * FROM CATEGORY');
								$stmt->execute();
								$category = $stmt->fetchAll(PDO::FETCH_ASSOC);
								foreach($category as $ctgr_value)
								{
							?>
							<div class="list-group-item checkbox">
								<label><input type="checkbox" class="common_selector category" value="<?php echo $ctgr_value['id']; ?>">
								<?php
									echo $ctgr_value['name'];
								?>
								</label>
							</div>
							<?php } ?>
							
							<!--/category-productsr-->
						</div>
						<h2>Giá Sản Phẩm</h2>
						<div class="list-group">
							<input type="hidden" id="hidden_minimum_price" value="10000">
							<input type="hidden" id="hidden_maximum_price" value="50000000">
							<p id="price_show">10000 VND - 50000000 VND</p>
							<div id="price_range"></div>
						</div>
						<h2>Nhà Sản Xuất</h2>
						<div class="list-group">
							<?php 
								$stmt = $conn->prepare('SELECT * FROM PRODUCTOR');
								$stmt->execute();
								$productor = $stmt->fetchAll(PDO::FETCH_ASSOC);
								foreach($productor as $prdt_value)
								{
							?>
							<div class="list-group-item checkbox">
								<label><input type="checkbox" class="common_selector productor" value="<?php echo $prdt_value['id']; ?>">
								<?php
									echo $prdt_value['name'];
								?>
								</label>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
				
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Danh Sách Sản Phẩm</h2>
						<div id="content" class="row filter_data">
						<!-- ajax load data -->
						</div>
					</div>	<!--features_items-->
											
				</div>
			</div>
		</div>
	</section>

