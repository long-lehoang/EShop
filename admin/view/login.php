<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="public/css/style.css">
    <style>
        .success{border: solid 1px blue;}
        .error {border:solid 1px red;}
    </style>
    <!-- <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>   -->

  </head>

  <body>

    <div class="login">
        <div class="login-triangle"></div>
        
        <h2 class="login-header">Admin</h2>

        <form class="login-container" method="post" action="?c=user&a=login" >
          <p><input type="username" placeholder="Username" name="username" data-require></p>
          <p><input type="password" placeholder="Password" name="password" data-require></p>
          <p><input type="submit" value="Log in" name="login"></p>
        </form>
        
    </div>
  </body>
</html>
