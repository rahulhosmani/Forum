<?php
include 'connect.php';
include 'header.php';
$uname =mysql_real_escape_string($_GET['uname']);
if(!empty($uname))
{
	$sql="SELECT FirstName,LastName,Level,EMail FROM users WHERE UserName='$uname'";
	$result=mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result);
        $fname=$row['FirstName'];
        $lname=$row['LastName'];
        $email=$row['EMail'];
        if($row['EMail']=='0')
            $type='Regular';
        else
            $type='Admin';
        echo "<center><table border=\"1\">
                <tr>
                    <th align=\"center\">&nbsp;First-Name&nbsp;</td>
                    <th align=\"center\">&nbsp;Last-Name&nbsp;</td>
                    <th align=\"center\">&nbsp;Type&nbsp;</td>
                    <th align=\"center\">&nbsp;E-Mail&nbsp;</td>
                    
                </tr>
                <tr>
                    <td align=\"center\">'$fname'</td>
                    <td align=\"center\">'$lname'</td>
                    <td align=\"center\">'$type'</td>
                    <td align=\"center\">'$email'</td>
                </tr>
            </table></center>
       <br/>";
}
include 'footer.php';
?>

