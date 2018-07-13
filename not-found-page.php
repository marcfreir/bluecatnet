<?php
include('./classes/Error.php');
//$error = "Erro 404 - page jsdkajhkajshdka";
//echo "<h1 class='er'>$error</h1>";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Error 404 - Page not found</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- This script calls the font awesome version 5.0.10 providing the icons for the form element in this page -->
    <!-- <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script> -->
    <!-- This link element calls the font awesome version 5.0.10 providing the icons for the form element in this page -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" media="screen" href="css/style_not_found_page.css" />
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
                    <li><a href="GAME/game_work/flappycat.php">Play a Game</a></li>
                    <li><a href="login.php">Sign In</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="home">
        <!-- <div class="landing-text"> -->
        <div class="landing-image">
            <!-- <h1>BLUECAT</h1> -->
            <img src="images/404-falafels.png" class="img-responsive" id="landing-img">
            <!-- <h3>Error 404 - Page not found</h3> -->
            <img src="images/404-sorry.png" class="img-responsive" id="landing-img-sorry">
            <!-- <h3>[What about Create a New One? Eh!]</h3> -->
            <img src="images/404-whatabout.png" class="img-responsive" id="landing-img-whatabout">
            <div class="text-center">
                <a href="create-account.php" class="btn btn-default btn-lg">Create Account</a>
            </div>
            
        </div>
    </div>

    <div id="about" class="padding">
        <div class="container">
            <div class="row">
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

    <div id="fixed">
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