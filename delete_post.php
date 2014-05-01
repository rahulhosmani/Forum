<?php
include 'connect.php';
include 'header.php';
$postID =mysql_real_escape_string($_GET['id']);
$topicID =mysql_real_escape_string($_GET['tid']);
$page=$_GET['pg'];
if(!isset($_SESSION['uname'])&&!isset($_COOKIE['uname']))
{
	echo '<div style="color:Red;font-weight:600;">Sorry, you have to be a member to delete a post.</div>
            <br/><a href="signin.php">Sign In</a> Or <a href="signup.php">Sign Up</a> ';
}
else
{
    $sql="DELETE FROM posts WHERE PostID='$postID'";
    $result = mysqli_query($conn,$sql);
    if(!$result)
    {
	echo '<div style="color:Red;font-weight:600;">Error while deleting post. Please try again later.</div>';
    }
    else
    {
        echo "<script>window.location='topic.php?id=$topicID&pg=$page';</script>";
    }
}
include 'footer.php';
?>