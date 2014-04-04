<?php
include_once('php_include/db_conx.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Koodi Systems Wed Development Services</title>
<link rel="stylesheet" href="style/style.css">
<?php

function login(){
	$db_conx = mysql_connect("localhost", "root", "");
	mysql_select_db("employee");
	$username="";
	if(isset($_POST['username'])){ $username = $_POST['username'];}
	if(isset($_POST['pass'])){ $password = $_POST['pass'];}
	if ($username != "" && $password!="") {
		$result=mysql_query("SELECT * FROM users WHERE username='$username' AND password='$password'", $db_conx);
		$count = mysql_num_rows($result);
		$arr=mysql_fetch_array($result);
		if($count==1){
			if($arr[8]==1){
				$_SESSION['id'] = $arr[0];
				$_SESSION['fname']=$arr[1];
				$_SESSION['username'] = $arr[4];
				$_SESSION['password'] = $arr[5];
				$_SESSION['level']=$arr[7];
				header("location: admin.php");
			} else if($arr[8]==2){
				$_SESSION['id'] = $arr[0];
				$_SESSION['fname']=$arr[1];
				$_SESSION['username'] = $arr[4];
				$_SESSION['password'] = $arr[5];
				$_SESSION['level']=$arr[7];
				header("location: employee.php");
			}
		} else if($count==0){
			echo "<script>alert('Invalid Username/Password')</script>";
		}
	} else {
		//echo "<script>alert('Fill out all the data form')</script>";
	}
	
}
login();
?>
</head>
<body>
	<div id="pagein">
		<div id="leftpane">
			<object type="text/html" data="http://www.koodidojo.com/"></object>
		</div>
		<div id="rightpane" width="300px">
			<br /><br /><p><h1><center>Koodi Systems Web Development Services</center></h1></p><br /><br />
			<p><center>A Business Developer Office helps the company improve market positon and achieve financial growth for individual company products.
				You will work with senior level management to define long-term organizational strategic goals, builds key customer relationships, identifies
				business opportunities, negotiates and closes business deals and maintains extensive knowledge of current market conditions.</center></p><br /><br />
			<form action="index.php" method="post">
				<fieldset style="margin-left:100px; width:250px;">
					<h2>Log in here</h2>
					<div>Username: </div>
					<input id="username" name="username" type = "text" style="width:270px;">
					<div>Password: </div>
					<input id="pass" name="pass" type="password" style="width:270px;">
					<br /><br /> 
					<!-- <a href="#">Forgot Your Password?</a> -->
				</fieldset>
				<br />
					<center><input type="submit" value="Log in" name="loginbtn" onclick="login()">
					<input type="reset" value="Reset"></center>
					<br />
			</form>
		</div>
	</div>
</body>
</html>