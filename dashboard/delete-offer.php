<?php
    include("inc/dbconn.php");

    $id = $_REQUEST["id"];

    $sql = "DELETE FROM offers WHERE id='$id'";
    if($conn->query($sql) === TRUE)
    {
        header("Location: add-offer.php?msg=Offer Deleted!");
    }
?>