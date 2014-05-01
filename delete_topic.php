<?php
include 'connect.php';
include 'header.php';
$topicID =mysql_real_escape_string($_GET['id']);
$catID =mysql_real_escape_string($_GET['cid']);
if(!isset($_SESSION['uname'])&&!isset($_COOKIE['uname']))
{
	echo '<div style="color:Red;font-weight:600;">Sorry, you have to be a member to delete a topic.</div>
            <br/><a href="signin.php">Sign In</a> Or <a href="signup.php">Sign Up</a> ';
}
else
{
    $sql="DELETE FROM topics WHERE TopicID='$topicID'";
    $result = mysqli_query($conn,$sql);
    if(!$result)
    {
	echo '<div style="color:Red;font-weight:600;">Error while deleting topic. Please try again later.</div>';
    }
    else
    {
        echo "<script>window.location='category.php?id=$catID';</script>";
    }
}
include 'footer.php';
?>