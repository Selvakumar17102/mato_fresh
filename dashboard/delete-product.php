<?php
    include("inc/dbconn.php");

    $id = $_REQUEST["id"];

    $sql1 = "DELETE FROM price WHERE pid='$id'";
    if($conn->query($sql1) === TRUE)
    {
        $sql = "DELETE FROM product WHERE id='$id'";
        if($conn->query($sql) === TRUE)
        {
            header("Location: add-product.php?msg=Product Deleted!");
        }
    }
?>