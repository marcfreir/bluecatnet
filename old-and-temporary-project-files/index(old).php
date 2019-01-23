<?php
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Post.php');
include('./classes/Comment.php');

$showTimeline = FALSE;

if (Login::isLoggedIn())
{
    $userid = Login::isLoggedIn();
    $showTimeline = TRUE;
}
else
{
    die ('Not logged in');
}

if (isset($_GET['postid']))
{
    Post::likePost($_GET['postid'], $userid);
}
if (isset($_POST['comment']))
{
    Comment::createComment($_POST['commentbody'], $_GET['postid'], $userid);
}

if (isset($_POST['searchbox']))
{
    $tosearch = explode(" ", $_POST['searchbox']);
    if (count($tosearch) == 1)
    {
            $tosearch = str_split($tosearch[0], 2);
    }
    $whereclause = "";
    $paramsarray = array(':username'=>'%'.$_POST['searchbox'].'%');
    for ($i = 0; $i < count($tosearch); $i++)
    {
            $whereclause .= " OR username LIKE :u$i ";
            $paramsarray[":u$i"] = $tosearch[$i];
    }
    $users = DB::query('SELECT tb_users.username FROM tb_users WHERE tb_users.username LIKE :username '.$whereclause.'', $paramsarray);
    print_r($users);

    $whereclause = "";
    $paramsarray = array(':body'=>'%'.$_POST['searchbox'].'%');
    for ($i = 0; $i < count($tosearch); $i++)
    {
            if ($i % 2)
            {
                $whereclause .= " OR posts_body LIKE :p$i ";
                $paramsarray[":p$i"] = $tosearch[$i];
            }
    }
    $posts = DB::query('SELECT tb_posts.posts_body FROM tb_posts WHERE tb_posts.posts_body LIKE :body '.$whereclause.'', $paramsarray);
    echo '<pre>';
    print_r($posts);
    echo '</pre>';
}

?>

<form action="index.php" method="post">
    <input type="text" name="searchbox" value="">
    <input type="submit" name="search" value="Search">
</form>

<?php

$followingPosts = DB::query('SELECT tb_posts.posts_id, tb_posts.posts_body, tb_posts.posts_likes, tb_users.username FROM tb_users, tb_posts, tb_followers
WHERE tb_posts.posts_userid = tb_followers.followers_userid
AND tb_users.userid = tb_posts.posts_userid
AND followers_followerid = :userid
ORDER BY tb_posts.posts_likes DESC;', array(':userid'=>$userid));

foreach($followingPosts as $post)
{

    echo $post['posts_body']." ~ ".$post['username'];
    echo "<form action='index.php?postid=".$post['posts_id']."' method='post'>";

    if (!DB::query('SELECT post_likes_post_id FROM tb_post_likes WHERE post_likes_post_id=:postid AND post_likes_user_id=:userid', array(':postid'=>$post['posts_id'], ':userid'=>$userid)))
    {
        
        echo "<input type='submit' name='like' value='Like'>";
    }
    else
    {
        echo "<input type='submit' name='unlike' value='Unlike'>";
    }
    echo "<span>".$post['posts_likes']." likes</span>
    </form>
    <form action='index.php?postid=".$post['posts_id']."' method='post'>
    <textarea name='commentbody' rows='3' cols='50'></textarea>
    <input type='submit' name='comment' value='Comment'>
    </form>
    ";
    Comment::displayComments($post['posts_id']);
    echo "
    <hr /></br />";


}
?>

<!-- HTML Code -->
<!-- Moved to Newsfeed.php -->