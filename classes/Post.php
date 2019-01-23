<?php

/* 
    Created on : 15-Jul-2018, 06:02:39 PM
    Author     : Marc Freir
    License    : This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.
*/

class Post
{
    public static function createPost($postbody, $loggedInUserId, $profileUserId)
    {
        if (strlen($postbody) > 160 || strlen($postbody) < 1)
        {
            //die('Incorrect length!');
            echo "Dude - you don't wanna do this!";
            die;
        }

        $topics = self::getTopics($postbody);

        if ($loggedInUserId == $profileUserId)
        {
            if (count(Notify::createNotify($postbody)) != 0)
            {
                foreach (Notify::createNotify($postbody) as $key => $n)
                {
                    $s = $loggedInUserId;
                    $r = DB::query('SELECT userid FROM tb_users WHERE username=:username', array(':username'=>$key))[0]['userid'];
                    if ($r != 0)
                    {
                        //$temp = DB::query();
                        DB::query('INSERT INTO tb_notifications VALUES (\'\', :ntype, :receiver, :sender, :extra)', array(':ntype'=>2, ':receiver'=>$r, ':sender'=>$s, ':extra'=>""));
                    }
                }
            }

            DB::query('INSERT INTO tb_posts VALUES (\'\', :postbody, NOW(), :userid, 0, :topics)', array(':postbody'=>$postbody, ':userid'=>$profileUserId, ':topics'=>$topics));
        }
        else
        {
            die('Incorrect user!');
        }
    }

    public static function likePost($postid, $likerId)
    {
        if (!DB::query('SELECT post_likes_user_id FROM tb_post_likes WHERE post_likes_post_id=:postid AND post_likes_user_id=:userid', array(':postid'=>$postid, ':userid'=>$likerId)))
        {
            DB::query('UPDATE tb_posts SET posts_likes=posts_likes+1 WHERE posts_id=:postid', array(':postid'=>$postid));
            DB::query('INSERT INTO tb_post_likes VALUES (\'\', :postid, :userid)', array(':postid'=>$postid, ':userid'=>$likerId));
            Notify::createNotify("", $postid);
        }
        else
        {
            //echo 'Already liked!';
            DB::query('UPDATE tb_posts SET posts_likes=posts_likes-1 WHERE posts_id=:postid', array(':postid'=>$postid));
            DB::query('DELETE FROM tb_post_likes WHERE post_likes_post_id=:postid AND post_likes_user_id=:userid', array(':postid'=>$postid, ':userid'=>$likerId));
        }
    }

    public static function getTopics($text)
    {
        $text = explode(" ", $text);
        $topics = "";

        foreach ($text as $word)
        {
            if (substr($word, 0, 1) == "#")
            {
                $topics .= substr($word, 1).",";
            }
        }

        //echo $topics;

        return $topics;
    }

    public static function link_add($text)
    {
        $text = explode(" ", $text);
        $newstring = "";

        foreach ($text as $word)
        {
            if (substr($word, 0, 1) == "@")
            {
                $newstring .= "<a href='profile.php?username=".substr($word, 1)."'>".$word." </a>";
            }
            else if (substr($word, 0, 1) == "#")
            {
                $newstring .= "<a href='topics.php?topic=".substr($word, 1)."'>".$word." </a>";
            }
            else
            {
                $newstring .= $word." ";
            }
        }

        //echo $newstring;

        return $newstring;
    }

    public static function displayPosts($userid, $username, $loggedInUserId)
    {
        
        
        
        $dbposts = DB::query('SELECT * FROM tb_posts WHERE posts_userid=:userid ORDER BY posts_id DESC', array(':userid'=>$userid));
        $posts = "";

        

        foreach($dbposts as $p)
        {
            if (!DB::query('SELECT post_likes_post_id FROM tb_post_likes WHERE post_likes_post_id=:postid AND post_likes_user_id=:userid', array(':postid'=>$p['posts_id'], ':userid'=>$loggedInUserId)))
            {
                //$posts .= htmlspecialchars($p['posts_body'])."
                $posts .= (self::link_add($p['posts_body']))."
                <!-- <div class='container'>
                    <div> -->
                        <form action='profile.php?username=$username&postid=".$p['posts_id']."' method='post'>
                            <i class='fa fa-heart'></i><input class='btn btn-default' type='submit' name='like' value='Like'>
                            <span>".$p['posts_likes']." like(s)</span>
                ";

                if ($userid == $loggedInUserId)
                {
                    $posts .= "<i class='fa fa-trash'></i><input class='btn btn-default' type='submit' name='deletepost' value='Delete' />";
                }
                $posts .="
                        </form><hr /></br />
                ";
            }
            else
            {
                //$posts .= htmlspecialchars($p['posts_body'])."
                $posts .= (self::link_add($p['posts_body']))."
                <form action='profile.php?username=$username&postid=".$p['posts_id']."' method='post'>
                    <i class='fa fa-thumbs-down'></i><input class='btn btn-default' type='submit' name='unlike' value='Unlike'>
                    <span>".$p['posts_likes']." like(s)</span>
                    ";

                    if ($userid == $loggedInUserId)
                    {
                        $posts .= "<i class='fa fa-trash'></i><input class='btn btn-default' type='submit' name='deletepost' value='Delete' />";
                    }
                    $posts .="
                    </form><hr /></br />
                    
                    ";
                    
            }

        }

        return $posts;
    }
    
}
?>