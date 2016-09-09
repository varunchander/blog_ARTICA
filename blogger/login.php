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
	header('Location:index.php');
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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
  </head>
<body>
    <div class="container">    
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title">Sign In</div>
                    </div>     
					<div style="padding-top:30px" class="panel-body" >
					<div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                    <form id="loginform" class="form-horizontal" role="form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                                    <?php if(isset($_GET['status'])){echo 'username/pword is incorrect';}?>
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="login-username" type="text" class="form-control" name="uname" value="" placeholder="  username" required>                                        
                                    </div>
                                
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="login-password" type="password" class="form-control" name="pword" placeholder="  password" req>
                                    </div>
                           <div style="margin-top:10px" class="form-group">
                                    <div class="col-sm-12 controls">
							<center><button type="submit" class="btn btn-primary active">LOGIN</button>
							</center>                             
									</div>
                            </div>
					</form>     
					</div>                     
					</div>  
					
        </div>
	   </div> 
    
      

<footer class="container-fluid">
  <center> Welome ! ..... !!!! </center>
</footer>
</body>
</html>
<?php } 
 
?>

