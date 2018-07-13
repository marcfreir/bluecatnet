<?php
include('./classes/DB.php');
include('./classes/Login.php');

$tokenIsValid = False;

if (Login::isLoggedIn())
{
    //echo 'Logged In!';
    //echo Login::isLoggedIn();

    if (isset($_POST['changepassword']))
    {
        $oldpassword = $_POST['oldpassword'];
        $newpassword = $_POST['newpassword'];
        $newpasswordrepeat = $_POST['newpasswordrepeat'];
        $userid = Login::isLoggedIn();

        if (password_verify($oldpassword, DB::query('SELECT userpassword FROM tb_users WHERE userid=:userid', array(':userid'=>$userid))[0]['userpassword']))
        {
            if ($newpassword == $newpasswordrepeat)
            {
                if (strlen($newpassword) >= 6 && strlen($newpassword) <= 60)
                {
                    DB::query('UPDATE tb_users SET userpassword=:newpassword WHERE userid=:userid', array(':newpassword'=>password_hash($newpassword, PASSWORD_BCRYPT), ':userid'=>$userid));
                    echo 'Password changed successfully!';

                }

            }
            else
            {
                echo 'Password don\'t match!';
            }

        }
        else
        {
            echo 'The old password is incorrect!';
        }

    }
}
else
{
    if (isset($_GET['passwordtoken']))
    {

        $passwordtoken = $_GET['passwordtoken'];

        if (DB::query('SELECT passwordtoken_userid FROM tb_password_tokens WHERE passwordtoken=:passwordtoken', array(':passwordtoken'=>sha1($passwordtoken))))
        {
            $userid = DB::query('SELECT passwordtoken_userid FROM tb_password_tokens WHERE passwordtoken=:passwordtoken', array(':passwordtoken'=>sha1($passwordtoken)))[0]['passwordtoken_userid'];

            $tokenIsValid = True;

            if (isset($_POST['changepassword']))
            {
                $newpassword = $_POST['newpassword'];
                $newpasswordrepeat = $_POST['newpasswordrepeat'];
    
            
                if ($newpassword == $newpasswordrepeat)
                {
                    if (strlen($newpassword) >= 6 && strlen($newpassword) <= 60)
                    {
                        DB::query('UPDATE tb_users SET userpassword=:newpassword WHERE userid=:userid', array(':newpassword'=>password_hash($newpassword, PASSWORD_BCRYPT), ':userid'=>$userid));
                        echo 'Password changed successfully!';

                        DB::query('DELETE FROM tb_password_tokens WHERE passwordtoken_userid=:passwordtoken_userid', array(':passwordtoken_userid'=>$userid));
    
                    }
    
                }
                else
                {
                    echo 'Password don\'t match!';
                }
    
            }
    
        }
        else
        {
            die('Invalid token...');
        }
    }
    else
    {
        die('Not Logged In');
    }


}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Change Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
    <h1>Change Your Password</h1>
    <form action="<?php if (!$tokenIsValid) { echo 'change-password.php'; } else { echo 'change-password.php?passwordtoken='.$passwordtoken.''; } ?>" method="post">
    <?php if (!$tokenIsValid) { echo '<input type="password" name="oldpassword" value="" placeholder="Current Password..."><p />'; } ?>
    <input type="password" name="newpassword" value="" placeholder="New Password..."><p />
    <input type="password" name="newpasswordrepeat" value="" placeholder="Repeat New Password..."><p />
    <input type="submit" name="changepassword" value="Change Password">
    </form>
</body>
</html>