<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Document</title>
    <link rel="stylesheet" href="main.css">
</head>
<style>

</style>
<body>
<?php

if(isset($_SESSION['type'])): ?>


<div class="status
    <?php 
    
    if($_SESSION['type'] == "success"):
        echo "success";
 
    elseif($_SESSION['type'] == "fail"):
        echo "fail";
    endif;

    

    ?>
">
       <?php
       if(isset($_SESSION["Register"])): ?>
           <span>Qeydiyyat uğurla başa çatdı.</span>
          <?php unset($_SESSION["Register"]);
       endif;
       if(isset($_SESSION["User_exist"])): ?>
            <span>Bu email ilə istifadəçi artıq mövcuddur.</span>
           <?php unset($_SESSION["User_exist"]);
       endif;
       if(isset($_SESSION["User_exist_false"])): ?>
           <span>Belə istifadəçi mövcud deyil.</span>
           <?php unset($_SESSION["User_exist_false"]);
       endif;
       if(isset($_SESSION["Wrong_password"])): ?>
           <span>Şifrə yalnışdır.</span>
           <?php unset($_SESSION["Wrong_password"]);
       endif;
       if(isset($_SESSION["Logged"])): ?>
           <span>Daxil oldu.</span>
           <?php unset($_SESSION["Logged"]);
       endif;
       ?>
   </div>

<?php 
unset($_SESSION['type']);
endif

?>
   <div class="wrap">
    
    <div>
        <label for="">Login</label>
        <form action="auth.php?type=login" method="post">
            <input type="text" value="" name="email" placeholder="Email"> <br>

                <input type="password" value="" name="pass" placeholder="Şifrə"> <br>
            <input type="submit" value="Login">
        </form>
   
    </div>
    <div>
        <label for="">Qeydiyyat</label>
        <form action="auth.php?type=register" method="post">
            <input type="text" name="name" placeholder="Ad"> <br>
            <input type="email" name="email" placeholder="E-mail"> <br>
            <input type="password" name="pass" placeholder="Şifrə"> <br>
            <input type="submit" value="Qeydiyyat">
        </form>
    </div>

   </div>
   
</body>
</html>