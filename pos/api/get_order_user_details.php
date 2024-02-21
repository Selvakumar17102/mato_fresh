<?php
    include("../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->order_id))
    {
        $oid = $data->order_id;
        $sql = "SELECT * FROM order_details WHERE orderid='$oid'";
        $result = $conn->query($sql);
        $tem = array();
        $i = 0;
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();

            $phone = $row["mobile_number"];
			$address = $row["address"];
			$bid = $row["latitude"];

            $sql1 = "SELECT * FROM users WHERE phone='$phone'";
            $result1 = $conn->query($sql1);
            $row1 = $result1->fetch_assoc();

            $sql2 = "SELECT * FROM user_address WHERE id='$address'";
            $result2 = $conn->query($sql2);
            $row2 = $result2->fetch_assoc();

            $sql3 = "SELECT * FROM hotel WHERE lid='$bid'";
            $result3 = $conn->query($sql3);
            $row3 = $result3->fetch_assoc();
                
            $tem["Veggis"]["id"] = $row1["sno"];
            $tem["Veggis"]["branch_name"] = $row3["name"];
            $tem["Veggis"]["branch_latitude"] = $row3["lati"];
            $tem["Veggis"]["branch_longitude"] = $row3["longi"];
            $tem["Veggis"]["user_name"] = $row1["name"];
            $tem["Veggis"]["user_mobile"] = $row1["phone"];
            $tem["Veggis"]["user_address"] = $row2["addr"];
            $tem["Veggis"]["user_landmark"] = $row2["land"];
            $tem["Veggis"]["user_latitude"] = $row2["lati"];
            $tem["Veggis"]["user_longitude"] = $row2["longi"];
            $tem["Veggis"]["user_floor_no"] = $row2["floor_no"];
            $tem["Veggis"]["user_floor"] = $row2["floor"];
            $tem["Veggis"]["user_type"] = $row2["type"];

            $tem["status"] = "success";
            $tem["message"] = "Users Found";
            $json = json_encode($tem);

            echo $json;
        }
        else
        {
            http_response_code(503);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to Find Order.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        http_response_code(503);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to Find Order.Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>