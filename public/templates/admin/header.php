<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Admin EShop</title>
    <link rel="stylesheet" type="text/css" href="public/css/reset.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="public/css/text.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="public/css/grid.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="public/css/layout.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="public/css/nav.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/jquery.jqplot.min.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="public/js/highcharts.src.js"></script>
    <script src="//cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    
    <script type="text/javascript">

        $(document).ready(function () {
            setupDashboardChart('chart');
            setupLeftMenu();
			setSidebarHeight();
        });
        var options = {
            chart: {
                renderTo: 'category-chart',
                type: 'line',
                defaultSeriesType: 'column'
            },
            title: {
                text: 'Doanh Số Bán Hàng Theo Danh Mục',
            },
            xAxis: {
                categories: []
            },
            yAxis: {
                title: {
                    text: 'Số Lượng Sản Phẩm (n)'
                },
            },
            series: []
        };


        $.get('public/csv/data.csv',function(data){
            // Split the lines
            var lines = data.split('\n');

            $.each(lines, function(lineNo, line){
                var items = line.split(';');

                //header line contains categories
                if (lineNo == 0)
                {
                    $.each(items, function(itemNo, item){
                        if (itemNo > 0) options.xAxis.categories.push(item);
                    });
                }

                // the rest of the lines contain data with their name in the first
                //position
                else{
                    var series ={
                            data: []
                    };
                    $.each(items, function(itemNo, item ){
                        if (itemNo == 0){
                            series.name = item ;
                        }
                        else{
                            series.data.push(parseFloat(item));
                        }
                    });

                    options.series.push(series);
                }
            });
            var chart = new Highcharts.Chart(options);
        });

    </script>
    

</head>
<body>
    <div class="container_12">
        <div class="grid_12 header-repeat">
            <div id="branding">
                <div class="floatleft">
                    <font color="white" style="font-size: 24px">Admin EShop</font>
                </div>
                <div class="floatright">
                    <div class="floatleft">
                    </div>
                    <div class="floatleft marginleft10">
                        <ul class="inline-ul floatleft">
                            <li>
                            Xin Chào Admin:
                            <?php
                            //session_start();
                            echo $_SESSION['name']
                            ?>
                            </li>
                            <li><a href="?a=change_pass">Đổi Mật Khẩu</a></li>

                            <li><a href="?c=user&a=logout">Đăng Xuất</a></li>

                        </ul>
                        <br />
                        
                    </div>
                </div>
                <div class="clear">
                </div>
            </div>
        </div>
        <div class="clear">
        </div>
        <div class="grid_12">
            <ul class="nav main">
                <li class="ic-dashboard"><a href="?c=view&a=index"><span>Sản Phẩm</span></a> </li>
                <li class="ic-form-style"><a href="?c=view&a=category"><span>Danh Mục</span></a></li>
                <li class="ic-dashboard"><a href="?c=view&a=productor"><span>Nhà Sản Xuất</span></a> </li>
                <li class="ic-dashboard"><a href="?c=view&a=order"><span>Đơn Đặt Hàng</span></a> 
                    <ul>
                        <li><a href="?a=neworder"><span>Đơn Hàng Mới</span></a></li>
                        <li><a href="?a=oldorder"><span>Đơn Hàng Cũ</span></a></li>
                    </ul>
                </li>
                
                <li class="ic-dashboard"><a href=""><span>Thống Kê</span></a> 
                    <ul>
                        <li><a href="?c=statistic&a=category"><span>Danh Mục</span></a></li>
                        <li><a href="?c=statistic&a=hotsale"><span>Sản Phẩm Hot Nhất</span></a></li>
                    </ul>
                </li>
                
                <?php 
                if ($_SESSION['user']=='admin')
                {
                    echo '<li class="ic-dashboard"><a href="?a=list_user"><span>Danh Sách Tài Khoản</span></a> </li>';
                    echo '<li class="ic-dashboard"><a href="?a=register"><span>Tạo Tài Khoản</span></a> </li>';
                
                }
                ?>
            </ul>
        </div>