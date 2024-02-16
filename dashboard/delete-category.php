<?php
    include("inc/dbconn.php");

    $id = $_REQUEST["id"];

    $sql = "DELETE FROM category WHERE id='$id'";
    if($conn->query($sql) === TRUE)
    {
        header("Location: add-category.php?msg=Category Deleted!");
    }
?>