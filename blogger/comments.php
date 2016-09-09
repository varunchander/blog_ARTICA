<html>
<head>
<style>
 img{
    height:300px;
    width:700px;
	margin:10px;
  }
 .navbar{
  background-color: #0288d1;
  height:8px;
  color:red;
}
</style>
 <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
</head>
<body>
<nav class="navbar ">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"> ARTICA </a>
    </div>
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php"> Home </a>
    </div> 
	  <ul class="nav navbar-nav navbar-right">
     <?php
			session_start();
		 if(isset($_SESSION['uname']) || isset($_SESSION['admin'])){
		 echo "<li><a href='login.php'><span class='glyphicon glyphicon-log-in'></span>LogOut</a></li>";
		 }
	?>
    </ul>
  </div>
</nav>

<?php
//if(!$_SESSION['uname']){header('Location:index.php');}
$user = 'root';
$pwd = '';
$db1=mysql_connect('localhost',$user,$pwd) or die('unable to connect to database');
mysql_select_db('blogreg') or die('unable to find db');


if(isset($_GET['blogid'])){
$var = $_GET['blogid'];
$_SESSION['blogid']=$var;
$blgid=$_GET["blogid"];
$query = "select * from blogmaster where blog_id='$blgid'";
$resultset = mysql_query($query) or die ('could not connect'.mysql_error());
$row = mysql_fetch_array($resultset);
if($row["blog_id"]==$blgid ){
	  echo "<div class='col-sm-9'>";
	  echo "<h4>".strtoupper($row["blog_title"])."</h4>";
	  echo "<h6><span class='glyphicon glyphicon-time'></span> "."<span class='label label-success'>".$row["time"]."</span>";
	  echo "<span class='label label-danger' style='padding-left:5px;'> ".$row["blog_category"]."</span> </h6><br>";
	  $query_img = "select * from img where blog_id='$blgid'";
	  $res_img = mysql_query($query_img);
	  $img = mysql_fetch_array($res_img);
	  $img_id = $img['id'];
	  if(!$img_id){ $img_id = 136;}
?>
<img src="img.php?id=<?php echo $img_id ?>" />;
<?php	  
	  echo "<p style='text-indent:50px;'>".$row["blog_description"]."</p>";
	  echo "<hr></div>";
}
else{
	echo 'some error';
}
}



// checking the users permit status
if(isset($_SESSION['uname'])){
		
// for checking permission status for comments update	
$permit_name = $_SESSION['uname'];
$query_permit = "select permit from register where uname = '$permit_name'";
$row_permit = mysql_query($query_permit);
$us = mysql_fetch_array($row_permit);
$status = $us['permit'];

if(isset($_POST['comment'])){
echo $_SESSION['blogid'];
$blogid = $_SESSION['blogid'];
$uname =$_SESSION["uname"];
$comment = $_POST["comment"];
if(! get_magic_quotes_gpc()){
$comment = addslashes($comment);
}
// checking the status to write comments 
if($status){
$comm = "insert into comments(blogid,uname,comment) values('$blogid','$uname','$comment')";	
$result = mysql_query($comm) or die('could not connect to table'.mysql_error());
//header('Location:index.php');
}
header('Location:comments.php?blogid='.$blogid.'');
}
}

?>


<div class="container-fluid">
		<form role="form" method='post' action="<?php if(!isset($_GET["update"])){ echo htmlentities($_SERVER['PHP_SELF']);} else {echo 'update.php?blogid='.$_GET['blogid'] ;} ?>">
	    <label class="control-label col-sm-4" >Comments:</label>
		<div class="form-group">
          <textarea class="form-control" name=<?php if(isset($_GET["update"])){ echo 'update';} if(!isset($_GET["update"]) && isset($_SESSION['uname'])){echo 'comment' ;} ?> rows="4" <?php if(!isset($_SESSION["uname"])){ echo "readonly" ; }  ?> required></textarea>
        </div>
		<?php if(isset($_SESSION["uname"])&& !isset($_GET["update"])){ echo "<button type='submit' class='btn btn-success'>Submit</button>" ; }  ?>
		<?php if(isset($_GET["update"])){ 
		echo "<button type='submit' class='btn btn-success'>Update_Blog</button>" ; 
		} 
		?>
		</form>
      <br><br>
</div>
	
</body>  
</html>
<?php  
// for comments display 
if(!isset($_GET["update"])){
$bgid = $_SESSION["blogid"];
$query_comment = "select * from comments where blogid='$bgid'";
$res = mysql_query($query_comment) or die(mysql_error());
echo "<h5>Comments:</h5><hr>";
while($row =  mysql_fetch_array($res)){
	  echo "<div class='col-sm-10'><h5 style='text-indent:10px;'>";
      echo  $row["uname"]." :</h5>";
      echo  "<p style='text-indent:30px;' >".$row["comment"]."</p><hr></div>";
}
}
?>