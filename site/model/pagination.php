<?php
	if (!defined('PATH_SYSTEM')) die ('Bad request');
	include_once PATH_SYSTEM . '/core/Model.php';
	header('Content-Type:text/html; charset=UTF-8');	

	$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;

	// Số record trên một trang
	$limit = 2;
	$limit_s = $limit+1;
	$start = ($limit * $page) - $limit;
	
	try{
		if(isset($_GET['category']))
		{
			$stmt = $conn->prepare("SELECT * FROM PRODUCT WHERE category_id =:category_id LIMIT $start,$limit_s ");
			$stmt->execute([":category_id"=>$_GET['category']]);
		}
		elseif(isset($_GET['search']))
		{
			$stmt = $conn->prepare("SELECT * FROM PRODUCT WHERE name LIKE :name LIMIT $start,$limit_s ");
			$stmt->execute([":name"=>'%'.$_GET['search'].'%']);
		}
		else
		{
			$stmt = $conn->prepare("SELECT * FROM PRODUCT LIMIT $start,$limit");
			$stmt->execute();
		}
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$list = $stmt->fetchAll();
		$total = count($list);
		die(var_dump($list));
		if ($total==0){
			echo '<script language="javascript">stopped = true; </script>';
		}
	}
	catch(PDOException $e)
	{
		echo "<script language=javascript>window.location='?a=error'</script>";
	}
	foreach($list as $data)
							{
						echo '
						<div class="col-sm-4">
							<div class="product-image-wrapper">
								<div class="single-products">
									<div class="productinfo text-center">';
										try{
											$stmt = $conn->prepare('SELECT image FROM IMAGE_PRODUCT WHERE id =:id');
											$stmt->execute([":id"=>$data['id']]);
											$image=$stmt->fetch(PDO::FETCH_ASSOC);
												
											}
											catch(PDOException $e){
												die("ERROR IMAGE");
											}
										echo'
										<a href="?c=index&a=productdetail&id='.$data['id'].'">
										<img src='.$image['image'].' alt=""  /> </a>
										<h2>'.$data['price'].' đ</h2>
										<p>'.$data['name'].'</p>
											<a href="?c=cart&a=add&id='.$data['id'].'"
											class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm Vào Giỏ</a>
									</div>
								</div>
							</div>
						</div>';
							}
							
?>
