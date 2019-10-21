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
            $stmt = $conn->prepare('SELECT * FROM PRODUCTOR WHERE id = :id');
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
        <h2>Chỉnh Sửa Nhà Sản Xuất</h2>
        <div class="block">
            <form action="?c=productor&a=edit" method="post" enctype = "multipart/form-data">
                <table>
                    <tr>
                        <td>ID</td>
                        <td><input type="text" name="id" value=<?php echo $data['id'] ?> ></td>
                    </tr>
                    <tr>
                        <td>Tên</td>
                        <td><input type="text" name="name" id="" value=<?php echo $data['name'] ?>></td>
                    </tr>
                    <br>
                    <tr>
                        <td>Mô Tả</td>
                        <td><textarea name="info" id="" cols="30" rows="10" value=<?php echo $data['info'] ?>></textarea>
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