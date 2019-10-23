<?php
if (!defined('PATH_SYSTEM')) die('Bad Request');

//connect 
include_once PATH_SYSTEM.'/core/Model.php';

header("Content-Type:text/html; charset:UTF-8");
?>
<section>
		<div class="container">
			<div class="row">
				
				<div class="col-sm-9 padding-right">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product">
                            <!-- image of product -->
                            <?php 
                                $stmt = $conn->prepare('SELECT image FROM IMAGE_PRODUCT WHERE id = :id');
                                $stmt->execute([":id"=>$_GET['id']]);
                                $image = $stmt->fetch(PDO::FETCH_ASSOC);
                            ?>
								<img src=<?php echo $image['image']; ?> alt="" />
							</div>
							<div id="similar-product" class="carousel slide" data-ride="carousel">
								
								  <!-- Wrapper for slides -->
								    <div class="carousel-inner">
                                        <?php
                                        $image = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($image as $i => $img)
                                        {
                                            if($i==0) echo '<div class="item active">
										    <a href=""><img width="180" height="360" src='.$img['image'].' alt=""></a></div>';
                                            else echo '<div class="item ">
										    <a href=""><img src='.$img['image'].' alt=""></a></div>';
                                        }
                                        ?>
									</div>

								  <!-- Controls -->
								  <a class="left item-control" href="#similar-product" data-slide="prev">
									<i class="fa fa-angle-left"></i>
								  </a>
								  <a class="right item-control" href="#similar-product" data-slide="next">
									<i class="fa fa-angle-right"></i>
								  </a>
							</div>

						</div>
						<div class="col-sm-7">
							<div class="product-information"><!--/product-information-->
                                <?php 
                                    $stmt = $conn->prepare('SELECT * FROM VIEW_PRODUCT WHERE id = :id');
                                    $stmt->execute([":id"=>$_GET['id']]);
                                    $product = $stmt->fetch(PDO::FETCH_ASSOC);
                                ?>
								<h2> <?php echo $product['name']; ?></h2>
								<span>
									<span><?php echo $product['price'].' VNĐ';?></span>
									<label>Quantity:</label>
									<form action="?c=cart&a=add&id=<?php echo $_GET['id'] ?>" method="post">
										<input type="text" value="1" name="quantity"/>
										<button type="submit" class="btn btn-fefault cart">
											<i class="fa fa-shopping-cart"></i>
											Thêm Vào Giỏ
										</button>
									</form>
								</span>
								<p><b>Nhà Sản Xuất:</b><?php echo $product['productor'] ?></p>
								<a href=""><img src="public/images/product-details/share.png" class="share img-responsive"  alt="" /></a>
							</div><!--/product-information-->
							<div class="product-infomation">
								<h4>Mô Tả Chi Tiết</h4>
								<p><?php echo $product['info']; ?></p>
							</div>
						</div>
					</div><!--/product-details-->
					<div class="category-tab shop-details-tab"><!--category-tab-->
							<div class="tab-pane fade active in" id="reviews" >
								
								<div class="col-sm-12">
									<h4>Đánh Giá Sản Phẩm</h4>
									<input id="product_id" style=" visibility: hidden;" value="<?php echo $_GET['id']; ?>">
									<div id="list-comment">
										<!-- <div class="col-sm-1"></div>
										<div class="col-sm-12" style="border-style: inset;">
											<p><b><i>Name</i></b></p>
											<p>Rating:
											<i class="fa fa-star fa-1x" style="color:yellow"></i>
											<i class="fa fa-star fa-1x" style="color:yellow"></i>
											<i class="fa fa-star fa-1x" style="color:yellow"></i>
											</p>
											<p>This is comment</p>
											<a href=""><i>Tra Loi</i></a>
										</div> -->
									</div>
									<div>
										<div id="review-star">
											<i class="fa fa-star-o fa-1x" data-index="0"></i>
											<i class="fa fa-star-o fa-1x" data-index="1"></i>
											<i class="fa fa-star-o fa-1x" data-index="2"></i>
											<i class="fa fa-star-o fa-1x" data-index="3"></i>
											<i class="fa fa-star-o fa-1x" data-index="4"></i>
										</div>
										<div id="comment-product">
											<input type="text" name="comment" id="comment">
											<button type="submit" id="submit">Gửi</button>
										</div>
									</div>
								</div>
							</div>
							
					</div><!--/category-tab-->
				</div>
			</div>
		</div>
	</section>
