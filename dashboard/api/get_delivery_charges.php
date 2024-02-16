<?php
    include("../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->total_amount))
    {
        $tot = $data->total_amount;

        $sql = "SELECT * FROM charges";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if($result->num_rows > 0)
        {
            $sql1 = "SELECT * FROM delivery WHERE fc<='$tot' AND lc>='$tot'";
            $result1 = $conn->query($sql1);
            $row1 = $result1->fetch_assoc();
            
            $tem["delivery_charge"] = $row1["charge"];
            $tem["packaging_charge"] = $row["package"];
            $tem["minimum_order"] = $row["min"];
            $tem["status"] = "success";
            $tem["message"] = "Charges Found";

            $json = json_encode($tem);
        }
        else
        {
            $tem["delivery_charge"] = 0;
            $tem["packaging_charge"] = 0;
            $tem["minimum_order"] = 0;
            
            $json = json_encode($tem);
        }
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "No Charge Available.Data is Incomplete.";
        $json = json_encode($myObj);
    }
    echo $json;
?>