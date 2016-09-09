<?php

if(isset($_POST['uname'])){
$user ='root';
$pwd = '';
$table ='register';
$db1=mysql_connect('localhost',$user,$pwd) or die('unable to connect to database');

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$uname = $_POST['uname'];
$pword = $_POST['pword'];
$var = $_POST['uname'];

if(! get_magic_quotes_gpc()){
$fname = addslashes($fname);
$lname = addslashes($lname);
$email = addslashes($email);
$uname = addslashes($uname);
$pword = addslashes($pword);	
}
mysql_select_db('blogreg') or die('unable to find db');
$user_Check = "select * from $table where uname = '$uname'";
$reg_time = date("Y-m-d");
$sql = "INSERT INTO $table(fname,lname,email,uname,pword,created_date) VALUES('$fname','$lname','$email','$uname','$pword','$reg_time')";
$user_Check_Status = mysql_query($user_Check) or die('could not connect to table'.mysql_error());
$val = count($user_Check_Status);
echo $val;
$us = mysql_fetch_array($user_Check_Status);
echo $us['uname'];
if(($uname ==  'zzz') || ($var == $us['uname']))
{
	echo "the user with this name already exists".$uname;
	echo "<br>".$us;
	header('Location: blogreg.php?repeat_name=1');
}	
else{
	
$status = mysql_query($sql) or die(mysql_error());
if(! $status){
	die('could not enter the data '.mysql_error());
}
header("Location: login.php");

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
      padding: 5px;
    }
</style>
</head>
<body>

<div class="container">
<br>
    <center><h4><label class="control-label " >REGISTRATION FORM</label></h4></center>
  <br><br>
  <form class="form-horizontal" role="form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
    
	<div class="form-group">
      <label class="control-label col-sm-4" >FirstName:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control"  name="fname" placeholder="first name" required>
      </div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-4">LastName:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control"  name="lname" placeholder="Last Name" required>
      </div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-4" >Email:</label>
      <div class="col-sm-4">
        <input type="email" class="form-control" name="email" placeholder="email" required>
      </div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-4" >UserName:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" name="uname" placeholder="user name" required>
      </div>
	  <?php 
	  if(isset($_GET['repeat_name'])){
	      echo '<center><p style=color:red>*username already exists</p></center>';
        }
	  ?>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-4" for="pwd">Password:</label>
      <div class="col-sm-4">
        <input type="password" class="form-control" name="pword" placeholder="Enter password" required>
      </div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-4" for="pwd">Confirm Password:</label>
      <div class="col-sm-4">
        <input type="password" class="form-control" name="cpword" placeholder="Confirm password" required>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-4 col-sm-10">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
  </form>
 
</div>
<footer class="container-fluid">
  <center> Welome ! ..... !!!! </center>
</footer>
</body>
</html>
<?php } ?>

