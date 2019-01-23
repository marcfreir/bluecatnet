<?php

/* 
    Created on : 15-Jul-2018, 06:02:39 PM
    Author     : Marc Freir
    License    : This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.
*/

class  HTML_Head_Body
{
    public static function htmlHB()
    {
        //$usernamesession = DB::query('SELECT usernamesession FROM tb_usersession');
        //DB::query('SELECT usernamesession FROM tb_usersession WHERE usernamesession=:usernamesession', array(':usernamesession'=>$test));
        //$arr = array($usernamesession);
        

        echo "<!DOCTYPE html>
            <html>
            <head>
                <meta charset='utf-8' />
                <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                <title>index</title>
                <meta name='viewport' content='width=device-width, initial-scale=1'>
            
                <!-- <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'> -->
                <!-- This script calls the font awesome version 5.0.10 providing the icons for the form element in this page -->
                <!-- <script defer src='https://use.fontawesome.com/releases/v5.0.10/js/all.js' integrity='sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+' crossorigin='anonymous'></script> -->
                <!-- This link element calls the font awesome version 5.0.10 providing the icons for the form element in this page -->
                <!-- <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.0.10/css/all.css' integrity='sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg' crossorigin='anonymous'>

                <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
                <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'> -->
    
                <!-- Calling JQuery from the file (without CDN)-->
                <script src='js/jquery-3.3.1.min.js'></script>

                <!-- Calling JQuery Mobile from the file (without CDN)-->
                <link rel='stylesheet' type='text/css' media='screen' href='jquery-mobile/jquery.mobile-1.4.5.css' />
                <script src='jquery-mobile/jquery.mobile-1.4.5.js'></script>

                <!-- Calling Bootstrap from the file (without CDN)-->
                <link rel='stylesheet' type='text/css' media='screen' href='css/bootstrap.css' />
                <script src='js/bootstrap.js'></script>

                <!-- Calling Font Awesome from the file (without CDN)-->
                <link rel='stylesheet' href='font-awesome-4.7.0/css/font-awesome.css' />

                <!-- Calling Font Ionicons from the file (without CDN)-->
                <link rel='stylesheet' href='assets/css/fonts/ionicons.min.css' />

                <!-- Calling Animate from the file (without CDN)-->
                <link rel='stylesheet' href='assets/css/animate.css' />

                <link rel='stylesheet' type='text/css' media='screen' href='css/style_index.css' />
                <!-- THIS is for the collapsing of the navbar -->
                <!-- <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script> -->
                <!-- <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script> -->
                <!-- <script
                    src='https://code.jquery.com/jquery-3.3.1.js'
                    integrity='sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60='
                    crossorigin='anonymous'>
                </script> -->
                
            </head>
            <body>
            <div>
                <nav class='navbar navbar-default navbar-fixed-top' role='navigation' id='firstnavbar'>
                    <div class='container-fluid'>
                        <div class='navbar-header'>
                            <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#navbar-collapse-main'>
                                <span class='sr-only'>Toggle navigation</span>
                                <span class='icon-bar'></span>
                                <span class='icon-bar'></span>
                                <span class='icon-bar'></span>
                            </button>
                            <a class='navbar-brand' href='index.php'><img src='images/bc-main-logo-white.png'></a>
                        </div>
                        <!-- Moved to the second part >>htmlHM_p2 -->
                        <!-- <div>
                            <form>
                                <input type='text' name='searchbox' value=''>
                                <input type='submit' name='search' value='Search'>
                            </form>
                        </div> -->
                        <div class='collapse navbar-collapse' id='navbar-collapse-main'>
                            <ul class='nav navbar-nav navbar-right'>
                                <li><a class='active' href='index.php'>Home</a></li>";
    }

    public static function htmlHB_p2()
    {
        echo "
        
        <li><a href='resume.php'>Resume</a></li>
        <li><a href='settings.php'>Settings</a></li>
        <li><a href='#'>Messenger</a></li>
        <li><a href='notify.php'>Notifications</a></li>
        <li><a href='GAME/game_work/flappycat.php'>Play a Game</a></li>
        <li><a href='logout.php'>Sign Out</a></li>
    </ul>
</div>
</div>
</nav>
</div>
<div class='nav-right'>
    <form action='index.php' method='post' class='navbar-form navbar-right' role='search' id='secondnavbar'>
        <div class='form-group' id='searchitems'>
            <input type='text' name='searchbox' class='form-control' placeholder='Search'>
        </div>
        <input type='submit' name='search' class='btn btn-default' id='searchitems' value='Search'>
    </form>
</div>
<br />
<br />
<!-- Moved to index.php
<div class='newsfeed'>
    <h1>~NEWSFEED~</h1>
</div>
-->



<!--
<br />

<div>
<form class='navbar-form navbar-left' role='search'>
  <div class='form-group'>
    <input type='text' class='form-control' placeholder='Search'>
  </div>
  <button type='submit' class='btn btn-default'>Submit</button>
</form>
</div>
-->





<div class='container-fluid' id='home'>
    <div class='row'>
        <div class='landing-text'>
<!-- <div class='landing-text'> -->
<!-- <div class='landing-image'> -->

    <!-- PUT SOMETHING HERE - I DON T KNOW -->

        </div>
    </div>
</div>
<!-- </body> -->";
    }
}

?>