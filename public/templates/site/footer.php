  
    <!-- <script src="public/js/jquery.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<!-- <script src="public/js/price-range.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
    <script src="public/js/jquery.scrollUp.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha256-CjSoeELFOcH0/uxWu6mC/Vlrc1AARqbm/jiiImDGV3s=" crossorigin="anonymous"></script>    <script src="public/js/jquery.prettyPhoto.js"></script>
    <script src="public/js/main.js"></script>
    <?php 
    if(($_GET['c']==''||$_GET['c']=='index')&&($_GET['a']=='index'||$_GET['a']==''))
    echo '<script src="public/js/filter-product.js"></script>';
    elseif (($_GET['c']==''||$_GET['c']=='index')&&($_GET['a']=='productdetail'))
    echo '<script src="public/js/review-product.js"></script>';
    elseif (($_GET['c']==''||$_GET['c']=='index')&&($_GET['a']=='checkout'))
    echo '<script src="public/js/checkout.js"></script>';
    elseif ($_GET['a']=='register')
    echo '<script src="public/js/register.js"></script>';
    ?>

</body>
</html>