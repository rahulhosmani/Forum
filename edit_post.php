<?php
include 'connect.php';
include 'header.php';
$postID =mysql_real_escape_string($_GET['id']);
$topicID =mysql_real_escape_string($_GET['tid']);
$page=$_GET['pg'];
$content='';
if(!empty($_POST["content"]))
    $content=$_POST["content"];

echo '<form action="edit_post.php?id='.$postID.'&tid='.$topicID.'" method="post">
            <table frame="none" rules="none" border="0">
                <tr>
                    <td width="20%" align="right">New Reply : </td>
                    <td align="left">
                    <textarea name="content" style="width:45pc;height:7pc;" wrap="hard" placeholder="Eg: Modified Reply!" onfocus="field_focus(this)" 
                                            onblur="field_blur(this,\'Eg: Modified Reply!\')"></textarea>
                    </td>
                </tr>
                <tr><td colspan ="2" align="center"><input type="submit" value="&nbsp;Update&nbsp;"/></tr>
                </table>
                </form>';

if(!isset($_SESSION['uname'])&&!isset($_COOKIE['uname']))
{
	echo '<div style="color:Red;font-weight:600;">Sorry, you have to be a member to edit a post.</div>
            <br/><a href="signin.php">Sign In</a> Or <a href="signup.php">Sign Up</a> ';
}
else if(!empty($content))
{
    //echo $content;
    $sql="UPDATE posts SET Content='$content' WHERE PostID='$postID'";
    $result = mysqli_query($conn,$sql);
    if(!$result)
    {
	echo '<div style="color:Red;font-weight:600;">Error while editing post. Please try again later.</div>';
    }
    else
    {
        echo "<script>window.location='topic.php?id=$topicID&pg=$page';</script>";
    }
}
include 'footer.php';
?>
