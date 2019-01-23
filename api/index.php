<?php

/* 
    Created on : 15-Jul-2018, 06:02:39 PM
    Author     : Marc Freir
    License    : This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.
*/

require_once("DB.php");

$db = new DB("127.0.0.1", "db_bluecatnet", "root", "");

//print_r($_GET);

if ($_SERVER['REQUEST_METHOD'] == "GET")
{
    //echo json_encode(($db->query("SELECT * FROM tb_users")));
    //http_response_code(200);
    if ($_GET['url'] == "auth")
    {

    }
    else if ($_GET['url'] == "users")
    {

    }
    else if ($_GET['url'] == "posts")
    {
        $logintoken = $_COOKIE['BCNID'];

        $userid = $db->query('SELECT logintoken_userid FROM tb_login_tokens WHERE logintoken=:logintoken', array(':logintoken'=>sha1($logintoken)))[0]['logintoken_userid'];

        $followingPosts = $db->query('SELECT tb_posts.posts_id, tb_posts.posts_body, tb_posts.posts_posted_at, tb_posts.posts_likes, tb_users.username FROM tb_users, tb_posts, tb_followers
        WHERE tb_posts.posts_userid = tb_followers.followers_userid
        AND tb_users.userid = tb_posts.posts_userid
        AND followers_followerid = :userid
        ORDER BY tb_posts.posts_likes DESC;', array(':userid'=>$userid));

        $response = "[";

        foreach($followingPosts as $post)
        {

            $response .= "{";
                $response .= '"PostId": '.$post['posts_id'].',';
                $response .= '"PostBody": "'.$post['posts_body'].'",';
                $response .= '"PostedBy": "'.$post['username'].'",';
                $response .= '"PostDate": "'.$post['posts_posted_at'].'",';
                $response .= '"Likes": '.$post['posts_likes'].'';
            $response .= "},";

            /* Do not delete for this time //THIS CODE START HERE
            echo "
                <div class='container'>
                    <div class='card'>
                        <div class='card-body'>
                            ".$post['posts_body']." ~ <a href='profile.php?username=".$post['username']."'>@".$post['username']."</a>";
            echo "
                        </div>
            
                        <form action='index.php?postid=".$post['posts_id']."' method='post' id='content'>
                            <!-- <div class='input-group lg'> -->
                            <div class='btn-group lg'>
                ";

            if (!$db->query('SELECT post_likes_post_id FROM tb_post_likes WHERE post_likes_post_id=:postid AND post_likes_user_id=:userid', array(':postid'=>$post['posts_id'], ':userid'=>$userid)))
            {
                echo "
                        <!-- <span class='input-group-addon'></span> -->
                        <!-- <input type='submit' name='like' value='Like'> -->
                            <button class='small button' name='Send' type='submit' id='sml-button'><i class='fa fa-heart'></i> Like</button>
                            <button class='small button' name='Send' type='submit' id='sml-button'><i class='fa fa-share-square'></i> Share</button>
                            <button class='small button' name='Send' type='submit' id='sml-button'><i class='fa fa-trash'></i> Delete</button>
                        </div>
                    <!-- </div> -->
                    ";
            }
            else
            {
                echo "
                            <!-- <span class='input-group-addon'></span> -->
                            <!-- <input type='submit' name='unlike' value='Unlike'> -->
                                <button class='small button' name='Send' type='submit' id='smu-button'><i class='fa fa-thumbs-down'></i> Unlike</button>
                                <button class='small button' name='Send' type='submit' id='smu-button'><i class='fa fa-share-square'></i> Share</button>
                                <button class='small button' name='Send' type='submit' id='smu-button'><i class='fa fa-trash'></i> Delete</button>
                            </div>
                    <!-- </div> -->
                    ";
            }
            echo "
                            <hr />
                            <span><h4 class='fa fa-heart-o' id='sml-button'> ".$post['posts_likes']." like(s)</h4></span>

                        </form>
                    </div>
                </div>
                <section class='container-fluid' id=''>
                    <div class='container' id='con-post'>
                        <div class='card'>
                            <div class='card-body cb'>  
                                <form action='index.php?postid=".$post['posts_id']."' method='post'>
                                    <div class='btn-group'>
                                        <div class='btn-group'>
                                            <textarea class='form-control' name='commentbody' rows='3' cols='40' id='textareaaa'></textarea>
                                            <input type='submit' name='comment' value='Comment' id='reload'>
                                            <!-- <button type='submit' formmethod='post' class='small button' name='submit' id='smu-button'><i class='fa fa-comment'></i> Comment</button> -->
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
                <div class='container'>
                    <div class='card'>
                        <div class='card-body'>
                ";

            //Comment::displayComments($post['posts_id']);
            echo "
                        <!-- <hr /></br /> -->
                    </div>
                </div>
            </div>
                ";
            */ //FINISHES HERE
        }
        $response = substr($response, 0, strlen($response)-1);
        $response .= "]";
        //echo "<pre>";
        echo $response;
    }
}
else if ($_SERVER['REQUEST_METHOD'] == "POST")
{
    //echo "POST";
    if ($_GET['url'] == "users")
    {
        $postBody = file_get_contents("php://input");
        $postBody = json_decode($postBody);
        //print_r ($postBody);

        $username = $postBody->username;
        $useremail = $postBody->useremail;
        $userpassword = $postBody->userpassword;

        if (!$db->query('SELECT username FROM tb_users WHERE username=:username', array(':username'=>$username)))
        {
            if (strlen($username) >= 3 && strlen($username) <= 32)
            {
                if (preg_match('/[a-zA-Z0-9_]+/', $username))
                {
                    if (strlen($userpassword) >= 6 && strlen($userpassword) <= 60)
                    {
                        if (filter_var($useremail, FILTER_VALIDATE_EMAIL))
                        {
                            if (!$db->query('SELECT useremail FROM tb_users WHERE useremail=:useremail', array(':useremail'=>$useremail)))
                            {
                                $db->query('INSERT INTO tb_users VALUES (\'\', :username, :userpassword, :useremail, \'0\')', array(':username'=>$username, ':userpassword'=>password_hash($userpassword, PASSWORD_BCRYPT), ':useremail'=>$useremail));
                                //echo "Success!";
                                echo '{ "Success": "User Created!" }';
                                http_response_code(200);
                            }
                            else
                            {
                                //echo 'Email already used!';
                                echo '{ "Error": "Email already used!" }';
                                http_response_code(409);
                            }

                        }
                        else
                        {
                            //echo 'Invalid email!';
                            echo '{ "Error": "Invalid email!" }';
                            http_response_code(409);
                        }
                    }
                    else
                    {
                        //echo 'Invalid password!';
                        echo '{ "Error": "Invalid password!" }';
                        http_response_code(409);
                    }
            
                }
                else
                {
                    //echo 'Invalid username!';
                    echo '{ "Error": "Invalid username!" }';
                    http_response_code(409);
                }
           
            }
            else
            {
                //echo 'Invalid username!';
                echo '{ "Error": "Invalid username!" }';
                http_response_code(409);
            }

        }
        else
        {
            //echo 'User already exists!';
            echo '{ "Error": "User already exists!" }';
            http_response_code(409);
        }
        
    }

    if ($_GET['url'] == "auth")
    {
        $postBody = file_get_contents("php://input");
        $postBody = json_decode($postBody);
        //print_r ($postBody);

        $username = $postBody->username;
        $userpassword = $postBody->userpassword;
        
        if ($db->query('SELECT username FROM tb_users WHERE username=:username', array(':username'=>$username)))
        {
            if (password_verify($userpassword, $db->query('SELECT userpassword FROM tb_users WHERE username=:username', array(':username'=>$username))[0]['userpassword']))
            {
                $cstrong = True;
                $logintoken = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                //echo $logintoken;
                $logintoken_userid = $db->query('SELECT userid FROM tb_users WHERE username=:username', array(':username'=>$username))[0]['userid'];
                $db->query('INSERT INTO tb_login_tokens VALUES (\'\', :logintoken, :logintoken_userid)', array(':logintoken'=>sha1($logintoken), ':logintoken_userid'=>$logintoken_userid));
                echo '{ "Token": "'.$logintoken.'" }';
            }
            else
            {
                echo '{ "Error": "Invalid username or password!" }';
                http_response_code(401);
            }
        }
        else
        {
            echo '{ "Error": "Invalid username or password!" }';
            http_response_code(401);
        }
    }
    else if ($_GET['url'] == "likes")
    {
        $postId = $_GET['posts_id'];
        $logintoken = $_COOKIE['BCNID'];
        $likerId = $db->query('SELECT logintoken_userid FROM tb_login_tokens WHERE logintoken=:logintoken', array(':logintoken'=>sha1($logintoken)))[0]['logintoken_userid'];

        if (!$db->query('SELECT post_likes_user_id FROM tb_post_likes WHERE post_likes_post_id=:postid AND post_likes_user_id=:userid', array(':postid'=>$postId, ':userid'=>$likerId)))
        {
            $db->query('UPDATE tb_posts SET posts_likes=posts_likes+1 WHERE posts_id=:postid', array(':postid'=>$postId));
            $db->query('INSERT INTO tb_post_likes VALUES (\'\', :postid, :userid)', array(':postid'=>$postId, ':userid'=>$likerId));
            //Notify::createNotify("", $postid);
        }
        else
        {
            //echo 'Already liked!';
            $db->query('UPDATE tb_posts SET posts_likes=posts_likes-1 WHERE posts_id=:postid', array(':postid'=>$postid));
            $db->query('DELETE FROM tb_post_likes WHERE post_likes_post_id=:postid AND post_likes_user_id=:userid', array(':postid'=>$postid, ':userid'=>$likerId));
        }

        echo "{";
        echo '"Like(s)":';
        echo $db->query('SELECT posts_likes FROM tb_posts WHERE posts_id=:postid', array(':postid'=>$postId))[0]['posts_likes'];
        echo "}";
    }
}
else if ($_SERVER['REQUEST_METHOD'] == "DELETE")
{
    if ($_GET['url'] == "auth")
    {
        if (isset($_GET['logintoken']))
        {
            if ($db->query('SELECT logintoken FROM tb_login_tokens WHERE logintoken=:logintoken', array(':logintoken'=>sha1($_GET['logintoken']))))
            {
                $db->query('DELETE FROM tb_login_tokens WHERE logintoken=:logintoken', array(':logintoken'=>sha1($_GET['logintoken'])));
                echo '{ "Status": "Success" }';
                http_response_code(200);
            }
            else
            {
                echo '{ "Error": "Invalid logintoken" }';
                http_response_code(400);
            }
        }
        else
        {
            echo '{ "Error": "Malformed request" }';
            http_response_code(400);
        }
    }
}
else
{
    http_response_code(405);
}
?>