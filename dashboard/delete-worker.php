<?php

    include("inc/dbconn.php");

    $id = $_REQUEST["id"];

    $sql = "DELETE FROM login WHERE id='$id'";
    if($conn->query($sql) === TRUE)
    {
        $sql1 = "DELETE FROM worker WHERE lid='$id'";
        if($conn->query($sql1) === TRUE)
        {
            header("Location: add-worker.php?msg=Delivery Partner Deleted!");
        }
    }

?>