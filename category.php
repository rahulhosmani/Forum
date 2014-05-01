<?php
include 'connect.php';
include 'header.php';
$user='';
if(isset($_COOKIE['uname']))
    $user = $_COOKIE['uname'];
else if(isset($_SESSION['uname']))
    $user = $_SESSION['uname'];
$catID =mysql_real_escape_string($_GET['id']);
$sql = "SELECT CategoryID,CategoryName,Description FROM categories WHERE CategoryID=$catID";
$result = mysqli_query($conn,$sql);
if(!$result)
{
    echo '<div style="color:Red;font-weight:600;">The category could not be displayed :'.mysql_error().'.Try Again!</div>';
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
	echo '<div style="color:Red;font-weight:600;">No Such Category!.</div>';
    }
    else
    {
	while($row = mysqli_fetch_assoc($result))
	{
            echo '<h2>Topics in &prime;' . $row['CategoryName'] . '&prime; category</h2><br />';
	}
	$sql = "SELECT	TopicID,Subject,Date,Category,Author FROM topics WHERE Category ='$catID'";
		
	$result = mysqli_query($conn,$sql);
		
	if(!$result)
	{
            echo '<div style="color:Red;font-weight:600;">The topics could not be displayed, please try again later.</div>';
	}
	else
	{
            if(mysqli_num_rows($result) == 0)
            {
		echo '<div style="color:Red;font-weight:600;">There are no topics in this category yet.</div>';
            }
            else
            {
                echo '<table border="1"><tr><th>Topic</th><th>Created at</th></tr>';		
		while($row = mysqli_fetch_assoc($result))
                {				
                    echo '<tr>';
                    echo '<td class="leftpart">';
                    echo '<h3><a href="topic.php?id='.$row['TopicID'].'">'.$row['Subject'].'</a><br /><h3>';
                    echo '</td>';
                    echo '<td class="rightpart">';
                    echo date('d-m-Y', strtotime($row['Date']));
                    if(!empty($user) && ($user==$row['Author']))
                    {
                        echo '<br/><br/>
                            <table>
                            <tr>
                            <td><a href="edit_topic.php?id='.$row['TopicID'].'&cid='.$catID.'">Edit Topic</a></td>
                            <td><a href="delete_topic.php?id='.$row['TopicID'].'&cid='.$catID.'">Delete Topic</a></td>
                            </tr>
                            </table>';
                    }
                    echo '</td>';
                    echo '</tr>';
		}
            }
         }
    }
}

include 'footer.php';
?>
