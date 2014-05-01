<?php
include 'connect.php';
include 'header.php';
$topicID =mysql_real_escape_string($_GET['id']);
$catID =mysql_real_escape_string($_GET['cid']);
$subject='';
if(!empty($_POST["subject"]))
    $subject=$_POST["subject"];

echo '<form action="edit_topic.php?id='.$topicID.'&cid='.$catID.'" method="post">
            <table frame="none" rules="none" border="0">
                <tr>
                    <td width="20%" align="right">New Subject : </td>
                    <td align="left">
                    <textarea name="subject" style="width:45pc;height:7pc;" wrap="hard" placeholder="Eg: Modified Subject!" onfocus="field_focus(this)" 
                                            onblur="field_blur(this,\'Eg: Modified Subject!\')"></textarea>
                    </td>
                </tr>
                <tr><td colspan ="2" align="center"><input type="submit" value="&nbsp;Update&nbsp;"/></tr>
                </table>
                </form>';

if(!isset($_SESSION['uname'])&&!isset($_COOKIE['uname']))
{
	echo '<div style="color:Red;font-weight:600;">Sorry, you have to be a member to edit a topic.</div>
            <br/><a href="signin.php">Sign In</a> Or <a href="signup.php">Sign Up</a> ';
}
else if(!empty($subject))
{
    //echo $subject;
    $sql="UPDATE topics SET Subject='$subject' WHERE TopicID='$topicID'";
    $result = mysqli_query($conn,$sql);
    if(!$result)
    {
	echo '<div style="color:Red;font-weight:600;">Error while updating topic. Please try again later.</div>';
    }
    else
    {
        echo "<script>window.location='category.php?id=$catID';</script>";
    }
}
include 'footer.php';
?>