<?php 
//connect db
	if (!defined('PATH_SYSTEM')) die ('Bad request');
	include PATH_SYSTEM . '/core/Model.php';
	header('Content-Type:text/html; charset=UTF-8');	

	//if don't have cart_id, create cart
	if(!isset($_SESSION['cart']))
	{
		try
		{
			//$price = 0;
			$stmt = $conn->prepare('INSERT INTO CART(price) VALUES(0)');
			$stmt->execute();
			$stmt = $conn->prepare('SELECT MAX(id) as id FROM CART');
			$stmt->execute();
			$cart = $stmt->fetch(PDO::FETCH_ASSOC);

			$_SESSION['cart']=$cart['id'];
		}
		catch(PDOException $e)
		{
			echo "ERROR";
		}
	}

?>
	<section id="cart_items">
		<div class="container">

			<form action="?c=cart&a=edit" method="post">
			<div class="table-responsive cart_info">
			
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="description">Sản Phẩm</td>
							<td class="price">Giá</td>
							<td class="quantity">Số Lượng</td>
							<td class="total">Tổng Tiền</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					<?php 
						try{
							//prepare query statement
							$stmt = $conn->prepare('SELECT * FROM CART_PRODUCT WHERE cart_id =:cart_id');
							$stmt->execute([":cart_id"=>$_SESSION['cart']]);
							$stmt->setFetchMode(PDO::FETCH_ASSOC);
							$cart = $stmt->fetchAll();
							$totalprice = 0;
							
						}
						catch(PDOException $e)
						{
							echo "Không có sản phẩm trong giỏ hàng.";
							//echo "<script language=javascipt> window.location='?a=error'</script>";
						}
						
						//cal totalprice
						
						foreach($cart as $product)
						{
							//get product
							$stmt = $conn->prepare('SELECT * FROM VIEW_PRODUCT WHERE id = :id');
							$stmt->execute([":id"=>$product['product_id']]);
							$item = $stmt->fetch(PDO::FETCH_ASSOC);

							$subtotal=$item['price']*$product['quantity']; 
                        	$totalprice+=$subtotal; 
					?>
						<tr>
							<td class="cart_description">
								<h4><a href="?a=productdetail&id=<?php echo $item['id']; ?>"><?php echo $item['name'];?></a></h4>
							</td>
							<td class="cart_price">
								<p><?php echo $item['price']." VNĐ";?></p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<input class="cart_quantity_input" type="text" min="1" max="10" value="<?php echo $product['quantity'];?>" 
									autocomplete="off" size="2" name="quantity[<?php echo $item['id']; ?>]">
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price"><?php echo $subtotal." VNĐ";?></p>
							</td>
								
							<td >
								<a  href="?c=cart&a=delete&id=<?php echo $item['id']?>">
								<i><?php if($_GET['a']!='checkout') echo "Xóa"?></i></a>
							</td>
								
						</tr>

						<?php } ?>
						<tr>
							<td colspan="4">&nbsp;</td>
							<td colspan="2">
								<table class="table table-condensed total-result">

									<tr class="shipping-cost">
										<td>Chi Phí Vận Chuyển</td>
										<td>Miễn Phí</td>										
									</tr>
									<tr>
										<td>Tổng Tiền</td>
										<td><span>
										<?php 
										try
										{$stmt = $conn->prepare('UPDATE CART
																SET price = :price
																WHERE id = :cart_id');
										$stmt->execute([":price"=>$totalprice,":cart_id"=>$_SESSION['cart']]);
										}
										catch(PDOException $e)
										{
											echo "Error";
										}
										echo ($totalprice)." VNĐ";
										?>
										</span></td>
									</tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
				
				
			</div>
			<?php
			if($_GET['a']!='checkout')
			echo ' 
			<br /> 
    			<div align="right">
					<button class="btn btn-default update" type="submit" name="submit" value="submit">Cập Nhật Giỏ Hàng</button>
					<a class="btn btn-default check_out" href="?a=checkout">Thanh Toán</a>
				</div>
			'
			?>
			</form>
		</div>
	</section> <!--/#cart_items-->

	

	