<?php
    include("inc/dbconn.php");

    $status = $_GET["status"];
    $sno = $_GET["sno"];

    $sql = "UPDATE order_details SET product_id='$status' WHERE sno='$sno'";
    if($conn->query($sql) === TRUE)
    {
        header("Location: dashboard.php?msg=Status Updated!");
    }
?>