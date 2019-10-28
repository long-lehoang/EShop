<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>EShop</title>
    <link href="public/css/bootstrap.min.css" rel="stylesheet">
    <link href="public/css/font-awesome.min.css" rel="stylesheet">
    <link href="public/css/prettyPhoto.css" rel="stylesheet">
    <!-- <link href="public/css/price-range.css" rel="stylesheet"> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" integrity="sha256-p6xU9YulB7E2Ic62/PX+h59ayb3PBJ0WFTEQxq0EjHw=" crossorigin="anonymous" />
    <link href="public/css/animate.css" rel="stylesheet">
	<link href="public/css/main1.css" rel="stylesheet">	
	<link href="public/css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="public/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="public/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="public/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="public/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="public/images/ico/apple-touch-icon-57-precomposed.png">
	
	<style>
		.slidecontainer {
		width: 60%;
		}
		#loading{
			text-align:center;
			background: url('public/images/ajax-loader.gif') no-repeat center;
			height:150px;
		}
		.slider {
		-webkit-appearance: none;
		width: 100%;
		height: 10px;
		background: #d3d3d3;
		outline: none;
		opacity: 0.7;
		-webkit-transition: .2s;
		transition: opacity .2s;
		}

		.slider:hover {
		opacity: 1;
		}

		.slider::-webkit-slider-thumb {
		-webkit-appearance: none;
		appearance: none;
		width: 15px;
		height: 15px;
		background: #4CAF50;
		cursor: pointer;
		}

		.slider::-moz-range-thumb {
		width: 20px;
		height: 10px;
		background: #4CAF50;
		cursor: pointer;
		}	
	</style>

</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6 ">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href=""><i class="fa fa-phone"></i> +84 938 186 100</a></li>
								<li><a href=""><i class="fa fa-envelope"></i> long.bk.khmt@gmail.com</a></li>
							</ul>
						</div>
					</div>

				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="index.php"><img src="public/images/home/logo.png" alt="" /></a>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
								<li><a href="?a=checkout"><i class="fa fa-crosshairs">Thanh Toán</i> </a></li>
								<li><a href="?a=cart"><i class="fa fa-shopping-cart">Giỏ Hàng</i> </a></li>
								<?php
								if (!isset($_SESSION['name']))
								echo '<li><a href="?a=login"><i>Đăng Nhập</i></a><a href="?a=register"><i>Đăng Kí</i></a></li>';
								else{
									echo '<li><a href="?a=olddeal"><i class="fa fa-crosshairs">Lịch Sử Đặt Hàng</i> </a></li>';
									echo '<li><a href="?c=index&a=change_pass"><i>Đổi mật khẩu</i></a></li>' ;
									echo '<li><i id="user_name">'.$_SESSION['name'].'</i> <a href="?c=user&a=logout"><i>Đăng Xuất</i></a></li>';
								}
								?>
								<!-- <li><a href="?c=login"><i class="fa fa-lock"></i> Login</a></li> -->
							</ul>
						</div>
					</div>
				</div>
			</div>
			
		</div><!--/header-middle-->
	</header>
	