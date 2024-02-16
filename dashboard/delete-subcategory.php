<?php

    include("inc/dbconn.php");
    
    $id = $_REQUEST["id"];

    $sql = "DELETE FROM subcategory WHERE id='$id'";
    if($conn->query($sql) === TRUE)
    {
        header("Location: add-subcategory.php?msg=Sub Category Deleted!");
    }
?>