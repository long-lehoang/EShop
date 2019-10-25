<?php 
//connect db
	if (!defined('PATH_SYSTEM')) die ('Bad request');
	include_once PATH_SYSTEM . '/core/Model.php';
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

	//check voucher
	if(isset($_POST['check'])&&isset($_POST['voucher']))
	{
		//check code
		$stmt = $conn->prepare('SELECT * FROM VOUCHER WHERE id = :id');
		$stmt->execute([":id"=>$_POST['voucher']]);
		$voucher = $stmt->fetch(PDO::FETCH_ASSOC);
		if(!$voucher)
			$message_voucher = 'Mã giảm giá không hợp lệ';
		else
		{
			//check availabale
			$stmt = $conn->prepare('SELECT * FROM PAYMENT WHERE voucher_id = :voucher_id');
			$stmt->execute([":voucher_id"=>$voucher['id']]);

			if(empty($stmt->fetch(PDO::FETCH_ASSOC)))
			{
				$_SESSION['voucher'] = $voucher['id'];
				$message_voucher = 'Khuyến Mãi: '.$voucher['discount'].'%';
			}
			else {
				$message_voucher = 'Mã giảm giá đã được sử dụng';
			}
		} 
	}
?> 
<section id="cart_items">
		<div class="container">
			<div class="shopper-informations">
				<div class="row">
					<div >
						<div class="col-sm-8 clearfix">
							<div class="bill-to">
								<p>Thông Tin Đặt Hàng</p>
								<div class="form-one">
									<form method="post" action="?c=cart&a=checkout">
										<?php 
										try{	
											$stmt = $conn->prepare('SELECT fullname,phone,address,email FROM USER WHERE id = :id');
											$stmt->execute([":id"=>$_SESSION['user_id']]);
											$user=$stmt->fetch(PDO::FETCH_ASSOC);
										}
										catch(PDOException $e)
										{
											echo "Có Lỗi Xảy Ra";
										}
										?>
										<input id ="name" type="text" value="<?php echo $user['fullname'];?>" name="name">
										<input id ="phone" type="text" value="<?php echo $user['phone'];?>" name="phone">
										<input id ="address" type="text" value="<?php echo $user['address'];?>" name="address">
										<input id ="email" type="email" value="<?php echo $user['email'];?>" name="email">

										<br>
										<br>
										<div align="center">
											<button id="checkout" type="submit" class="btn btn-default check_out"><i class="">Đặt Hàng</i></button>
										</div>

									</form>

									<h4>Mã giảm giá/Quà Tặng</h4>
									<form action="" method="post">
										<input type="text" placeholder="Nhập ở đây..." name="voucher" autocomplete="off" size="2">
										<div align="center">
											<button type="submit" name="check" value="check" class="btn btn-default check_out"><i class="">Kiểm Tra</i></button>
										</div>
										<?php if(isset($message_voucher)) echo $message_voucher; ?>
									</form>
								</div>

							</div>
						</div>
						<div class="col-sm-4">
							<div class="order-message">
								<p>Vận Chuyển Đơn Hàng</p>
								<textarea name="message"  placeholder="Thêm ghi chú, lưu ý khi vận chuyển cho đơn hàng của bạn" rows="16"></textarea>
							</div>	
						</div>					
					</div>				
				</div>
			</div>
			<?php 
				if (isset($_SESSION['error']))
				echo $_SESSION['error'];
			?>
			<div class="review-payment">
				<h2>Xem lại đơn hàng đã đặt</h2>
			</div>
		</div>
	</section> <!--/#cart_items-->