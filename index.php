<?php
    include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <!-- <link rel="stylesheet" href="css/bootstrap.css"/> -->
        <link rel="shortcut icon" type="image/png" href="image/logo.ico">    
    </head>

    <body style="background-image: url(image/bg.jpg); background-repeat: no-repeat; background-size: 100% 100%;">
    <!-- <style type="text.css">
        body{
            background-image: url(../image/bg.jpg);
        background-repeat: no-repeat;
        background-size: 100% 100%;
        }
    </style> -->
        <!-- <img src="image/bg.jpg"> -->
        <!-- Jika login gagal -->
        <?php
            if(isset($_GET['pesan'])){
                if($_GET['pesan']=="gagal"){
                    echo "<div class='alert'>Username atau Password salah..!</div>";
                } else if($_GET['pesan'] == "logout"){
                    echo "<div class='alert'>Anda Sudah Logout..!</div>";
                } else if($_GET['pesan'] == "belum_login"){
                    echo "<div class='alert'>Anda Harus Login..!</div>";
                }
            }
        ?>
        
        <!-- <div class="content_index"></div>   -->
        <div class="div_login">
            <!-- <h3 class="label_login">SILAHKAN LOGIN</h3> -->
            <fieldset>
                <legend>Silahkan Login</legend>
                <form action="login_check.php"method="post">
                    <!-- Input username dan password -->
                    <label>Username</label> 
                    <input type="text" name="NIP" class="login_form" placeholder="Username .." require="required">
                    <label>Password</label>
                    <input type="password" name="Pass_Char" class="login_form" placeholder="Password .." require="required">
                    <!-- submit -->
                    <input type="submit" class="login_submit" value="LOGIN">
                </form>
            </fieldset>
        </div>
    </body>
</html>