<?php
    if (!defined('PATH_SYSTEM')) die('Bad request');
    include_once PATH_SYSTEM.'/core/Model.php';
    header('Content-Type:text/html; charset=UTF-8');

?>
<div class="grid_10">
        <div class="box round first">
            <h2>
                Thêm Sản Phẩm
            </h2>
            <div class="block">
                <form method="post" action="?c=product&a=add" enctype = "multipart/form-data">
                    <table>
                        <tr>
                            <td>Tên</td>
                            <td><input type="text" name="name" id=""></td>
                        </tr>
                        <tr>
                            <td>Giá</td>
                            <td><input type="text" name="price" id=""></td>
                        </tr>
                        <tr>
                            <td>Số Lương</td>
                            <td><input type="text" name="quantity" id=""></td>
                        </tr>
                        <tr>
                            <td>Hình Ảnh</td>  
                            <td><input type="file" name="image[]" id="" multiple="multiple"></td>
                        </tr>
                        <tr>
                            <td>Danh Mục</td>
                            <td>
                                <select name="category" id="">
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
                                <select name="productor" id="">
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
                            <td>Mô Tả</td>
                            <td><textarea name="info" id="" cols="30" rows="10"></textarea>
                                <script>
                                    CKEDITOR.replace('info');
                                </script>
                            </td>
                        </tr>
                        <tr><td colspan="2" align="center"><input type="submit" value="Upload" name="upload"></td></tr>
                    </table>
                </form>
            </div>
        </div>
</div>    
<div class="grid_5">
</div>
