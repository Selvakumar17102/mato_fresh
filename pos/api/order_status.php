<?php
    include("../inc/dbconn.php");

    // get posted data
    $data = json_decode(file_get_contents('php://input'));

    // make sure data is not empty
    if(!empty($data->order_id)) 
    {
        $id = $data->order_id;
        $tem = array();

        $sql = "SELECT * FROM order_details WHERE orderid='$id'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();

            $status1 = $row["order_status"];
            $status2 = $row["product_id"];

            $placed = $accepted = $processed = $packed = $dispached = $delivered = "N";
            
            if($status2 == "3")
            {
                $placed = $accepted = $processed = $packed = $dispached = $delivered = "Y";
            }
            else
            {
                if($status2 == "2")
                {
                    $placed = $accepted = $processed = $packed = $dispached = "Y";
                    $delivered = "N";
                }
                else
                {
                    if($status1 == "Dispatched")
                    {
                        $placed = $accepted = $processed = $packed = "Y";
                        $delivered = $dispached = "N";
                    }
                    if($status1 == "Accepted")
                    {
                        $placed = $accepted = $processed = "Y";
                        $delivered = $dispached = $packed = "N";
                    }
                    if($status1 == "Placed")
                    {
                        $placed = "Y";
                        $delivered = $accepted = $dispached = $packed = $processed = "N";
                    }
                }
            }

            $placed = "Y";

            $tem["placed"] = $placed;
            $tem["accepted"] = $accepted;
            $tem["processing"] = $processed;
            $tem["packed"] = $packed;
            $tem["dispatched"] = $dispached;
            $tem["delivered"] = $delivered;
            $tem["status"] = "success";
            $tem["message"] = "Status Found";

            $json = json_encode($tem);

            echo $json;
        }
        else
        {
            http_response_code(503);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to Find Status, Order ID does not exists.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        http_response_code(400);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to Find Status. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }