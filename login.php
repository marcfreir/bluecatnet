<?php
include('classes/DB.php');

//test
$registered_or_not = "";
$page = "";
//test something
$usersession_userid = "";
$usersession_username = "";
$result = "";
//test

if (isset($_POST['login']))
{
    $username = $_POST[':username'];
    $userpassword = $_POST[':userpassword'];

    if (DB::query('SELECT username FROM tb_users WHERE username=:username', array(':username'=>$username)))
    {
        if (password_verify($userpassword, DB::query('SELECT userpassword FROM tb_users WHERE username=:username', array(':username'=>$username))[0]['userpassword']))
        {
            $page = "index.php";

            $registered_or_not = "Logged in Successfully!"."<br />"."You will be redirected automatically in 5 seconds...";
            //redirect
            header("Refresh: 5; url=index.php");
            //echo 'Logged in!';
            //test
            //$page = "index.php";

            //CARRYING THE USERNAME INTO THE SESSION - START
            $usersession_userid = DB::query('SELECT userid FROM tb_users WHERE username=:username', array(':username'=>$username))[0]['userid'];
            DB::query('INSERT INTO tb_usersession VALUES (\'\', :usernamesession, :userid)', array(':usernamesession'=>$username, ':userid'=>$usersession_userid));
            $usersession_username = DB::query('SELECT usernamesession FROM tb_usersession WHERE usernamesession=:username', array(':username'=>$username))[0]['usernamesession'];
            if ($usersession_username[0] === NULL)
            {
                DB::query('INSERT INTO tb_usersession VALUES (\'\', :usernamesession, :usersession_user_id)', array(':usernamesession'=>$username, ':usersession_user_id'=>$usersession_userid));
            }
            else
            {
                DB::query('UPDATE tb_usersession SET usernamesession=:usernamesession WHERE usersession_user_id=:usersession_user_id', array(':usernamesession'=>$username, ':usersession_user_id'=>$usersession_userid));
            }
            // - END
           

            $cstrong = True;
            $logintoken = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
            //echo $logintoken;
            $logintoken_userid = DB::query('SELECT userid FROM tb_users WHERE username=:username', array(':username'=>$username))[0]['userid'];
            DB::query('INSERT INTO tb_login_tokens VALUES (\'\', :logintoken, :logintoken_userid)', array(':logintoken'=>sha1($logintoken), ':logintoken_userid'=>$logintoken_userid));

            setcookie("BCNID", $logintoken, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
            setcookie("BCNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);

        }
        else
        {
            //test
            $registered_or_not = "Incorrect Password!";
            //echo 'Incorrect Password!';
        }

    }
    else
    {
        //test
        $page = "login.php";
        $registered_or_not = "User not registered!";
        //echo 'User not registered!';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <!-- This script calls the font awesome version 5.0.10 providing the icons for the form element in this page -->
    <!-- <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script> -->
    <!-- This link element calls the font awesome version 5.0.10 providing the icons for the form element in this page -->
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    
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

    <link rel="stylesheet" type="text/css" media="screen" href="css/style_login.css" />
    <!-- THIS is for the collapsing of the navbar -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
    
    
</head>
<body>
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

    <div id="home">
        <div class="item" id="align-item">
            <h1>Login to you account</h1>
            <h1><?php echo "<h2 id='logged'>".$registered_or_not."</h2>" ?></h1>
            <!-- <h1></*?php echo "<h2>".$usersession_username."</h2>" ?*/></h1> -->
            <div class="content">
            <form action="<?php echo $page?>" class="form-horizontal" method="post">
            <!-- <form action="login.php" class="form-horizontal" method="post"> -->
                <div class="input-group lg">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" name=":username" class="form-control" value="" id="username" placeholder="Username..."><p />
                </div>
                <div class="input-group lg">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" name=":userpassword" class="form-control" value="" id="userpassword" placeholder="Password..."><p />
                </div>
                <div class="form-group in">
                    <input type="submit" class="btn btn-default btn-block" id="login" data-bs-hover-animate="shake" name="login" value="Login">
                    <!-- <button class="btn btn-default btn-block" id="login" type="button" data-bs-hover-animate="shake">Log In</button> -->
                </div>
                <a href="forgot-password.php" class="forgot">Forgot your email or password?</a>
            </form>
            </div>
            <!-- <div class="footer">
                <h5>Developed and Designed by: Marc Freir (Fibily Wizy)</h5>
                <h5>License: This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.</h5>
            </div> -->
        </div>
    </div>

    <!-- SCRIPT -->
    
    <script type="text/javascript">
        $('#login').click(function()
        {
            $.ajax({

                type: "POST",
                url: "api/auth",
                processData: false,
                contentType: "application/json",
                data: '{ "username": "'+ $("#username").val() +'", "userpassword": "'+ $("#userpassword").val() +'" }',
                success: function(r) //this is the original
                {
                    console.log(r)
                },
                /* //adaptation start here
                success: function(data)
                {
                    $('#login').val("Login");
                    if (data == "1")
                    {
                        $(location).attr('href', 'index.php');
                    }
                },
                */ //adaptation finish here
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

    <div id="about" class="padding">
        <div class="container">
            <div class="row" id="gap">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <h4>About Blue Cat</h4>
                    <p>Blue Cat is a colaborative cross-platform network that helps people connect to each other
                    respecting the privacy of all people. Also, Blue Cat is designed to help users connect with
                    colleagues and peers, search for professional oportunities, and share relevant data.
                    </p>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <img src="images/bc.png" class="img-responsive">
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <h4>And Jimmy</h4>
                    <p>Jimmy, sometimes called Timmy, is the creator of the Blue Cat. He likes cats so much,
                    and he would like to have a blue cat one day. ;D
                    </p>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <img src="images/jimmy-timmy.png" class="img-responsive" id="timmy">
                </div>
            </div>
        </div>
    </div>
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