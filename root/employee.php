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
<title>Koodi Systems Web Development Services</title>
<link rel="stylesheet" href="style/style.css">
<?php
date_default_timezone_set('Asia/Manila');
$userquery=mysql_query("SELECT * FROM daily WHERE id='$id'", $db_conx);
$count=mysql_num_rows($userquery);
$date = date('Y-m-d');
$loginstyle="";
$logoutstyle="";
$time_out="";
$total="";
$time_in="";
$dquery=mysql_query("SELECT * FROM daily WHERE id='$id' AND date='$date' LIMIT 1", $db_conx);
$farr=mysql_fetch_array($dquery);
if($count>0){
	if($farr['date']!=$date){
		$loginstyle="visibility:visible;";
		$logoutstyle="visibility:hidden;";
	} else if($farr['date']==$date && $farr['clock_in']!="" && $farr['clock_out']!=""){
		$time_in=$farr['clock_in'];
		$time_out=$farr['clock_out'];
		$total=$farr['total_hours'];
		$logoutstyle="visibility:hidden;";
		$loginstyle="visibility:hidden;";
	} else if($farr['date']==$date && $farr['clock_in']!="" && $farr['clock_out']==""){
		$time_in=$farr['clock_in'];
		$time_out=$farr['clock_out'];
		$total=$farr['total_hours'];
		$logoutstyle="visibility:visible;";
		$loginstyle="visibility:hidden;";
	} else if($farr['date']==$date && $farr['clock_in']=="" && $farr['clock_out']==""){
		$time_in=$farr['clock_in'];
		$time_out=$farr['clock_out'];
		$total=$farr['total_hours'];
		$logoutstyle="visibility:hidden;";
		$loginstyle="visibility:visible;";
	} 
} else {
	$loginstyle="visibility:visible;";
	$logoutstyle="visibility:hidden;";
}
if(isset($_POST['login'])){
	$ndate = date('Ymd');
	$login=$_POST['login'];
	$timein=date('H:i');
	$timein_query=mysql_query("INSERT INTO daily (id, date, clock_in) VALUES ('$id', $ndate, '$timein')",$db_conx);
	header("location: employee.php");
}

if(isset($_POST['logout'])){
	$timeout=date('H:i');
	$start = explode(':', $farr['clock_in']);
	$end = explode(':', $timeout);
	$total_mins=$end[1]-$start[1];
	if($total_mins<0){
		$total_hours = $end[0] - $start[0] - 1;
		$total_mins=60+$total_mins;
	} else {
		$total_hours = $end[0] - $start[0];
	}
	$totals=$total_hours.'.'.$total_mins;
	$total_query=mysql_query("UPDATE daily SET clock_out='$timeout', total_hours='$totals' WHERE date='$date' AND id='$id'",$db_conx);
	echo $total_hours .'.'. $total_mins;
	header("location: employee.php");
}
?>
</head>
<body>
	<?php include_once('template_pageTop.php'); ?>
	<div id="pageMiddle">
		<br /><br />
		<center><table style="width:800px;">
			<tr>
				<th>Time In</th>
				<th>Time Out</th>
				<th>Total Work Hours</th>
			</tr>
			<tr align="center">
				<td>
					<label name="timein"><?php echo $time_in; ?></label>
				</td>
				<td>
					<label name="timeout"><?php echo $time_out; ?></label>
				</td>
				<td>
					<label name="total"><?php echo $total; ?></label>
				</td>
			</tr>
		</table></center>
		<br />
		<form action="employee.php" method="post">
			<center>
				<input type="submit" align="middle" name="login" value="Time In" style="<?php echo $loginstyle; ?>">
			</center>
			<center>
				<input type="submit" align="middle" name="logout" value="End of Day" style="<?php echo $logoutstyle; ?>">
			</center>
			<br /><br />
		</form>
		<br /> <br />
	</div>
	<?php include_once('template_pageBottom.php'); ?>
</body>
</html>