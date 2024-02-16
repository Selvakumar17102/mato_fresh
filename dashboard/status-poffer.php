<?php

    include("inc/dbconn.php");

    $id = $_REQUEST["id"];
    
    $sql = "SELECT * FROM product_offer WHERE id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if($row["status"] == 0)
    {
        $status = 1;
    }
    else
    {
        $status = 0;
    }

    $sql1 = "UPDATE product_offer SET status='$status' WHERE id='$id'";
    if($conn->query($sql1) === TRUE)
    {
        header("Location: product-offer.php?msg=Status Updated!");
    }
?>