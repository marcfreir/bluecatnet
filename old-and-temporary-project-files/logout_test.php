<?php
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Logout.php');


if (!Login::isLoggedIn())
{
    die("Not logged in.");

}
if (isset($_POST['confirm']))
{
    
    if (isset($_POST['alldevices']))
    {
        session_start();
        session_destroy();
    }
    else
    {
        if (isset($_COOKIE['BCNID'])){
            DB::query('DELETE FROM tb_login_tokens WHERE logintoken=:logintoken', array(':logintoken'=>sha1($_COOKIE['BCNID'])));
        }
        setcookie('BCNID', '1', time()-42000);
        setcookie('_BCNID', '1', time()-42000);
        


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
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
    <h1>Logout of your account</h1>
    <p>Are you shure you what to logout?</p>
    <form action="logout.php" method="post">
    <input type="checkbox" name="alldevices" value="alldevices">Logout of all devices?<br />
    <input type="submit" name="confirm" value="Confirm">    
    </form>
</body>
</html>