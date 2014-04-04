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
if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['gender']) && isset($_POST['username']) && isset($_POST['pass1']) && isset($_POST['email']) && isset($_POST['role'])){
	function create($db_con){
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
		if($fname!="" && $lname!="" && $gender!="" && $username !="" && $password!="" && $email!=""){
			$update_query = "INSERT INTO users (firstname, lastname, gender, username, password, email, userlevel, role)
							 VALUES ('$fname', '$lname', '$gender', '$username', '$password', '$email', 2, '$role')";
			mysql_query($update_query,$db_con);
			header("location: users.php");
		} else {
			echo "<script>alert ('Please fill out all the fields')</script>";
		}
	}
	create($db_conx);
}
?>
</head>
<body>
	<?php include_once('template_Top.php'); ?>
	<div id="pageMiddle">
		<form action="users.php" method="post">
			<fieldset>
				<br /><br />
				<div>
					First Name:<input type="text" id="firstname" name="firstname" style="margin-left:20px;">
					Last Name:<input type="text" id="lastname" name="lastname">
					Gender:
					<select id="gender" onfocus="emptyElement('status')" name="gender">
						<option value=""></option>
						<option value="m">Male</option>
						<option value="f">Female</option>
					</select>
					Username:<input type="text" id="username" name="username">
				</div><br />
				<div>
					Email Address:<input type="text" id="email" name="email">
					Password:<input type="password" id="pass1" name="pass1" style="margin-left:7px;">
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
			<br />
			<center><input type="submit" name="createbtn" value="Create Account"></center>
		</form>
		<?php
			include_once('php_include/db_conx.php');
			mysql_select_db('employee');
			$query = "SELECT * FROM users WHERE userlevel=2"; //You don't need a ; like you do in SQL
			$result = mysql_query($query,$db_conx);

			echo "<br /><br /><table border='1' style='width:900px;' align='center'>";
			echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Gender</th><th>Username</th><th>Password</th><th>Email</th><th>Role</th></tr>";
			while($row = mysql_fetch_array($result)){
			echo "<tr align='center'><td>" . $row['id'] . "</td><td>" . $row['firstname'] . "</td><td>" . $row['lastname'] . "</td><td>" . $row['gender'] . "</td>
			<td>" . $row['username'] . "</td><td>" . $row['password'] . "</td><td>" . $row['email'] . "</td><td>" . $row['role'] . "</td>";
			echo "<td><span><a href=edit.php?id=".$row['id'].">Edit</a></span><span><a onclick='return confirm(\"Are you sure you want to delete this record\")' href=users.php?action=delete&id=".$row['id'].">Delete</a></span></td>";
			echo "</tr>";
			}

			echo "</table>";

			if(isset($_GET['action']) && isset($_GET['id'])){
				$action = $_GET['action'];
				$getid = $_GET['id'];
				if($action=="delete"){
					mysql_query("DELETE FROM users WHERE id='$getid'");
					header("location: users.php");
					echo "<script>alert('Successfully Deleted');</script>";
				}
			}
			

			mysql_close();
		?>
		<br /> <br />
	</div>
	<?php include_once('template_pageBottom.php'); ?>
</body>
</html>