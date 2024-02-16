<?php
    include("inc/dbconn.php");

    $id = $_REQUEST["id"];

    $sql = "DELETE FROM product_offer WHERE id='$id'";
    if($conn->query($sql) === TRUE)
    {
        $sql1 = "DELETE FROM offer_product WHERE oid='$id'";
        if($conn->query($sql1) === TRUE)
        {
            header("Location: product-offer.php?msg=Offer Deleted!");
        }
    }
?>