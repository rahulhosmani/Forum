<?php
include 'connect.php';
include 'header.php';

echo '<h2>Create a category</h2>';
if(!isset($_SESSION['uname']))
{
        echo '<div style="color:Red;font-weight:600;"> Sign in with admin privileges to access this page!</div>';
}
else if(isset($_SESSION['uname']))
{
    if(($level=$_SESSION['level'])!='1')
        echo '<div style="color:Red;font-weight:1 em;"> Sorry, you do not have sufficient rights to access this page.</div>';
    else
    {
        echo '<form action="create_cat.php" method="post">
            <table frame="none" rules="none" border="0">
                <tr>
                    <td align="right">Category-Name : </td>
                    <td align="left"><input name="cat_name" placeholder="Eg: OOPS Concepts" onfocus="field_focus(this)" 
                                            onblur="field_blur(this,\'Eg: OOPS Concepts\')" type="text" /></td>
                </tr>
                <tr>
                    <td align="right">Description : </td>
                    <td align="left"><textarea style="width:45pc;height:10pc;" name="cat_description" wrap="hard" placeholder="Eg: Object Oriented Programkming Paradigm" onfocus="field_focus(this)" 
                                            onblur="field_blur(this,\'Eg: Object Oriented Programkming Paradigm\')"></textarea></td>
                </tr>
                <tr>
                <td colspan="2" align="center"><input type="submit" value="&nbsp;Create Category&nbsp;"/>&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;
                </td>
                </tr>
            </table></form>';
	if(!empty($_POST["cat_name"]) && !empty($_POST["cat_description"]))
	{
            $catName=mysql_real_escape_string($_POST['cat_name']);
            $catDesc=mysql_real_escape_string($_POST['cat_description']);
            $sql = "INSERT INTO categories(CategoryName,Description) VALUES ('$catName','$catDesc')";
	    $result = mysqli_query($conn,$sql);
	    if(!$result)
            {
                echo 'Error :' . mysql_error();
            }
            else
            {
		echo 'New category succesfully added.';
            }
	}
    }
}

include 'footer.php';
?>
