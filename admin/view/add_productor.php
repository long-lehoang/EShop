<div class="grid_10">
    <div class="box round first">
        <h2>Thêm Nhà Sản Xuất</h2>
        <div class="block">
            <form action="?c=productor&a=add" method="post" enctype = "multipart/form-data">
                <table>
                    <tr>
                        <td>Tên</td>
                        <td><input type="text" name="name" id=""></td>
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