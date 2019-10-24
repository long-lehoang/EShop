<?php 
if(!defined('PATH_SYSTEM')) die('Bad Request');
//connect db
include_once PATH_SYSTEM.'/core/Model.php';
header("Content-Type:html/text; charset:UTF-8");

$page = $_POST['page'];
//item of page
$no_of_records_per_page = 6;
$offset = $page * $no_of_records_per_page;

if(isset($_POST['action']))
{
    //initial query
    $query = "SELECT * FROM PRODUCT WHERE quantity > 0";
    //if has price condition
    if(isset($_POST['minimum_price'],$_POST['maximum_price'])&& !empty($_POST['minimum_price'])
    && !empty($_POST['maximum_price']))
    {
        $query .= "
        AND price BETWEEN '".$_POST['minimum_price']."' AND '".$_POST['maximum_price'].
        "'";
    }
    //if has category condition
    if(isset($_POST['category']))
    {
        $category = implode("','",$_POST['category']);
        $query .= "
        AND category_id IN('".$category."') 
        ";
    }
    //if has productor condition
    if(isset($_POST['productor']))
    {
        $productor = implode("','",$_POST['productor']);
        $query .= "
        AND productor_id IN('".$productor."') 
        ";
    }
    //if has search_value
    if(isset($_POST['search']))
    {
        $query .="
        AND name LIKE '%".$_POST['search']."%'
        ";
    }
    //limit page
    $query .="LIMIT $offset,$no_of_records_per_page";

    try{
        $stmt = $conn->prepare($query);
        $stmt->execute();
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $total_row = $stmt->rowCount();

    //check last page data
    if($total_row<$no_of_records_per_page)
    {
        echo '<script language="javascript"> stopped=true; </script>';
    }
    $output = '';
    if($total_row > 0)
    {
        foreach($result as $data)
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
			<?php
        }
    }
}
?>