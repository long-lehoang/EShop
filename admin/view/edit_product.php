<?php
if (!defined('PATH_SYSTEM')) die ('Bad Request');
    

        include_once PATH_SYSTEM.'/core/Model.php';
        //Kiem tra su kien dang ky
        //Khai bao utf-8 de hien thi duoc tieng viet
        header('Content-Type:text/html; charset=UTF-8');
        if (!isset($_SESSION['name']))
        die('Ban khong duoc phep thuc hien tac vu nay');
                
       
        try
        {
            $id = $_GET['id'];
            $stmt = $conn->prepare('select * from VIEW_PRODUCT where id= :id');
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute([":id"=>$id]);
            $data = $stmt->fetch();
        }
        catch(PDOException $e)
        {
            die($e->getMessage);
        }
?>
<div class="grid_10">
        <div class="box round first">
            <h2>
                Chỉnh Sửa Sản Phẩm 
            </h2>
            <div class="block">
                <form method="post" action="?c=product&a=edit" enctype = "multipart/form-data">
                    <table>
                        <tr>
                            <td>ID</td>
                            <td><input type="text" name="id" id="" value=<?php echo $data['id'] ?>></td>
                        </tr>
                        <tr>
                            <td>Tên</td>
                            <td><input type="text" name="name" id="" value="<?php echo $data['name'] ?>"></td>
                        </tr>
                        <tr>
                            <td>Giá</td>
                            <td><input type="text" name="price" id="" value=<?php echo $data['price']?>></td>
                        </tr>
                        <tr>
                            <td>Số Lượng</td>
                            <td><input type="text" name="quantity" id="" value=<?php echo $data['quantity']?>></td>
                        </tr>
                        <tr>
                            <td>Hình Ảnh</td>
                            <td><input type="file" name="image[]" id="" multiple="multiple"></td>
                            <?php 
                            $stmt = $conn->prepare("SELECT * FROM IMAGE_PRODUCT WHERE id = :id");
                            $stmt->execute([":id"=>$data['id']]);
                            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach($row as $image)
                            {
                            ?>
                            <img src="<?php echo $image['image'];?>" alt="">
                            <?php
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>Danh Mục</td>
                            <td>
                                <select name="category" id="" value=<?php echo $data['category']?>>
                                <?php 
                                    $stmt = $conn->prepare('SELECT name FROM CATEGORY');
                                    $stmt->execute();
                                    $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
                                    
                                    foreach($data as $category)
                                    {
                                    ?>
                                    <option value="<?php echo $category['name']; ?>"><?php echo $category['name'];?></option>
                                <?php }?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Nhà Sản Xuất</td>
                            <td>
                                <select name="productor" id="" value=<?php echo $data['productor']?>>
                                <?php 
                                    $stmt = $conn->prepare('SELECT name FROM PRODUCTOR');
                                    $stmt->execute();
                                    $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($data as $productor)
                                    {
                                    ?>
                                    <option value="<?php echo $productor['name']; ?>"><?php echo $productor['name'];?></option>
                                <?php }?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Mô Tả </td>
                            <td><textarea name="info" id="" cols="30" value="<?php echo $data['info']; ?>" rows="10"></textarea>
                                <script>
                                    CKEDITOR.replace("info");
                                </script>
                            </td>
                        </tr>
                        <tr><td colspan="2" align="center"><input type="submit" value="Chỉnh Sửa" name="edit"></td></tr>
                    </table>
                </form>
            </div>
        </div>
</div>    
<div class="grid_5">
</div>
