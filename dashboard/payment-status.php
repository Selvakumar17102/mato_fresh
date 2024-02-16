<?php

    include("inc/dbconn.php");

    $id = $_REQUEST["id"];
    $status = 0;

    $sql = "SELECT * FROM payment WHERE id='$id'";
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

    $sql1 = "UPDATE payment SET status='$status' WHERE id='$id'";
    if($conn->query($sql1) === TRUE)
    {
        header("Location: payment.php?msg=Status Updated!");
    }

?>