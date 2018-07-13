<?php
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Post.php');
include('./classes/Notify.php');

$username = "";
$userverified = FALSE;
$isFollowing = FALSE;


if (isset($_GET['username']))
{
    if (DB::query('SELECT username FROM tb_users WHERE username=:username', array(':username'=>$_GET['username'])))
    {
        $username = DB::query('SELECT username FROM tb_users WHERE username=:username', array(':username'=>$_GET['username']))[0]['username'];
        $userid = DB::query('SELECT userid FROM tb_users WHERE username=:username', array(':username'=>$_GET['username']))[0]['userid'];
        $userverified = DB::query('SELECT userverified FROM tb_users WHERE username=:username', array(':username'=>$_GET['username']))[0]['userverified'];
        $followerid = Login::isLoggedIn();

        if (isset($_POST['follow']))
        {

            if ($userid != $followerid)
            {
                if (!DB::query('SELECT followers_followerid FROM tb_followers WHERE followers_userid=:userid AND followers_followerid=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid)))
                {
                    if ($followerid == 4)
                    {
                        DB::query('UPDATE tb_users SET userverified=1 WHERE userid=:userid', array(':userid'=>$userid));
                    }

                    DB::query('INSERT INTO tb_followers VALUES (\'\', :userid, :followerid)', array(':userid'=>$userid, ':followerid'=>$followerid));
    
                }
                else
                {
                    echo 'Already following!';
                }
    
                $isFollowing = TRUE;
            }


        }

        if (isset($_POST['unfollow']))
        {
            if ($userid != $followerid)
            {
                if (DB::query('SELECT followers_followerid FROM tb_followers WHERE followers_userid=:userid AND followers_followerid=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid)))
                {
                    if ($followerid == 4)
                    {
                        DB::query('UPDATE tb_users SET userverified=0 WHERE userid=:userid', array(':userid'=>$userid));
                    }

                    DB::query('DELETE FROM tb_followers WHERE followers_userid=:userid AND followers_followerid=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid));
    
                }
                
                $isFollowing = FALSE;
            }

        }

        if (DB::query('SELECT followers_followerid FROM tb_followers WHERE followers_userid=:userid AND followers_followerid=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid)))
        {
            //echo 'Already following!';
            $isFollowing = TRUE;
        }

        if (isset($_POST['deletepost']))
        {
            if (DB::query('SELECT posts_id FROM tb_posts WHERE posts_id=:postid AND posts_userid=:userid', array(':postid'=>$_GET['postid'], ':userid'=>$followerid)))
            {
                DB::query('DELETE FROM tb_posts WHERE posts_id=:postid AND posts_userid=:userid', array(':postid'=>$_GET['postid'], ':userid'=>$followerid));
                DB::query('DELETE FROM tb_post_likes WHERE post_likes_post_id=:postid', array(':postid'=>$_GET['postid']));
                
                //DB::query('DELETE FROM tb_post_likes WHERE post_likes_post_id=:postid', array(':postid'=>$_GET['postid']));
                //DB::query('DELETE FROM tb_posts WHERE posts_id=:postid AND posts_userid=:userid', array(':postid'=>$_GET['postid'], ':userid'=>$followerid));
                
                echo 'Post Deleted!';
            }
        }

        if (isset($_POST['post']))
        {
            Post::createPost($_POST['postbody'], Login::isLoggedIn(), $userid);
        }

        if (isset($_GET['postid']) && !isset($_POST['deletepost']))
        {
            Post::likePost($_GET['postid'], $followerid);
        }
        
        $posts = Post::displayPosts($userid, $username, $followerid);

    }
    else
    {
        die('User not found!');
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <!-- <script src="main.js"></script> -->
    <script
        src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous">
    </script>
</head>
<body>
    <h1><?php echo $username; ?>'s Profile<?php if ($userverified) { echo ' - Verified'; } ?></h1>
    <form action="profile.php?username=<?php echo $username; ?>" method="post">
    <?php
    if ($userid != $followerid)
    {
        if ($isFollowing)
        {
            echo '<input type="submit" name="unfollow" value="Unfollow">';
        }
        else
        {
            echo '<input type="submit" name="follow" value="Follow">';
        }
    }
    ?>
    </form>
    <form action="profile.php?username=<?php echo $username; ?>" method="post" class="ajax" id="content">
        <textarea name="postbody" rows="8" cols="80"></textarea>
        <!-- <input type="submit" name="post" value="Post"> -->
        <button type="submit" name="post">Postc</button>
    </form>

    <!-- AJAX -->
    <!-- <script>
    $("form.ajax").submit(function(e)
    {
        e.preventDefault();
    });
    </script> -->

    <!-- ANOTHER AJAX -->
    <!--
    <script>
        $("form.ajax").on('submit', function()
        {
            console.log("Trigger");
            var that = $(this),
                url = that.attr("action"),
                type = that.attr("method"),
                data = {};
            
            that.find("[name]").each(function(index, value)
            {
                var that = $(this),
                    name = that.attr("name"),
                    value = that.val();

                data[name] = value;
            });

            $.ajax(
                {
                    url: url,
                    type: type,
                    data: data,
                    success: function(response)
                    {
                        console.log(response);
                    }
                });
            return false;
        });

        $(document).ready(function()
        {
            // initial
            $("#content").load("content/profile.php");

            //handle menu clicks
            $("form#content textarea").click(function()
            {
                var page = $(this).attr("action");
                $("#content").load("content/" + page + ".php");
                return false;
            });
        });
    </script>
    -->
    <div class="posts" id="contentpost">
        <?php echo $posts; ?>
    </div>

    <!-- AJAX -->
    <!-- <script>
    $("form.ajax").submit(function(e)
    {
        e.preventDefault();
    });
    </script> -->

    <!-- ANOTHER AJAX -->
    <!--
    <script>
        $("form.ajax").on('submit', function()
        {
            console.log("Trigger");
            var that = $(this),
                url = that.attr("action"),
                type = that.attr("method"),
                data = {};
            
            that.find("[name]").each(function(index, value)
            {
                var that = $(this),
                    name = that.attr("name"),
                    value = that.val();

                data[name] = value;
            });

            $.ajax(
                {
                    url: url,
                    type: type,
                    data: data,
                    success: function(response)
                    {
                        console.log(response);
                    }
                });
            return false;
        });

        $(document).ready(function()
        {
            // initial
            $("#contentpost").load("contentpost/profile.php");

            //handle menu clicks
            $("div#contentpost").click(function()
            {
                var page = $(this).attr("action");
                $("#contentpost").load("contentpost/" + page + ".php");
                return false;
            });
        });
    </script>
    -->
</body>
</html>