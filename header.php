<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">
<head>
 	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 	<meta name="description" content="A short description." />
 	<meta name="keywords" content="put, keywords, here" />
 	<title>Discussion forum</title>
	<link rel="stylesheet" href="style.css" type="text/css">
        <script type="text/javascript">
            function field_focus(field)
            {
                if(field.value.length==0)
                    field.placeholder="";
            }
            function field_blur(field,text)
            {
                if(field.value.length==0)
                    field.placeholder=text;
            }
        </script>
</head>
<body>
<h1>WEBBED MESSENGER BOARD</h1>
	<div id="wrapper">
	<div id="menu">
		<a class="item" href="index.php">Home</a> -
		<a class="item" href="create_topic.php">Create a topic</a> -
		<a class="item" href="create_cat.php">Create a category</a>
		
		<div id="userbar">
        <?php
            $perpage = 5;
            if(isset($_COOKIE['uname']))
             { 
                $uname = $_COOKIE['uname']; 
                $passwd = $_COOKIE['passwd'];
                echo 'Hello <b>, '.$uname.'</b>! Not You?<a class="item" href="signout.php">Sign out</a>';
             }
            else if(isset($_SESSION['uname']))
            { 
                $uname = $_SESSION['uname']; 
                $passwd = $_SESSION['passwd'];
                echo 'Hello <b>, '.$uname.'</b>! Not You?<a class="item" href="signout.php">Sign out</a>';
            }
            else
            {
                echo '<a class="item" href="signin.php">Sign in</a> or <a class="item" href="signup.php">create an account</a>';
            }
	?>
		</div>
	</div>
		<div id="content">