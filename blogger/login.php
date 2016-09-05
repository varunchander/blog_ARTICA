<?php
if(isset($_POST['uname'])){
$uname = $_POST['uname']; 
$pword = $_POST['pword'];
$admin = 'zzz';
$pass = 'zzz';
$user = 'root';
$pwd = '';
$table = 'register';
$db1=mysql_connect('localhost',$user,$pwd) or die('unable to connect to database');
mysql_select_db('blogreg') or die('unable to find db');
if(! get_magic_quotes_gpc()){
$uname = addslashes($uname);
$pword = addslashes($pword);	
}
$query = "select * from $table where uname='$uname' and pword='$pword'";
$status = mysql_query($query) or die(mysql_error());
$us = mysql_fetch_array($status);
session_start();
if($us["uname"] == $uname )
{
	$_SESSION["uname"]=$uname;
	header("Location:bloguser.php");
	echo "Sucessfully logged in ";
	
}
else if ($admin == $uname && $pass == $pword){
	$_SESSION["admin"]=$admin;
	header('Location:b.php');
}
else {
	header('Location:login.php?status=1');
	echo "some problem".mysql_error();
}
}
else{
?>
<html>
<head>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  
 
<style>
  footer {
	  position:absolute;
	  bottom:0px;
	  width:100%;
      background-color:  #0288d1;
      color: white;
      
	  padding:5px;
    }
</style>
  </head>
<body>
<div class="container">
<div class='z-depth-1'>
<br><br>
   <center><h4><label class="control-label " >LOGIN PORTAL</label></h4></center>
  <?php if(isset($_GET['status'])){ echo "<p style='color:red;text-indent:290px;'>username/password is incorrect</p>"; }else{echo '<br>';} ?>
  
  <form  class="form-horizontal" role="form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
    <div class="form-group">
      <label class="control-label col-sm-4" >UserName:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" name="uname" placeholder="user name" required>
      </div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-4" for="pwd">Password:</label>
      <div class="col-sm-4">
        <input type="password" class="form-control" name="pword" placeholder="Enter password" required>
      </div>
    </div>
	
    <div class="form-group">
      <div class="col-sm-offset-6 col-sm-10">
        <button type="submit" class="btn btn-primary active">LOGIN</button>
      </div>
    </div>
	
  </form>
</div>
</div>
<footer class="container-fluid">
  <center> Welome ! ..... !!!! </center>
</footer>
</body>
</html>
<?php } 
 
?>

