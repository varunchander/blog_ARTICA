<?php
session_start();
if(!$_SESSION['uname']){header('Location:index.php');}
if(isset($_SESSION["uname"]) && isset($_POST["description"])){
	$uname = $_SESSION["uname"];
	$desc=$_POST["description"];
	$btitle=$_POST["blogtitle"];
	$bcategory=$_POST["category"];
	$tablem ='blogmaster';
	$table = 'register';
	
	if(!$_POST["category"]){
		echo 'category is to be selected';
	}
	
	$user ='root';
	$pwd = '';
	$table ='register';
	$db1=mysql_connect('localhost',$user,$pwd) or die('unable to connect to database');
	
	mysql_select_db('blogreg') or die('unable to find db');
	$authid = "select * from register where uname='$uname'";
	$status = mysql_query($authid) or die(mysql_error());
	$result = mysql_fetch_array($status);
	$id = $result["blogger_id"];
	
	$btime = date("Y-m-d");
	$blogentry = "insert into $tablem(blogger_id,blog_title,blog_author,blog_category,blog_description,time) values ('$id','$btitle','$uname','$bcategory','$desc','$btime')";
	
	$statusm = mysql_query($blogentry) or die('problem '.mysql_error());
	// inserting an image into db
	$query_bgid = "select blog_id from blogmaster where blog_title ='$btitle'";
	$bgid = mysql_query($query_bgid);
	$bgid = mysql_fetch_array($bgid);
	$bid = $bgid['blog_id'];

if( getimagesize($_FILES["myfile"]["tmp_name"]) != false) {
    $name= addslashes($_FILES['myfile']['name']);
	$image=addslashes($_FILES['myfile']['tmp_name']);
	$image=file_get_contents($image);
	$image=base64_encode($image);
	mysql_connect("localhost","root","");
	mysql_select_db("blogreg");
	$query = "insert into img(name,imgval,id,blog_id) values('$name','$image',0,'$bid')";
	$que=mysql_query($query);
	if($que){echo 'succ';}
	else {echo 'fail';}
}
	
	
	if($statusm){
		header('Location:bloguser.php');
		echo 'sucessfully entered';
	}
	if(! get_magic_quotes_gpc()){
	$desc = addslashes($desc);
	$btitle = addslashes($btitle);
	$bcategory = addslashes($bcategory);
	}
	
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

</style>
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
    
	  <ul class="nav navbar-nav navbar-right">
      <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> LogOut</a></li>
    </ul>
  </div>
</nav>
  
<div class="container" name="cont">
  <form role="form" method="post"  enctype='multipart/form-data' action = "<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" >
	
     <div class="form-group">
      <label class="control-label col-sm-2" >Blog_Title:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" name="blogtitle" placeholder="Blog_Title" required>
      </div>
    </div>
	<br>
	<br>
	<select name="category" required>
		<option value="arts">Arts</option>
		<option value="literature">Literature</option>
		<option value="programming">Programming</option>
	</select>
	<br>
	<br>
      <!-- Standard Select -->
      <div class="mdl-selectfield">
        <label>Standard Select</label>
        <select class="browser-default">
          
          <option value="arts" selected>Arts</option>
          <option value="literature">Literature</option>
          <option value="programming">Programming</option>
        </select>
      </div><br>
    <input type='file' name='myfile' required><br>
	<div class="form-group">
      <label for="comment" >Comment:</label>
      <textarea class="form-control" name="description" rows="5" id="comment" required></textarea>
    </div>
	<div class="form-group">
      <div class="col-sm-offset-5 col-sm-10">
        <button type="submit" name='submit' class="btn btn-default">ADD</button> 
      </div>
    </div>
	
  </form>
</div>

</body>
</html>
<?php } 
?>