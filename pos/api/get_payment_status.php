<?php
    include("../inc/dbconn.php");

    $sql1 = "SELECT * FROM payment ORDER BY type ASC";
    $result1 = $conn->query($sql1);
    $tem = array();
    $i = 0;
    while($row1 = $result1->fetch_assoc())
    {
        $tem["Veggis"][$i]["id"] = $row1["id"];
        $tem["Veggis"][$i]["paymnet_type"] = $row1["type"];
        $tem["Veggis"][$i]["payment_status"] = $row1["status"];
            
        $json = json_encode($tem);
        $i++;
    }

    $tem["status"] = "success";
    $tem["message"] = "Payment Status Found";
    $json = json_encode($tem);

    echo $json;
    $conn->close();
?>