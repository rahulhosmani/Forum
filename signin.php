<?php
include 'connect.php';
include 'header.php';

echo '<h3>Sign in</h3><br />';
if(isset($_COOKIE['uname']))
{ 
    $uname = $_COOKIE['uname']; 
    $passwd = $_COOKIE['passwd'];
    echo '<div style="color:Blue;font-weight: bold;">Welcome, '.$uname.'! Your are Logged-In!</div><br/>Not You?<a class="item" href="signout.php">Sign out</a>';
}
else if(isset($_SESSION['uname']))
{ 
    $uname = $_SESSION['uname']; 
    $passwd = $_SESSION['passwd'];
    echo '<div style="color:Blue;font-weight: bold;">Welcome, '.$uname.'! Your are LoggedIn!</div><br/>Not You?<a class="item" href="signout.php">Sign out</a>';
}
else
{
    echo '<form action="signin.php" method="post">
            <table frame="none" rules="none" border="0">
                <tr>
                    <td align="right">User-Name : </td>
                    <td align="left"><input name="uname" placeholder="Eg: user" onfocus="field_focus(this)" 
                                            onblur="field_blur(this,\'Eg: user\')" type="text" /></td>
                </tr>
                <tr>
                    <td align="right">Password : </td>
                    <td align="left"><input name="passwd" placeholder="Eg: password" onfocus="field_focus(this)" 
                                            onblur="field_blur(this,\'Eg: password\')" type="password" /></td>
                </tr>
                <tr>
                    <td colspan="2" align="center" align="left"><input name="loggedin" type="checkbox" /> Keep Me Logged In
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                <td colspan="2" align="center"><input type="submit" value="&nbsp;Login&nbsp;"/>&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
                </tr>
            </table></form>';
}
if (!empty($_POST["uname"]) && !empty($_POST["passwd"])) 
{
    $uname = mysql_real_escape_string($_POST["uname"]);
    $passwd = sha1(mysql_real_escape_string($_POST["passwd"]));
    if(isset($_POST['loggedin']))
        $keepme=1;
    else
        $keepme=0;
    $query = "SELECT COUNT(*) as `rowcount`,Level FROM users WHERE UserName='$uname' AND Passwd='$passwd'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    if ($row["rowcount"]!=0)
    {
        $_SESSION['uname']=$uname;
        $_SESSION['passwd']=$passwd;
        $_SESSION['level']=$row["Level"];
        if($keepme)
        {
            setcookie("uname", $uname, time()+3600);
            setcookie("passwd",$passwd, time()+3600);
        }
        echo "<script>window.location='signin.php';</script>";
        echo '<div style="color:Blue;font-weight: bold;">Welcome, '.$uname.'! Your login was successful!</div><br/><br/>';
    }                   
    else
    {
        echo '<div style="color:Red;font-weight: bold;">Invalid UserName Or Password! Try Again ..!!</div><br/><br/>';
    }
}
else if(empty($_POST["uname"]) && !empty($_POST["passwd"])||!empty($_POST["uname"]) && empty($_POST["passwd"]))
	echo '<div style="color:Red;font-weight: bold;">Both the fields are required!</div>';

include 'footer.php';
?>