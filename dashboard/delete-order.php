<?php
ini_set('display_errors','off');
include("session.php");
include("inc/dbconn.php");
$id = $_REQUEST['id'];
$sql = "SELECT * FROM order_details WHERE sno = '$id'";
$retval = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($retval))
 {
	$orderid = $row['orderid'];
 }
$query1 = "DELETE from order_details WHERE orderid = '$orderid'";
mysqli_query($conn,$query1);
$query2 = "DELETE from recipe_details WHERE orderid = '$orderid'";
mysqli_query($conn,$query2);
header("Location: dashboard.php?msg=Order Deleted!");
?>