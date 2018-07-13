<?php
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Post.php');

if (isset($_GET['topic']))
{
    if (DB::query("SELECT posts_topics FROM tb_posts WHERE FIND_IN_SET(:topic, posts_topics)", array(':topic'=>$_GET['topic'])))
    {
        //echo "Valid Topic";
        $posts = DB::query("SELECT * FROM tb_posts WHERE FIND_IN_SET(:topic, posts_topics)", array(':topic'=>$_GET['topic']));

        foreach ($posts as $post)
        {
            //echo "<pre>";
            //print_r ($post);
            //echo "</pre>";
            echo $post['posts_body']."<br />";
        }
    }
}

?>