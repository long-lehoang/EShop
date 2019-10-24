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

