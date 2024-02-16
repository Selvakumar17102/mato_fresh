<?php
    include("inc/dbconn.php");

    $id = $_REQUEST["id"];

    $sql = "SELECT * FROM compo_product WHERE id='$id'";
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

    $sql1 = "UPDATE compo_product SET status='$s' WHERE id='$id'";
    if($conn->query($sql1) === TRUE)
    {
        header("Location: compo-product.php");
    }
?>