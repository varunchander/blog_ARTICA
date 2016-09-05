<?php
mysql_connect("localhost","root","");
mysql_select_db("blogreg");
$id = ($_GET['id']);
$rs = mysql_query("select * from img where id='$id'");
$row = mysql_fetch_array($rs);
$imagebytes = $row['imgval'];
$imagebytes=base64_decode($imagebytes);
header("Content-type: image/jpeg");
echo $imagebytes; 
?>



