<?php
include 'connect.php';
include 'header.php';

$sql = "SELECT C.CategoryID, C.CategoryName, C.Description, COUNT( T.TopicID ) AS Topics FROM categories C
        LEFT JOIN topics T ON T.Category = C.CategoryID GROUP BY C.CategoryID, C.CategoryName, C.Description";

$result = mysqli_query($conn,$sql);

if(!$result)
{
	echo '<div style="color:Red;font-weight:600;">The categories could not be displayed, please try again later.</div>';
}
else
{
	if(mysqli_num_rows($result) == 0)
	{
		echo '<div style="color:Red;font-weight:600;">No categories defined yet.</div>';
	}
	else
	{
		echo '<table border="1"><tr><th>Category</th><th>Last topic</th></tr>';		
		while($row = mysqli_fetch_assoc($result))
		{				
			echo '<tr>';
			echo '<td class="leftpart">';
			echo '<h3><a href="category.php?id='.$row['CategoryID'].'">'.$row['CategoryName']. '</a></h3>' . $row['Description'];
			echo '</td>';
			echo '<td class="rightpart">';
			$topicsql = "SELECT TopicID,Subject,Date,Category FROM topics
                            WHERE Category = " .$row['CategoryID']. " ORDER BY Date DESC LIMIT 1";								
			$topicsresult = mysqli_query($conn,$topicsql);
			if(!$topicsresult)
			{
                            echo '<div style="color:Red;font-weight:600;">Last topic could not be displayed.</div>';
			}
			else
			{
				if(mysqli_num_rows($topicsresult) == 0)
				{
                                    echo '<div style="color:Red;font-weight:600;">No topics available</div>';
				}
				else
				{
                                    while($topicrow = mysqli_fetch_assoc($topicsresult))
                                    echo '<a href="topic.php?id=' . $topicrow['TopicID'] . '">' . $topicrow['Subject'] . '</a> at ' . date('d-m-Y', strtotime($topicrow['Date']));
				}
			}
			echo '</td>';
			echo '</tr>';
		}
	}
}

include 'footer.php';
?>
