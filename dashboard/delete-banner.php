<?php
    include("inc/dbconn.php");

    $id = $_REQUEST["id"];

    $sql = "DELETE FROM banner WHERE id='$id'";
    if($conn->query($sql) === TRUE)
    {
        header("Location: add-banner.php?msg=Banner Deleted!");
    }
?>