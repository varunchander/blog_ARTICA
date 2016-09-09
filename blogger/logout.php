<?php
session_start();
if(!$_SESSION['uname']){header('Location:index.php');}
if(isset($_SESSION["uname"]) || isset($_SESSION['admin'])){

	session_destroy();
	$_SESSION=array();
	header('Location:index.php');
}
?>