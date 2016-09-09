<?php
session_start();
if(!$_SESSION['uname']){header('Location:index.php');}
if(isset($_POST['addblog'])){
header('Location: blogentry.php');
}
else{	
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
	  img{
    height:300px;
    width:800px;

  }
  h5,h6{
		padding-left:15px;
		padding-top:15px;
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
      <a class="navbar-brand" href="#"> ARTICA </a>
    </div>
    <ul class="nav navbar-nav">
      <li ><a href="index.php" >Home</a></li>
	   <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">TOPICS <span class="caret"></span></a>
	    <ul class="dropdown-menu">
          <li><a href="#">topic-1</a></li>
        </ul>
	  <li><a href="contactus.php">Contact Us</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> LogOut</a></li>
    </ul>
  </div></nav>
<table><tr><td>
 <b style="padding-left:15px;">Welcome <?php echo strtoupper($_SESSION["uname"]); ?></b></td><td> 
<?php 

$uname = $_SESSION["uname"];
if(isset($uname)){
$user ='root';
$pwd = '';
$table ='register';
$db1=mysql_connect('localhost',$user,$pwd) or die('unable to connect to database');
mysql_select_db('blogreg') or die('unable to find db');
$query_permit = "select permit from register where uname = '$uname'";
$row_permit = mysql_query($query_permit);
$us = mysql_fetch_array($row_permit);
$status = $us['permit'];
if($status){
	echo "<div class='container' name='cont'><form role='form' method='post' action=bloguser.php >";
	echo "<div class='form-group'><div class='col-sm-offset-2 col-sm-10'>";
	echo "<button type='submit' name='addblog' style='position:absolute;right:-2px;top:-20px;' value='Add_Blog' class='btn btn-default'>ADD_BLOG</button>";
    echo "</div></div></form></div>";
}
else{
	echo "<div class='alert alert-warning' style='align:right'><a class='close' data-dismiss='alert' aria-label='close'>&times;</a> <strong>NOTIFICATION! </strong>You cannot write and comment on blogs</div>";
}
}
?>
</td></tr></table>
<div class="container" name="cont">
<?php 
if(isset($uname)){
$blogs = "select * from blogmaster where blog_author = '$uname' order by time DESC";
$result = mysql_query($blogs) or die('could not connect to table'.mysql_error());

while($row = mysql_fetch_array($result)){
	  echo "<div class='col-sm-11' style='margin:10px;'>";
	  echo "<div class='z-depth-1'>";
	  echo "<h5>".strtoupper($row["blog_title"])."</h5>";
	  echo "<h6><span class='glyphicon glyphicon-time'></span> "."<span class='label label-success'>".$row["time"]."</span>";
	  echo "<span class='label label-danger' style='padding-left:5px;'> ".$row["blog_category"]."</span> </h6><br>";
	  $bid = $row['blog_id'];
	  $query_img = "select * from img where blog_id='$bid'";
	  $res_img = mysql_query($query_img);
	  $img = mysql_fetch_array($res_img);
	  $img_id = $img['id'];
	  if(!$img_id){ $img_id = 136;}
	  ?>
	  <img src="img.php?id=<?php echo $img_id ?>" />
<?php
		  echo "<p style='text-indent:50px; line-height: 130%;padding:10px;'>".$row["blog_description"]."</p>";
	     if(isset($_SESSION["uname"])){
		  echo "<form  class='form-horizontal' role='form' action='comments.php' method='get'>";
		  echo "<div class='form-group'>";
          echo "<div class='col-sm-offset-7 col-sm-10'>";
		  echo "<input type='hidden' name='blogid' value=".$row['blog_id'].">";
		  echo "<input type='hidden' name='update' value=1>";
          echo "<button type='submit' style='position:relative;' class='btn btn-default'>Update_blog</button>";//update blog form 
		  echo '</div></div></form>';
	  }
	  echo '<br></div> </div>';
	  
}
}

?>
</div>
<footer class="container-fluid">
  <center> Welome ! ..... !!!! </center>
</footer>
</body>
</html>
<?php } 
?>