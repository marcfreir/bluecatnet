<?php
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Post.php');
include('./classes/Comment.php');
include('./classes/HTML_Head_Body.php');
//include('./classes/HTML_Head_Body_part1.php');
//include('./classes/HTML_Head_Body_part2.php');
include('./classes/HTML_Footer.php');
include('./classes/Notify.php');

//CARRYING THE USERNAME INTO THE SESSION - START
//DB::query('INSERT INTO tb_usersession VALUES (:usernamesession)', array(':usernamesession'=>$username));
////$usernamesession = DB::query('SELECT usernamesession FROM tb_usersession', array('usernamesession'))[0];
//echo $usernamesession;
//HTML_Head_Body::displayUsersession($usernamesession);
// - END

$showTimeline = FALSE;

if (Login::isLoggedIn())
{
    //echo 'Logged In!';
    //echo Login::isLoggedIn();
    //START BODY PAGE
    

    //END BODY PAGE

    //PHP VARIABLES
    $userid = Login::isLoggedIn();
    $showTimeline = TRUE;
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

if (isset($_GET['postid']))
{
    Post::likePost($_GET['postid'], $userid);
}
if (isset($_POST['comment']))
{
    Comment::createComment($_POST['commentbody'], $_GET['postid'], $userid);
}
/*
if (isset($_POST['searchbox']))
{
    $users = DB::query('SELECT tb_users.username FROM tb_users WHERE tb_users.username LIKE :username', array(':username'=>'%'.$_POST['searchbox'].'%'));
    echo "<br /><br /><br /><br /><br /><br /><br /><br /><br />";
    echo "zxcsdfsdfsdfsdf";
    print_r ($users);
}
*/

//>>just a break here
?>
<!--  Division | HTML Code -->
<!--  Search box -->
<!-- Moved to the HTML_Head_Body.php
<form action="index.php" method="post">
    <input type="text" name="searchbox" value="">
    <input type="submit" name="search" value="Search">
</form>
-->
<?php
//<<here the code continues

$followingPosts = DB::query('SELECT tb_posts.posts_id, tb_posts.posts_body, tb_posts.posts_likes, tb_users.username FROM tb_users, tb_posts, tb_followers
WHERE tb_posts.posts_userid = tb_followers.followers_userid
AND tb_users.userid = tb_posts.posts_userid
AND followers_followerid = :userid
ORDER BY tb_posts.posts_likes DESC;', array(':userid'=>$userid));

//print_r($followingPosts);

//HEAD AND BODY
//echo '(html code)';
//INSTEAD OF WRINTING THE WHOLE HTML CODE HERE, JUST CALL IT FROM A CLASS, IN THIS CASE "HTML_Head_Body.php" THE METHOD "htmlHB"

//
$usersession_userid = "";
$usersession_username = "";
//$usersession_username = DB::query('SELECT usernamesession FROM tb_usersession WHERE usernamesession=:username', array(':username'=>$username))[0]['usernamesession'];
$usersession_userid = DB::query('SELECT usersession_user_id FROM tb_usersession WHERE usersession_user_id=:usersession_user_id', array(':usersession_user_id'=>$userid))[0]['usersession_user_id'];
$usersession_username = DB::query('SELECT usernamesession FROM tb_usersession WHERE usersession_user_id=:usersession_user_id', array(':usersession_user_id'=>$userid))[0]['usernamesession'];
//

HTML_Head_Body::htmlHB();


/*
//TEST - Start here
//$userinURL = DB::query('SELECT tb_users.username FROM tb_users WHERE username=:username;', array(':username'=>$username));
$userinURL = DB::query('SELECT tb_users.username FROM tb_users;');
HTML_Head_Body_part1::htmlHB_part1();
//HTML_Head_Body_part_post::htmlHB();
foreach($userinURL as $postURL)
{
    echo '
    <li><a href="profile.php?username='.$postURL['username'].'">Profile</a></li>
    ';
}
HTML_Head_Body_part2::htmlHB_part2();
//TEST - Finish here
*/
echo "<li><a href='profile.php?username=".$usersession_username."'>My Posts</a></li>";
HTML_Head_Body::htmlHB_p2();

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
    //print_r ($users);
    //for printing the users
    foreach ($users as $user)
    {
        //echo '<h4 class="fa fa-user-circle-o"> User: </h4>'.'@'.$user['username'].'<hr />';
        echo '<h4 class="fa fa-user-circle-o"> User: </h4>'.' ~ <a href="profile.php?username='.$user["username"].'">@'.$user["username"].'</a>'.'<hr />';
    }
    

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
    //echo '<pre>';
    //print_r ($posts);
    //echo '</pre>';
    //for printing the posts
    foreach ($posts as $postuser)
    {
        echo '<div class="container">'.
        '<h4 class="fa fa-comment"> Post: </h4>'.'<h6>'.'>>'.$postuser['posts_body'].'<h6>'.'<hr />'.
        '</div>';
    }
    echo '<div class="container">
    <form>
    <h5 id="nomorerecords">There is no more records!</h5>
    <button class="btn btn-primary btn-block" id="clearsearch" type="submit" formaction="index.php" data-bs-hover-animate="shake">Clear this search</button>
    </form>
    </div>
        <hr />';
}

//piece of HTML code from HTML_Head_Body.php to display the text "NEWSFEED"
echo '<div id="newsfeedhome">
        <div class="newsfeed">
            <h1>~News Feed~</h1>
        </div>
    </div>';

foreach($followingPosts as $post)
{
    echo "
        <div class='container'>
            <div class='card'>
                <div class='card-body'>
                    <div class='timelineposts'>
                        <blockquote>
                            <p>
                                ".$post['posts_body']." ~ <a href='profile.php?username=".$post['username']."'>@".$post['username']."</a>";
    echo "
                            </p>
                        </blockquote>
                    </div>
                </div>
            
                <form action='index.php?postid=".$post['posts_id']."' method='post' id='content'>
                    <!-- <div class='input-group lg'> -->
                    <div class='btn-group lg'>
        ";

    if (!DB::query('SELECT post_likes_post_id FROM tb_post_likes WHERE post_likes_post_id=:postid AND post_likes_user_id=:userid', array(':postid'=>$post['posts_id'], ':userid'=>$userid)))
    {
        echo "
                    <!-- <span class='input-group-addon'></span> -->
                    <!-- <input type='submit' name='like' value='Like'> -->
                        <button class='small button' name='Send' type='submit' id='sml-button'><i class='fa fa-heart'></i> Like</button>
                        <button class='small button' name='Send' type='submit' id='sml-button'><i class='fa fa-share-square'></i> Share</button>
                        <!-- <button class='small button' name='Send' type='submit' id='sml-button'><i class='fa fa-trash'></i> Delete</button> -->
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
                        <!-- <button class='small button' name='Send' type='submit' id='smu-button'><i class='fa fa-trash'></i> Delete</button> -->
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

        Comment::displayComments($post['posts_id']);
        echo "
                    <!-- <hr /></br /> -->
                </div>
            </div>
        </div>
                ";
}


//test
/*<h1><?php echo "<h2>".$usersession_username."</h2>" ?></h1>*/

//$usersession_userid = "";
//$usersession_username = "";
////$usersession_username = DB::query('SELECT usernamesession FROM tb_usersession WHERE usernamesession=:username', array(':username'=>$username))[0]['usernamesession'];
//$usersession_userid = DB::query('SELECT usersession_user_id FROM tb_usersession WHERE usersession_user_id=:usersession_user_id', array(':usersession_user_id'=>$userid))[0]['usersession_user_id'];
//$usersession_username = DB::query('SELECT usernamesession FROM tb_usersession WHERE usersession_user_id=:usersession_user_id', array(':usersession_user_id'=>$userid))[0]['usernamesession'];
echo "<h4>Who am I? >> ".$usersession_username."</h4>";


//FOOTER
//echo '(html code)';
//INSTEAD OF WRINTING THE WHOLE HTML CODE HERE, JUST CALL IT FROM A CLASS, IN THIS CASE "HTML_Footer.php" THE METHOD "htmlFOOTER"
HTML_Footer::htmlFOOTER();


?>

<html>
<!-- FIRST JQUERY SCRIPT (TEST)
            <script>
                $(document).ready(function()
                {
                    // initial
                    $("#content").load("content/index.php");

                    //handle menu clicks
                    $("form#content textarea").click(function()
                    {
                        var page = $(this).attr("action");
                        $("#content").load("content/" + page);
                        return false;
                    });
                });
            </script>
-->

<!-- SECOND JQUERY SCRIPT -->
            <script type="text/javascript">
                $(document).ready(function()
                {
                    $.ajax({
                        type: "GET",
                        url: "api/posts",
                        processData: false,
                        contentType: "application/json",
                        data: '',
                        success: function(r) //this is the original
                        {
                            var posts = JSON.parse(r)
                            $.each(posts, function(index))
                            {
                                $('.timelineposts').html(
                                    $('.timelineposts').html() + '<blockquote><p>'+posts[index].PostBody+'</p><footer>Posted by '+posts[index].PostedBy+' on '+posts[index].PostDate+'<button class="btn btn-default" data-id="'+posts[index].PostId+'" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"> <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+posts[index].Likes+' Likes</span></button><button class="btn btn-default comment" type="button" style="color:#eb3b60;background-image:url(&quot;none&quot;);background-color:transparent;"><i class="glyphicon glyphicon-flash" style="color:#f9d616;"></i><span style="color:#f9d616;"> Comments</span></button></footer></blockquote>'
                                )
                                $('[data-id]').click(function()
                                {
                                    var buttonid = $(this).attr('data-id');
                                    $.ajax({
                                        type: "POST",
                                        url: "api/likes?id=" + $(this).attr('data-id'),
                                        processData: false,
                                        contentType: "application/json",
                                        data: '',
                                        success: function(r)
                                        {
                                            var res = JSON.parse(r)
                                            $("[data-id='"+buttonid+"']").html(' <i class="glyphicon glyphicon-heart" data-aos="flip-right"></i><span> '+res.Likes+' Likes</span>')
                                        },
                                        error: function(r)
                                        {
                                            console.log(r)
                                        }
                                    });
                                })
                            })
                        },
                        error: function(r)
                        {
                            console.log(r)
                        }

                    });
                });
            </script>
</html>