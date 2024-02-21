<?php
    include("../../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->user_id) && !empty($data->order_id) && !empty($data->order_status))
    {
        $user_id = $data->user_id;
        $order_id = $data->order_id;
        $order_status = $data->order_status;

        $sql = "SELECT * FROM order_details WHERE latitude='$user_id' AND orderid='$order_id'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $sql = "UPDATE order_details SET order_status='$order_status' WHERE orderid='$order_id'";
            if($conn->query($sql) === TRUE){
                $myObj = new \stdClass();
                $output_array['status'] = "success";
                $output_array['message'] = "Order found.";
                $myJSON = json_encode($output_array);
                echo $myJSON;
            }
        }
        else
        {
            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "User unable to find Order.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "User unable to login. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>