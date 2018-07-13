<?php
include('./classes/DB.php');
include('./classes/Login.php');

if (Login::isLoggedIn())
{
    //PHP VARIABLES
    $userid = Login::isLoggedIn();
}
else
{
    //die ('Not Logged In');

    //another way?
    //echo 'Not Logged In';
    //echo '<br />'.'This page will be redirected automatically in 5 seconds...';
    //redirect
    header("Refresh: 5; url=login.php");

    //another way 2?
    $notloggedinmsg = "Not Logged In";
    die;
}

echo "<h1>Notifications</h1>";

if (DB::query('SELECT * FROM tb_notifications WHERE notifications_receiver=:userid', array(':userid'=>$userid)))
{
    $notifications = DB::query('SELECT * FROM tb_notifications WHERE notifications_receiver=:userid ORDER BY notifications_id DESC', array(':userid'=>$userid));

    foreach($notifications as $n)
    {
        //print_r ($n);
        if ($n['notifications_type'] == 1)
        {
            //echo '@ Mention';
            $senderName = DB::query('SELECT username FROM tb_users WHERE userid=:senderid', array(':senderid'=>$n['notifications_sender']))[0]['username'];
            //echo "<pre>";
            ////print_r ($n);
            //echo $n['notifications_extra'];
            ////print_r (json_decode($n['notifications_extra']));
            //echo "</pre>";

            if ($n['notifications_extra'] == "")
            {
                echo "You got a notification!<hr />";
            }
            else
            {
                $extra = json_decode($n['notifications_extra']);
                echo $senderName." mentioned you in a post! - ".$extra->postbody."<hr />";
            }
        }
        else if ($n['notifications_type'] == 2)
        {
            $senderName = DB::query('SELECT username FROM tb_users WHERE userid=:senderid', array(':senderid'=>$n['notifications_sender']))[0]['username'];
            echo $senderName." liked your post!<hr />";
        }
    }
}

?>