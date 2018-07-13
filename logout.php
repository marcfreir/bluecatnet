<?php
include('./classes/DB.php');
include('./classes/Login.php');

if (!Login::isLoggedIn())
{
    echo '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>logout</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- This script calls the font awesome version 5.0.10 providing the icons for the form element in this page -->
        <!-- <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script> -->
        <!-- This link element calls the font awesome version 5.0.10 providing the icons for the form element in this page -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
        <link rel="stylesheet" type="text/css" media="screen" href="css/style_logout.css" />
        <!-- THIS is for the collapsing of the navbar -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="main.js"></script>
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
                        <li><a href="login.php">Sign In</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div id="home">
        <!-- <div class="landing-text"> -->
            <div class="landing-image">
                <!-- <h1>BLUECAT</h1> -->
                <img src="images/logged-out.png" class="img-responsive" id="landing-img">
                <!-- <h3>Not logged in.</h3> -->
                <img src="images/notlogedin.png" class="img-responsive" id="landing-img-notlogedin">
                <!-- <h3>[What about Create a New One? Eh!]</h3> -->
                <img src="images/whatabout-login.png" class="img-responsive" id="landing-img-whatabout-login">
                <div class="text-center">
                    <a href="login.php" class="btn btn-default btn-lg">Log In</a>
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
    </div>
    </footer>
    </html>';

    //die("Not logged in.");
    die;

}
if (isset($_POST['confirm']))
{
    if (isset($_POST['alldevices']))
    {
        DB::query('DELETE FROM tb_login_tokens WHERE logintoken_userid=:logintokenuserid', array(':logintokenuserid'=>Login::isLoggedIn()));
        
        //HTML code and images for this operation
        echo 'Logged out successfully!'.'<br />'.'This page will be redirected automatically in 5 seconds...';
        //redirect
        header("Refresh: 5; url=login.php");
    }
    else
    {
        if (isset($_COOKIE['BCNID'])){
            DB::query('DELETE FROM tb_login_tokens WHERE logintoken=:logintoken', array(':logintoken'=>sha1($_COOKIE['BCNID'])));
        }
        setcookie('BCNID', '1', time()-3600);
        setcookie('_BCNID', '1', time()-3600);
        
        echo 'Logged out successfully!'.'<br />'.'This page will be redirected automatically in 5 seconds...';
        //redirect
        header("Refresh: 5; url=login.php");

    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>logout</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- This script calls the font awesome version 5.0.10 providing the icons for the form element in this page -->
    <!-- <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script> -->
    <!-- This link element calls the font awesome version 5.0.10 providing the icons for the form element in this page -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" media="screen" href="css/style_logout.css" />
    <!-- THIS is for the collapsing of the navbar -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="main.js"></script>
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
                    <li><a href="login.php">Sign In</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="home">
        <div class="landing-text">
            <h1>Logout of your account</h1>
            <p>Are you shure you what to logout?</p>
            <form action="logout.php" method="post">
                <label for="chkbx" class="container">Logout of all devices?
                    <input type="checkbox" name="alldevices" value="alldevices" id="chkbx">
                    <span class="checkmark"></span>
                    <!-- <input type="submit" name="confirm" value="Confirm"> -->
                    <!-- <div class="text-center">
                        <a href="login.php" class="btn btn-default btn-lg" >Confirm</a>
                    </div> -->
                </label>
                <div class="text-center">
                    <input type="submit" name="confirm" value="Confirm" class="btn btn-default btn-lg">
                </div>
            </form>
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
    </div>
</footer>
</html>