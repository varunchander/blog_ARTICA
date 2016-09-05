<?php
session_start();
if(!$_SESSION['uname']){header('Location:b.php');}
if(isset($_SESSION["uname"]) && isset($_POST["update"])){
	$uname = $_SESSION["uname"];
	$desc=$_POST["update"];
	$tablem ='blogmaster';
	
	$user ='root';
	$pwd = '';
	$db1=mysql_connect('localhost',$user,$pwd) or die('unable to connect to database');
	mysql_select_db('blogreg') or die('unable to find db');
	$btime = date("Y-m-d");
	$blogid=$_GET['blogid'];
	$query = "update blogmaster set blog_description='$desc' , time='$btime' where blog_id='$blogid' ";
	$status = mysql_query($query);
	if($status){
		header('Location:bloguser.php');
		echo 'successfull';
	}
	
}

?>