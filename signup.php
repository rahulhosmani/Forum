<?php
include 'connect.php';
include 'header.php';

echo '<form action="signup.php" method="post">
            <table frame="none" rules="none" border="0">
                <tr>
                    <td align="right">First-Name : </td>
                    <td align="left"><input name="fname" placeholder="Eg: User" onfocus="field_focus(this)" 
                                            onblur="field_blur(this,\'Eg: User\')" type="text" /></td>
                </tr>
                <tr>
                    <td align="right">Last-Name : </td>
                    <td align="left"><input name="lname" placeholder="Eg: Anonymous" onfocus="field_focus(this)" 
                                            onblur="field_blur(this,\'Eg: Anonymous\')" type="text" /></td>
                </tr>
                <tr>
                    <td align="right">User-Name : </td>
                    <td align="left"><input name="uname" placeholder="Eg: username" onfocus="field_focus(this)" 
                                            onblur="field_blur(this,\'Eg: username\')" type="text" /></td>
                </tr>
                <tr>
                    <td align="right">Password : </td>
                    <td align="left"><input name="passwd" placeholder="Eg: password" onfocus="field_focus(this)" 
                                            onblur="field_blur(this,\'Eg: password\')" type="password" /></td>
                </tr>
                <tr>
                    <td align="right">Confirm Password : </td>
                    <td align="left"><input name="confirm" placeholder="Eg: password" onfocus="field_focus(this)" 
                                            onblur="field_blur(this,\'Eg: password\')" type="password" /></td>
                </tr>
                <tr>
                    <td align="right">Type : </td>
                    <td align="left"><select name="level"><option value="0">Regular</option><option value="1">Admin</option></select></td>
                </tr>
                <tr>
                    <td align="right">EMail :</td>
                    <td align="left"><input name="email" placeholder="Eg: abc@xyz.com" onfocus="field_focus(this)" 
                                            onblur="field_blur(this,\'Eg: abc@xyz.com\')" type="text" /></td>
                </tr>
                <tr><td colspan="2" align="center"><input type="submit" value="Register"/></td></tr>
            </table>
        </form>
       <br/>
        ';
        $success = false;
        if (!empty($_POST["uname"]) && !empty($_POST["passwd"]))
        {
			$errors = array(); /* declare the array for later use */
			if(isset($_POST['uname']))
			{
				if(!ctype_alnum($_POST['uname']))
					$errors[] = 'The username can only contain letters and digits.';
				if(strlen($_POST['uname']) > 30)
					$errors[] = 'The username cannot be longer than 30 characters.';
			}
			else
				$errors[] = 'The username field must not be empty.';
			if(isset($_POST['fname']))
			{
				if(!ctype_alpha($_POST['fname']))
					$errors[] = 'The First Name can only contain letters.';
				if(strlen($_POST['fname']) > 30)
					$errors[] = 'The First Name cannot be longer than 30 characters.';
			}
			else
				$errors[] = 'The First Name field must not be empty.';
	
			if(isset($_POST['lname']))
			{
				if(!ctype_alpha($_POST['lname']))
					$errors[] = 'The Last Name can only contain letters.';
				if(strlen($_POST['lname']) > 30)
					$errors[] = 'The Last Name cannot be longer than 30 characters.';
			}
			else
				$errors[] = 'The Last Name field must not be empty.';
			
			if(isset($_POST['passwd']))
			{
				if($_POST['passwd'] != $_POST['confirm'])
					$errors[] = 'The two passwords did not match.';
			}
			else
				$errors[] = 'The password field cannot be empty.';
	
			if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
			{
				echo '<div style="color:Red;font-weight: bold;">A couple of fields are not filled in correctly..<br /><br />';
				echo '<ul>';
				foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
				{
					echo '<li>' . $value . '</li>'; /* this generates a nice error list */
				}
				echo '</ul></div>';
			}
            else   //require("connect.php");
			{	
                $uname = mysql_real_escape_string($_POST["uname"]);
                $fname = mysql_real_escape_string($_POST["fname"]);
                $lname = mysql_real_escape_string($_POST["lname"]);
                $level=mysql_real_escape_string($_POST["level"]);
                $passwd = sha1(mysql_real_escape_string($_POST["passwd"]));
                $email = mysql_real_escape_string($_POST["email"]);
                
                $query = "INSERT INTO users VALUES ('$uname','$fname','$lname','$level','$passwd','$email')";
                $result = mysqli_query($conn, $query);
                if($result)
                    echo '<div style="color:Blue;font-weight: bold;">Registration for User: '.$uname.' was successful!</div><br/><br/>';
                else
                    echo '<div style="color:Red;font-weight: bold;">User: '.$uname.' Already Exists! Try Again ..!!</div><br/><br/>';
			}
        }
        include 'footer.php'
        ?>