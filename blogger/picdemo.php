<?php
if(isset($_POST['submit'])){
  echo 'hello';
  
    if( getimagesize($_FILES["myfile"]["tmp_name"]) != false) {
         
$name= addslashes($_FILES['myfile']['name']);
$image=addslashes($_FILES['myfile']['tmp_name']);
$image=file_get_contents($image);
$image=base64_encode($image);
mysql_connect("localhost","root","");
mysql_select_db("blogreg");
$query = "insert into img(name,imgval,id) values('$name','$image',0)";
$que=mysql_query($query);
if($que){echo 'succ';}
else {echo 'fail';}

    }
}
?>
<html>
<head>

  </head>
<body>
  <form method='post' action='picdemo.php' enctype='multipart/form-data'>
    <input type='file' name='myfile' required><br>
    <input type='submit' name='submit' value='upload'>
    </form>
</body>
</html>