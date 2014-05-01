<?php
include 'connect.php';
include 'header.php';

echo '<h2>Create a topic</h2>';
if(!isset($_SESSION['uname'])&&!isset($_COOKIE['uname']))
{
	echo '<div style="color:Red;font-weight:600;">Sorry, you have to be a member to create a topic.</div>
            <br/><a href="signin.php">Sign In</a> Or <a href="signup.php">Sign Up</a> ';
}
else
{
    $sql="SELECT CategoryID,CategoryName,Description FROM categories";
    $result = mysqli_query($conn,$sql);
    if(!$result)
    {
	echo '<div style="color:Red;font-weight:600;">Error while retrieving records. Please try again later.</div>';
    }
    else
    {
        if(mysqli_num_rows($result) == 0)
        {
            if(($level=$_SESSION['level'])=='1')
            {
                echo '<div style="color:Red;font-weight:600;">Categories need to be created before posting topics.</div>';
            }
            else
            {
                echo '<div style="color:Red;font-weight:600;">No categories created. Please wait admin to create some before you post.</div>';
            }
         }
         else
         {
             echo '<form action="create_topic.php" method="post">
            <table frame="none" rules="none" border="0">
                <tr>
                    <td align="right">Topic-Subject : </td>
                    <td align="left"><input name="subject" placeholder="Eg: Subject" onfocus="field_focus(this)" 
                                            onblur="field_blur(this,\'Eg: Subject\')" type="text" /></td>
                </tr>
                <tr>
                    <td align="right">Category : </td>
                    <td align="left"><select name="category">';
             while($row = mysqli_fetch_assoc($result))
             {
                 $catID=$row['CategoryID'];
                 $catName=$row['CategoryName'];
                 echo '<option value="'.$catID.'">'.$catName.'</option>';
             }
             echo '</select><br /></td>
                </tr>
                <tr>
                    <td align="right">Post Content : </td>
                    <td align="left"><textarea style="width:45pc;height:10pc;" name="content" wrap="hard" placeholder="Eg: How dynamically create an 2D array?" onfocus="field_focus(this)" 
                                            onblur="field_blur(this,\'Eg: How dynamically create an 2D array?\')"></textarea></td>
                </tr>
                <tr>
                <td colspan="2" align="center"><input type="submit" value="&nbsp;Create Topic&nbsp;"/>&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;
                </td>
                </tr>
            </table></form>';
            }
    }
	if(!empty($_POST["subject"]) && !empty($_POST["content"]))
	{
            $query  = "BEGIN WORK;";
            $result = mysqli_query($conn,$query);
            if(!$result)
            {
		echo '<div style="color:Red;font-weight:600;">An error occured while creating your topic. Please try again later.</div>';
            }
            else
            {
                $subject = mysql_real_escape_string($_POST["subject"]);
                $content = mysql_real_escape_string($_POST["content"]);
                $category = mysql_real_escape_string($_POST["category"]);
                if(isset($_COOKIE['uname']))
                    $author = $_COOKIE['uname'];
                else if(isset($_SESSION['uname']))
                    $author = $_SESSION['uname']; 
                $sql = "INSERT INTO topics(Subject,Date,Category,Author) VALUES('$subject',NOW(),'$category','$author')";
                $result=mysqli_query($conn,$sql);
		if(!$result)
		{
                    echo '<div style="color:Red;font-weight:600;">Database Operation Error: '.mysql_error().'. Try again later.</div>';
                    $sql = "ROLLBACK;";
                    $result=mysqli_query($conn,$sql);
		}
		else
		{
                    $topic = mysqli_insert_id($conn);
                    $sql = "INSERT INTO posts(Content,Date,Topic,Author) VALUES('$content',NOW(),'$topic','$author')";
                    $result=mysqli_query($conn,$sql);
                    if(!$result)
                    {
                        echo '<div style="color:Red;font-weight:600;">Database Operation Error: '.mysql_error().'. Try again later.</div>';
                        $sql = "ROLLBACK;";
                        $result=mysqli_query($conn,$sql);
                    }
                    else
                    {
			$sql = "COMMIT;";
			$result=mysqli_query($conn,$sql);
                        //echo $topic;
			echo '<div style="color:Green;font-weight:600;">You have succesfully created <a href="topic.php?id='.$topic.'">your new topic</a>!</div>';
                        //echo '<a href="topic.php?id='.$topic.'"> your new topic .</a><br />';
                    }
                }
            }
	}
}
include 'footer.php';
?>
