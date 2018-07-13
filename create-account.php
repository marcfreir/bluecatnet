<?php
//$pdo = new PDO('mysql:host=127.0.0.1;dbname=db_bluecatnet;charset=utf8', 'root', '');
//$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

include('./classes/DB.php');

if (isset($_POST['createaccount']))
{
    $username = $_POST['username'];
    $userpassword = $_POST['userpassword'];
    $useremail = $_POST['useremail'];

    if (!DB::query('SELECT username FROM tb_users WHERE username=:username', array(':username'=>$username)))
    {
        if (strlen($username) >= 3 && strlen($username) <= 32)
        {
            if (preg_match('/[a-zA-Z0-9_]+/', $username))
            {
                if (strlen($userpassword) >= 6 && strlen($userpassword) <= 60)
                {
                    if (filter_var($useremail, FILTER_VALIDATE_EMAIL))
                    {
                        if (!DB::query('SELECT useremail FROM tb_users WHERE useremail=:useremail', array(':useremail'=>$useremail)))
                        {
                            DB::query('INSERT INTO tb_users VALUES (\'\', :username, :userpassword, :useremail, \'0\')', array(':username'=>$username, ':userpassword'=>password_hash($userpassword, PASSWORD_BCRYPT), ':useremail'=>$useremail));
                            echo "Success!";                                                        
                        }
                        else
                        {
                            echo 'Email already used!';
                        }

                    }
                    else
                    {
                        echo 'Invalid email!';
                    }
                }
                else
                {
                    echo 'Invalid password!';
                }
            
            }
            else
            {
                echo 'Invalid username!';
            }
           
        }
        else
        {
            echo 'Invalid username!';
        }

    }
    else
    {
        echo 'User already exists!';
    }

    
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>create-account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Calling JQuery from the file (without CDN)-->
    <script src="js/jquery-3.3.1.min.js"></script>

    <!-- Calling JQuery Mobile from the file (without CDN)-->
    <link rel="stylesheet" type="text/css" media="screen" href="jquery-mobile/jquery.mobile-1.4.5.css" />
    <script src="jquery-mobile/jquery.mobile-1.4.5.js"></script>

    <!-- Calling Bootstrap from the file (without CDN)-->
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.css" />
    <script src="js/bootstrap.js"></script>

    <!-- Calling Font Awesome from the file (without CDN)-->
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css" />

    <!-- Calling Font Ionicons from the file (without CDN)-->
    <link rel="stylesheet" href="assets/css/fonts/ionicons.min.css" />

    <!-- Calling Animate from the file (without CDN)-->
    <link rel="stylesheet" href="assets/css/animate.css" />

    <link rel="stylesheet" type="text/css" media="screen" href="css/style_create-account.css" />
    <!-- THIS is for the collapsing of the navbar -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

</head>
<body>
<!--
    <h1>Register</h1>
    <form action="create-account.php" method="post">
    <input type="text" name="username" value="" placeholder="Username..."><p />
    <input type="password" name="userpassword" value="" placeholder="Password..."><p />
    <input type="email" name="useremail" value="" placeholder="yourname@whateverthesite.anything"><p />
    <input type="submit" name="createaccount" value="Create Account">
    </form>
-->

<!-- Just a replacement for the code above -->

    <div>
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-main">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"><img src="images/bc-main-logo-white.png"></a>
                </div>
                <div class="collapse navbar-collapse" id="navbar-collapse-main">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a class="active" href="index.php">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#">See Cats</a></li>
                        <li><a href="#">Play a Game</a></li>
                        <li><a href="create-account.php">Create Account</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="login-clean">
        <form method="post">
            <h2 class="sr-only">Create Account</h2>
            <div class="illustration">
                <i class="logo">
                    <img src="images/logo-cats.png" alt="" id="cat">
                </i>
            </div>
            <div class="form-group">
                <input class="form-control" id="username" type="text" name="username" placeholder="Username">
            </div>
            <div class="form-group">
                <input class="form-control" id="useremail" type="email" name="email" placeholder="Email">
            </div>
            <div class="form-group">
                <input class="form-control" id="userpassword" type="password" name="password" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary btn-block" id="ca" data-bs-hover-animate="shake" value="Create Account">
                <!-- <button class="btn btn-primary btn-block" id="ca" type="button" data-bs-hover-animate="shake">Create Account</button> -->
            </div><a href="login.php" class="forgot">Already got an account? Click here!</a></form>
    </div>

    <!-- SCRIPT -->
    <script type="text/javascript">
        $('#ca').click(function()
        {

            $.ajax({

                type: "POST",
                url: "api/users",
                processData: false,
                contentType: "application/json",
                data: '{ "username": "'+ $("#username").val() +'", "useremail": "'+ $("#useremail").val() +'", "userpassword": "'+ $("#userpassword").val() +'" }',
                success: function(r)
                {
                    console.log(r)
                },
                error: function(r)
                {
                    setTimeout(function()
                    {
                        $('[data-bs-hover-animate]').removeClass('animated ' + $('[data-bs-hover-animate]').attr('data-bs-hover-animate'));
                    }, 2000)
                    $('[data-bs-hover-animate]').addClass('animated ' + $('[data-bs-hover-animate]').attr('data-bs-hover-animate'))
                    console.log(r)
                }

            });

        });
    </script>

</body>
<footer class="container-fluid text-center">
    <div class="row">
        <div class="col-sm-4">
            <h3>Contact Us</h3>
            <br>
            <h4>7 Bananas Way, Melon Bread Park, BC M30 W3H</h4>
        </div>
        <div class="col-sm-4">
            <h3>Connect</h3>
            <a href="#" class="fa fa-facebook"></a>
            <a href="#" class="fa fa-twitter"></a>
            <a href="#" class="fa fa-google"></a>
            <a href="#" class="fa fa-linkedin"></a>
            <a href="#" class="fa fa-youtube"></a>
        </div>
        <div class="col-sm-4">
            <img src="images/bc-gm.png" class="icon">
        </div>
        <!-- <h5>Developed and Designed by: Marc Freir (Fibily Wizy)</h5> -->
        <p id="ft">Developed and Designed by: Marc Freir (Fibily Wizy) <br>
            License: This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.</p>
    </div>
    
</footer>
</html>