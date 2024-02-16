<?php
    include("inc/dbconn.php");

    $id = $_REQUEST["id"];

    $sql = "SELECT * FROM zone WHERE id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $s = "";
    if($row["status"] == 0)
    {
        $s = 1;
    }
    else
    {
        $s = 0;
    }

    $sql1 = "UPDATE zone SET status='$s' WHERE id='$id'";
    if($conn->query($sql1) === TRUE)
    {
        header("Location: add-zone.php");
    }
?>