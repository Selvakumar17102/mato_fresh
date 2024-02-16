<?php
    include("inc/dbconn.php");

    $id = $_REQUEST["id"];

    $sql1 = "DELETE FROM compo_product WHERE id='$id'";
    if($conn->query($sql1) === TRUE)
    {
        header("Location: compo-product.php?msg=Product Deleted!");

    }
?>