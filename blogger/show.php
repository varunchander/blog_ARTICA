<?php

$blob_id = $_REQUEST['id']; //gets the request variable from the url that contains the id of the blob that we want to retrieve from the database
mysql_connect('localhost', 'root', '') OR DIE('Unable to connect to database! Please try again later.');
mysql_select_db('blogreg');
$sql = "SELECT * FROM img WHERE id = '$blob_id'";
$result = mysql_query($sql) or exit("QUERY FAILED!");
$row = mysql_fetch_array($result);
$img = $row['imgval'];
header("Content-type: image/jpeg");
header("Content-Disposition: attachment; filename= $blob_name");
if ($_REQUEST['resize'] != "" && $_REQUEST['resize'] != null) { //resizes the images if the url contains
    echo resize($blob_binary, 250, 250);
} else {
    echo $blob_binary;
}

function resize($blob_binary, $desired_width, $desired_height) { // simple function for resizing images to specified dimensions from the request variable in the url
    $im = imagecreatefromstring($blob_binary);
    $new = imagecreatetruecolor($desired_width, $desired_height) ;
    $x = imagesx($im);
    $y = imagesy($im);
    imagecopyresampled($new, $im, 0, 0, 0, 0, $desired_width, $desired_height, $x, $y);
    imagedestroy($im);
    imagejpeg($new, null, 85);
    echo $new;
}

?>