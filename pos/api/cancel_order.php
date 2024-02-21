<?php
    include("../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    $status = $data->order_status;
    $oid = $data->order_id;

    if($oid != "" && $status != "")
    {
        $sql = "SELECT * FROM order_details WHERE orderid='$oid'";
        $result = $conn->query($sql);
        $tem = array();
        $i = 0;
        if($result->num_rows > 0)
        {
            $sql1 = "UPDATE order_details SET order_status='$status',product_id='0' WHERE orderid='$oid'";
            if($conn->query($sql1) === TRUE)
            {
                http_response_code(200);

                $myObj = new \stdClass();
                $myObj->status = "success";
                $myObj->message = "Order status updated.";
                $myJSON = json_encode($myObj);
                echo $myJSON;
            }
        }
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to Find Order.Order id is not available";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to Find Order.Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>