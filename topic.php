<?php
include 'connect.php';
include 'header.php';
$user='';
if(isset($_COOKIE['uname']))
    $user = $_COOKIE['uname'];
else if(isset($_SESSION['uname']))
    $user = $_SESSION['uname'];
 $maxRec='';
$topicID =mysql_real_escape_string($_GET['id']);
if(isset($_GET['pg']))
        $page=$_GET['pg'];  
else
    $page=0;
//echo $page . $perpage;
if($page<1)
    $page=0;
$terminate=0;
$i=0;
$sql = "SELECT TopicID,Subject FROM topics WHERE TopicID ='$topicID '";			
$result = mysqli_query($conn,$sql);
if(!$result)
{
	echo '<div style="color:Red;font-weight:600;">The topic could not be displayed, please try again later.</div>';
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo '<div style="color:Red;font-weight:600;">This topic doesn&prime;t exist.</div>';   
    }
    else
    {
        while($row = mysqli_fetch_assoc($result))
        {
            $sub=$row['Subject'];
            $posts_sql = 'SELECT PostID,Topic,Content,Date,Author FROM posts 
                            WHERE Topic ='.$topicID.' LIMIT '.($page*$perpage).','.($perpage+2).'';
            $posts_result = mysqli_query($conn,$posts_sql);
            if(!$posts_result)
            {
		echo '<div style="color:Red;font-weight:600;">The posts could not be displayed, please try again later.</div>';
            }
            else
            {
                    $i=0;
                    while(($posts_row = mysqli_fetch_assoc($posts_result))&&($i<$perpage))
                    { 
                        if($i==0)
                            echo "<table class=\"topic\" border=\"1\"><tr><th colspan=\"2\">'$sub'</th></tr>";
                        echo '<tr class="topic-post">
                        <td class="user-post width="30%"> Post By : <a href="about_user.php?uname='.$posts_row['Author'].'">'.$posts_row['Author'].'</a><br/> Posted @ ' . date('d-m-Y H:i', strtotime($posts_row['Date']));
                        if(!empty($user) && ($user==$posts_row['Author']))
                        {
                            echo '<br/><br/>
                                <table>
                             <tr>
                                <td><a href="edit_post.php?id='.$posts_row['PostID'].'&tid='.$topicID.'&pg='.$page.'">Edit Post</a></td>
                                <td><a href="delete_post.php?id='.$posts_row['PostID'].'&tid='.$topicID.'&pg='.$page.'">Delete Post</a></td>
                                </tr>
                                </table>';
                        }
                        echo '</td>
                        <td class="post-content" width="70%">' .$posts_row['Content'] . '</td>
                        </tr>';
                        $i=$i+1;        
                    }
                    echo '</table>';
                    echo '<br/><table frame="none" rules="none" border="0"><tr><td align="left">
                        <a style="color:Blue;font-weight:600;" href="topic.php?id='.$topicID.'&pg='.($page-1).'">';
                    if($page>0) echo '<< Prev';echo '</a></td><td align="right">
                        <a style="color:Blue;font-weight:600;" href="topic.php?id='.$topicID.'&pg='.($page+1).'">';
                    if($posts_row = mysqli_fetch_assoc($posts_result)) echo 'Next >>';
                    else $terminate=1;
                    $page=$page+1;
                    echo '</td></tr></table>';
            }
            if(!isset($_SESSION['uname'])&&!isset($_COOKIE['uname']))
            {
		echo '<br/><div style="color:Red;font-weight:600;">Sorry, you have to be a member to post a reply.</div>
                    <br/><a href="signin.php">Sign In</a> Or <a href="signup.php">Sign Up</a> ';
            }
            else
            {
                echo '<form action="reply.php?id='.$row['TopicID'].'" method="post">
            <table frame="none" rules="none" border="0">
                <tr>
                    <td align="right">Your Reply : </td>
                    <td align="left"><textarea name="content" wrap="hard" placeholder="Eg: Reply To Above Posts" onfocus="field_focus(this)" 
                                            onblur="field_blur(this,\'Eg: Reply To Above Posts\')"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><input type="submit" value="&nbsp;Post Reply&nbsp;"/>&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;
                </td>
                </tr>
            </table></form>';
            }    
            //echo '</td></tr></table>';
	}
	}
}

include 'footer.php';
?>