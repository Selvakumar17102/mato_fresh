<?php
    include("../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->order_id))
    {
        $oid = $data->order_id;
        $delivery_type = $data->delivery_type;
        $status = "Cash On Delivery";

        $sql = "SELECT * FROM order_details WHERE orderid='$oid'";
        $result = $conn->query($sql);
        $row = mysqli_fetch_array($result);

        $mobile_number = $row['mobile_number'];
        $fcm_token = $row['fcm_token'];
        $tem = array();
        $i = 0;

        if($result->num_rows > 0)
        {
            $sql1 = "UPDATE order_details SET delivery_type='$status' WHERE orderid='$oid'";
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