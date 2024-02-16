<?php
    include("inc/dbconn.php");

    $id = $_REQUEST["id"];

    $sql = "SELECT * FROM offer_product WHERE id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $oid = $row["oid"];

    $sql1 = "DELETE FROM offer_product WHERE id='$id'";
    if($conn->query($sql1) === TRUE)
    {
        header("Location: offer-product.php?id=$oid&msg=Product Deleted!");
    }
?>