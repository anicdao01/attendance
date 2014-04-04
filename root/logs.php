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
</head>
<body>
	<?php include_once('template_pageTop.php'); ?>
	<div id="pageMiddle">
		<?php
			include_once('php_include/db_conx.php');
			mysql_select_db('employee');
			$query = "SELECT * FROM daily WHERE id='$id'";
			$result = mysql_query($query,$db_conx);

			echo "<br /><br /><table border='1' style='width:700px;' align='center'>";
			echo "<tr><th>Date</th><th>Time In</th><th>Time Out</th><th>Total Hours</th></tr>";
			while($row = mysql_fetch_array($result)){
			echo "<tr align='center'><td>" . $row['date'] . "</td><td>" . $row['clock_in'] . "</td><td>" . $row['clock_out'] . "</td><td>" . $row['total_hours'] . "</td></tr>";
			}
			echo "</table>";

			mysql_close();
		?>
		<br /> <br />
	</div>
	<?php include_once('template_pageBottom.php'); ?>
</body>
</html>