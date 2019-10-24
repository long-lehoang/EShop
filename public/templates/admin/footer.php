<div class="clear">
        </div>
    </div>
    <div class="clear">
    </div>
    <div id="site_info">
        <p>
Admin EShop
        </p>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="public/js/highcharts.src.js"></script>
    <script src="//cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>    
    <?php
    if(($_GET['c']==''||$_GET['c']=='view')&&($_GET['a']==''||$_GET['a']=='index'))
    echo '<script src="public/js/filter-product-admin.js"></script>';
    ?>
    <?php
    if(($_GET['c']=='statistic')&&($_GET['a']=='category'))
    echo '<script src="public/js/chart.js"></script>';
    ?>
    
    </body>
</html>

