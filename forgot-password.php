<?php
include('./classes/DB.php');

if (isset($_POST['resetpassword']))
{
    $cstrong = True;
    $passwordtoken = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
    $useremail = $_POST['useremail'];
    $passwordtoken_userid = DB::query('SELECT userid FROM tb_users WHERE useremail=:useremail', array(':useremail'=>$useremail))[0]['userid'];
    DB::query('INSERT INTO tb_password_tokens VALUES (\'\', :passwordtoken, :passwordtoken_userid)', array(':passwordtoken'=>sha1($passwordtoken), ':passwordtoken_userid'=>$passwordtoken_userid));

    echo 'E-mail sent!';
    echo '<br />';
    echo $passwordtoken;    
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Forgot Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
    <h1>Forgot Password</h1>
    <form action="forgot-password.php" method="post">
    <input type="text" name="useremail" value="" placeholder="Email..."><p />
    <input type="submit" name="resetpassword" value="Reset Password">
    </form>
    
</body>
</html>