<?php
    include("../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->order_id))
    {
        $oid = $data->order_id;

        $sql = "SELECT * FROM order_details WHERE orderid='$oid'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $sql1 = "UPDATE order_details SET payment_status='failed',order_status='Cancelled' WHERE orderid='$oid'";
            if($conn->query($sql1) === TRUE)
            {
                $myObj = new \stdClass();
                $myObj->status = "success";
                $myObj->message = "Order deleted.";
                $myJSON = json_encode($myObj);
                echo $myJSON;
            }
        }
        else
        {
            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to delete order. Invalid orderid.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to delete order. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>