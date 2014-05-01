<?php
include 'connect.php';
include 'header.php';

if(!isset($_SESSION['uname'])&&!isset($_COOKIE['uname']))
{
    echo '<div style="color:Red;font-weight:600;">You must be signed in to post a reply.</div>';
}
else if (!empty($_POST["content"]))
{
    $content=mysql_real_escape_string($_POST["content"]);
    $topic=mysql_real_escape_string($_GET['id']);
    if(isset($_COOKIE['uname']))
        $author = mysql_real_escape_string($_COOKIE['uname']);
    else if(isset($_SESSION['uname']))
        $author = mysql_real_escape_string($_SESSION['uname']); 
    $sql = "INSERT INTO posts(Content,Date,Topic,Author) VALUES('$content',NOW(),'$topic','$author')";
    $result=mysqli_query($conn,$sql);
    if(!$result)
    {
	echo '<div style="color:Red;font-weight:600;">Your reply has not been saved, please try again later.</div>';
    }
    else
    {
        //echo '<div style="color:Green;font-weight:600;">Your reply has been saved, check out <a color="Red" href="topic.php?id='.$_GET['id'].'">the topic</a>.</div>';
        echo "<script>window.location='topic.php?id=$topic';</script>";
    }
}

include 'footer.php';
?>