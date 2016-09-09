<?php
session_start();
$user ='root';
$pwd = '';
$db1=mysql_connect('localhost',$user,$pwd) or die('unable to connect to database'.mysql_error());
mysql_select_db('blogreg') or die('unable to find db');
if(isset($_GET['delbg'])){
	$del = $_GET['delbg'];
	$blogdel = "delete from blogmaster where blog_id ='$del'";
	$comdel = "delete from comments where blogid='$del'";
	mysql_query($comdel);
	$val = mysql_query($blogdel);
	if($val){
		echo 'succesfully removed';
		header('Location: index.php');
	}
}
?>
<html lang="en">
<head>
<style>
.navbar{
  background-color: #0288d1;
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
	.navbar{
		height:8px;
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

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
 
  
</head>
<body>

<nav class="navbar ">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" > ARTICA </a>
    </div>
    <ul class="nav navbar-nav">
	<?php
	if(isset($_SESSION["uname"])){
			echo "  <li><a href='bloguser.php'>DASHBOARD</a></li>";
	}
	else{
		 echo "<li><a href='authors.php'>BLOGGERS_INFO</a></li>";
	}
	?>
      <li><a href="contactus.php" target="_self">Contact Us</a></li>
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
  
<div class="container" name="cont">
<?php 

$blogs = "select * from blogmaster order by time DESC";
$result = mysql_query($blogs) or die('could not connect to table'.mysql_error());
if(isset($_SESSION['admin'])){
	echo "<b style='padding-left:15px;'>Welcome Admin</b>";
}
echo "<hr>";
while($row = mysql_fetch_array($result)){
	 
	  echo "<div class='col-sm-11' style='margin:10px;' >";
	  echo "<div class='z-depth-1'>";
	  $bid = $row['blog_id'];
	  $query_img = "select * from img where blog_id='$bid'";
	  $res_img = mysql_query($query_img);
	  $img = mysql_fetch_array($res_img);
	  $img_id = $img['id'];
	  if(!$img_id){ $img_id = 136;}
	  echo "<h5><a href=comments.php?blogid=".$row['blog_id'].">".strtoupper($row["blog_title"])."</a></h5>";
	  echo "<h6><span class='glyphicon glyphicon-time'></span> "."<span class='label label-success'>".$row["time"]."</span>";
	  echo "<span class='label label-danger' style='padding-left:5px;'> ".$row["blog_category"]."</span> </h6>";
	  ?>
	  <img src="img.php?id=<?php echo $img_id ?>" />
	  <?php
	  $des_blog = substr($row["blog_description"],0,200);
	  echo "<p style='text-indent:50px;padding:10px; line-height: 130%;'>".$des_blog."<a href=comments.php?blogid=".$row['blog_id']."> <u>read more</u></a></p>";
	  if(isset($_SESSION["uname"])){
		  echo "<form  class='form-horizontal' role='form' action='comments.php' method='get'>";
		  echo "<div class='form-group'>";
          echo "<div class='col-sm-offset-9 col-sm-10'>";
		  echo "<input type='hidden' name='blogid' value=".$row['blog_id'].">";
          echo "<button type='submit' style='position:relative;' class='btn btn-default'>Comments</button>";
		  echo '</div></div></form>';
		 
	  }
	  if(isset($_SESSION['admin'])){
		  echo "<form  class='form-horizontal' role='form' action='index.php' method='get'>";
		  echo "<div class='form-group'>";
          echo "<div class='col-sm-offset-9 col-sm-10'>";
		  echo "<input type='hidden' name='delbg' value=".$row['blog_id'].">";
          echo "<button type='submit' style='position:relative;' class='btn btn-default'>Delete</button>";
		  echo '</div></div></form>';
	  }
	  echo '<br>';
	  echo "</div>";
	  echo "</div>";
	
}
?>

 </div>
<footer class="container-fluid">
  <center> Welome ! ..... !!!! </center>
</footer>
</body>
</html>

