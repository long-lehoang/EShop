<?php 
if (!defined('PATH_SYSTEM')) die('Bad Request');
//connect db
include_once PATH_SYSTEM.'/core/Model.php';
//display vietnamese language
header("Content-Type:text/html; charset:UTF-8");

$product_id = (int)$_POST['product_id'];
try{
    $stmt = $conn->prepare("SELECT * FROM COMMENT WHERE parent=0 AND product_id=$product_id ORDER BY time");
    $stmt1 = $conn->prepare("SELECT * FROM COMMENT WHERE parent!=0 AND product_id=$product_id ORDER BY time");

    $stmt->execute();
    $stmt1->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data1= $stmt1->fetchAll(PDO::FETCH_ASSOC);

    if(empty($data)){
        echo "Không có nhận xét cho sản phẩm này";
    }
    else
    foreach($data as $comment)
    {
        $parent = $comment['id'];
?>
    <div class="col-sm-12" style="border-width:1px;  border-style:dotted;">
        <div class="col-sm-1"></div>
        <div class="col-sm-11" >
        <p><b><i><?php echo $comment['name']; ?>
        </i></b><?php echo $comment['time'];?></p>
		<p>Rating:
        <?php 
        for ($i = 0 ;$i<$comment['star'];$i++)
        {
        ?>
		<i class="fa fa-star fa-1x" style="color:yellow"></i>
        <?php 
        }
        ?>
		</p>
		<p>
            <?php echo $comment['comment']; ?>
        </p>
	    </div>
    </div>
    <br><br>
<?php
        foreach($data1 as $child_cmt)
        {
            if($child_cmt['parent']==$parent)
            {
                ?>
                <div class="col-sm-1"></div>
                <div class="col-sm-11" style="border-style: inset;">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-11" style="border-style: inset;">
                    <p><b><i><?php echo $comment['name']; ?>
                    </i></b></p>
                    </p>
                    <p>
                        <?php echo $comment['comment']; ?>
                    </p>
                </div>
            <?php
            }
        }
    }
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
?>