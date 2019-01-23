<?php

/* 
    Created on : 15-Jul-2018, 06:02:39 PM
    Author     : Marc Freir
    License    : This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.
*/

class Notify
{
    public static function createNotify($text = "", $postid = 0)
    {
        $text = explode(" ", $text);
        $notify = array();

        foreach ($text as $word)
        {
            if (substr($word, 0, 1) == "@")
            {
                $notify[substr($word, 1)] = array("notifications_type"=>1, "notifications_extra"=>' { "postbody": "'.htmlentities(implode($text, " ")).'" } ');
            }
        }

        if (count($text) == 1 && $postid != 0)
        {
            $temp = DB::query('SELECT tb_posts.posts_userid AS receiver, tb_post_likes.post_likes_user_id AS sender FROM tb_posts, tb_post_likes WHERE tb_posts.posts_id = tb_post_likes.post_likes_post_id AND tb_posts.posts_id=:postid', array(':postid'=>$postid));
            $r = $temp[0]["receiver"];
            $s = $temp[0]["sender"];
            DB::query('INSERT INTO tb_notifications VALUES (\'\', :ntype, :receiver, :sender, :extra)', array(':ntype'=>2, ':receiver'=>$r, ':sender'=>$s, ':extra'=>""));
        }
        return $notify;
    }
}
?>