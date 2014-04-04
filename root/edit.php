<?php
include_once("php_include/db_conx.php");
session_start();
mysql_select_db("employee");
$id=$_SESSION['id'];
$username=$_SESSION['username'];
$password=$_SESSION['password'];
$userlevel=$_SESSION['level'];
$sql =mysql_query("SELECT * FROM users WHERE username='$username' LIMIT 1",$db_conx);
$numrows = mysql_num_rows($sql);
if($numrows < 1){
	echo "<script>alert('User doesn't exists')</script>";
	header("location: http://www.koodidojo.com");
	exit();
}
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin - Koodi Systems Web Development Services</title>
<link rel="stylesheet" href="style/style.css">
<?php
	$getid = $_GET['id'];
	mysql_select_db('employee');
	$query = "SELECT * FROM users WHERE id='$getid' LIMIT 1"; //You don't need a ; like you do in SQL
	$result = mysql_query($query,$db_conx);
	$info=mysql_fetch_array($result);
	if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['gender']) && isset($_POST['username']) && isset($_POST['pass1']) && isset($_POST['email'])){
	function update($db_con){
		$iid = $_GET['id'];
		$fname = $_POST['firstname'];
		$lname = $_POST['lastname'];
		$gender = $_POST['gender'];
		$username = $_POST['username'];
		$password = $_POST['pass1'];
		$email = $_POST['email'];
		$role = $_POST['role'];
		if ($gender=="Male") {
			$gender="m";
		} else if($gender=="Female"){
			$gender="f";
		}
		if($fname!="" && $lname!="" && $gender!="" && $username !="" && $password!="" && $email!="" && $role!=""){
			$update_query = "UPDATE users SET firstname='$fname', lastname='$lname', gender='$gender', username='$username', password='$password', email='$email', role='$role' WHERE id='$iid'";
			mysql_query($update_query,$db_con);
			header("location: users.php");
		} else {
			echo "<script>alert ('Please fill out all the fields')</script>";
		}
	}
	update($db_conx);
}
?>
</head>
<body>
	<?php include_once('template_Top.php'); ?>
	<div id="pageMiddle">
		
		<form action="edit.php?id=<?php echo $_GET['id']; ?>" method="post">
			<h4>Edit Account</h4>
			<fieldset>
				<div>
					First Name:<input type="text" id="firstname" name="firstname" style="margin-left:20px;" value="<?php echo $info['firstname']; ?>">
					Last Name:<input type="text" id="lastname" name="lastname" value="<?php echo $info['lastname']; ?>">
					Gender:
					<select id="gender" name="gender" onfocus="emptyElement('status')">
						<option value="m">Male</option>
						<option value="f">Female</option>
					</select>
					Username:<input type="text" id="username" name="username" value="<?php echo $info['username']; ?>">
				</div><br />
				<div>
					Email Address:<input type="text" id="email" name="email" value="<?php echo $info['email']; ?>">
					Password:<input type="password" id="pass1" name="pass1" style="margin-left:7px;" value="<?php echo $info['password']; ?>">
					Role:
					<select id="role" onfocus="emptyElement('status')" name="role" style="margin-left:20px;">
						<option value=""></option>
						<option value="Training">Training</option>
						<option value="Temporary">Temporary</option>
						<option value="Developer">Developer</option>
					</select>
				</div>
				<br /><br />
			</fieldset>
			<center><input type="submit" value="Update" name="loginbtn"></center>
		</form>
		<br /> <br />
	</div>
	<?php include_once('template_pageBottom.php'); ?>
</body>
</html>