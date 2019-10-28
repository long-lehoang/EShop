<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <title>Register</title>

    <!-- Icons font CSS-->
    <link href="public/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="public/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="public/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="public/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="public/css/main.css" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper bg-blue p-t-100 p-b-100 font-robo">
        <div class="wrapper wrapper--w680">
            <div class="card card-1">
                <div class="card-heading"></div>
                <div class="card-body">
                    <h2 class="title">Registration</h2>
                    <form method="POST" action="?c=user&a=register">
                        <div class="input-group">
                            <input class="input--style-1" type="text" placeholder="NAME" name="fullname" id="fullname">
                        </div>
                        <div class="input-group">
                            <input class="input--style-1" type="text" placeholder="USERNAME" name="username" id="username">
                        </div>

                        <div class="row row-space">
                            <div class="input-group">
                                <input class="input--style-1" type="password" placeholder="PASSWORD" name="password" id="password">
                            </div>
                            <div class="input-group">
                                <input class="input--style-1" type="password" placeholder="CONFIRM PASSWORD" name="c_password" id="c_password">
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="input-group">    
                                <input class="input--style-1" type="email" placeholder="EMAIL" name="email" id="email">
                            </div>
                            <div class="input-group">
                                <input class="input--style-1" type="text" placeholder="PHONE" name="phone" id="phone">
                            </div>
                        </div>
                        <div class="row row-space">
                            <div >
                                <div class="input-group">
                                    <input class="input--style-1 js-datepicker" type="text" placeholder="BIRTHDATE" name="birthday" id="birthday">
                                    <i class="zmdi zmdi-calendar-note input-icon js-btn-calendar"></i>
                                </div>
                            </div>
                            <div >
                                
                                    <div class="rs-select2 js-select-simple select--no-search">
                                        <select name="gender" id="gender">
                                            <option disabled="disabled" selected="selected" value="n">Giới tính</option>
                                            <option value="Nam">Nam</option>
                                            <option value="Nữ">Nữ</option>
                                        </select>
                                        <div class="select-dropdown"></div>
                                    </div>
                                
                            </div>
                        </div>
                        <div class="input-group">
                            <input class="input--style-1" type="text" placeholder="ADDRESS" name="address" id="address">
                        </div>
                        <div class="p-t-20">
                            <button class="btn btn--radius btn--green" type="submit" id="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="public/vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="public/vendor/select2/select2.min.js"></script>
    <script src="public/vendor/datepicker/moment.min.js"></script>
    <script src="public/vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="public/js/global.js"></script>
</body>
</html>
