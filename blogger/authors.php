<?php
session_start();
$user = 'root';
$pwd = '';
$db1=mysql_connect('localhost',$user,$pwd) or die('unable to connect to database');
mysql_select_db('blogreg') or die('unable to find db');
if(isset($_GET['permit'])){
	$va = $_GET['permit'];
	$query = "select * from register where blogger_id='$va'";
	$exe = mysql_query($query) or die('unable to execute the query');
	$row = mysql_fetch_array($exe);
	if($row['permit']){
		$permission = "update register set permit = 0 where blogger_id ='$va'";
	}
	else{
		$permission = "update register set permit = 1 where blogger_id='$va'";
	}
	$val = mysql_query($permission);
	if($val){
		header('Location:authors.php');
	}
	
}
?>
<html lang="en">
<head>
<style>
.navbar{
  background-color: #0288d1;
 height:8px;
  }
 footer {
	  position:fixed;
	  left:0px;
	  bottom:0px;
	  right:0px;
	  margin-bottom:0px;
      background-color: #0288d1;
      color: white;
      padding: 5px;
	  
    }
</style>
  <title>Bootstrap Case</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
</head>
<body>
<nav class="navbar ">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" > ARTICA </a>
    </div>
	 <div class="navbar-header">
      <a class="navbar-brand" href="b.php"> Home </a>
    </div>
    <ul class="nav navbar-nav">
		<li><a href="contactus.php">Contact Us</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
		
      <?php
		if(isset($_SESSION["uname"]) || isset($_SESSION['admin'])){
			 echo "<li><a href='logout.php'><span class='glyphicon glyphicon-log-out'></span> Logout</a></li>";
		}
		else{
			echo   "<li><a href='blogreg.php'><span class='glyphicon glyphicon-user'></span> Sign Up</a></li>";
		    echo  "<li><a href='login.php'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>";
		}
	  ?>
      
    </ul>
  </div>
</nav>

<?php

if(!isset($_GET["bloggerid"])){
$query = "select * from register";
echo '<table>';
$status = mysql_query($query) or die(mysql_error());
echo "<div class='container' name='cont'>";
while($row =  mysql_fetch_array($status)){
	 echo  "<tr><td><div class='col-sm-9' style='text-indent:30px;'><strong><a href=authors.php?bloggerid=".$row["blogger_id"].">".$row["uname"]."</td></a></strong>";
	 echo "<form  class='form-horizontal' role='form' action='authors.php' method='get'>";
		if(isset($_SESSION['admin'])){
		  echo "<td><div class='form-group'>";
          echo "<div class='col-sm-offset-6 col-sm-10'>";
		  echo "<input type='hidden' name='permit' value=".$row['blogger_id'].">";
		if(!$row['permit']){
		  echo "<button type='submit' style='position:relative;' class='btn btn-default'>NO_PERMIT</button></td>";
		}
		else{
		  echo "<button type='submit' style='position:relative;' class='btn btn-default'>PERMIT</button></td>";
		}
		  echo '</div></div></form></tr>';
		}
	 //last edit
	 echo 	"</div>";
	
}
echo '</div>';
echo '</table>';
}
else{
	$bgi = $_GET["bloggerid"];
$query = "select * from register where blogger_id='$bgi'";
$status = mysql_query($query) or die(mysql_error());
$us = mysql_fetch_array($status);
echo "<div class='container'>";
echo "<h5 style='text-indent:250px;'>PROFILE</h5>";
echo "<table class='table table-hover'><tbody>";
echo "<tr><td>First_Name</td><td>".$us['fname']."</td></tr>";
echo "<tr><td>Last_Name</td><td>".$us["lname"]."</td></tr>";
echo "<tr><td>User_Name</td><td>".$us["uname"]."</td></tr>";
echo "<tr><td>Email_id</td><td>".$us["email"]."</td></tr>";
echo "<tr><td>Blogger_Activation_Time</td><td>".$us["created_date"]."</td></tr>";
echo "</tbody></table></div>";     
}
?>

</body>
</html>