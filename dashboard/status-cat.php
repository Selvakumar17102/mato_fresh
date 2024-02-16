<?php

    include("inc/dbconn.php");

    $id = $_REQUEST["id"];
	$status = $_REQUEST["status"];
		
    $sql1 = "UPDATE category SET status='$status' WHERE id='$id'";
    if($conn->query($sql1) === TRUE)
    {
            header("Location: add-category.php?msg=Status Updated!");
        }
?>