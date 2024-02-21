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
            $hid = $row["latitude"];
            $wid = $row["longitude"];
            $uid = $row["address"];

            $sql1 = "SELECT * FROM hotel WHERE lid='$hid'";
            $result1 = $conn->query($sql1);
            $row1 = $result1->fetch_assoc();

            $sql2 = "SELECT * FROM worker WHERE lid='$wid'";
            $result2 = $conn->query($sql2);
            $row2 = $result2->fetch_assoc();

            $sql3 = "SELECT * FROM login WHERE id='$hid'";
            $result3 = $conn->query($sql3);
            $row3 = $result3->fetch_assoc();

            $sql4 = "SELECT * FROM login WHERE id='$wid'";
            $result4 = $conn->query($sql4);
            $row4 = $result4->fetch_assoc();

            $sql5 = "SELECT * FROM user_address WHERE id='$uid'";
            $result5 = $conn->query($sql5);
            $row5 = $result5->fetch_assoc();

            $phn = $row5["phone"];

            $sql6 = "SELECT * FROM users WHERE phone='$phn'";
            $result6 = $conn->query($sql6);
            $row6 = $result6->fetch_assoc();

            $status = "";
            
            if($status2 == 3)
            {
                $status = "Delivered";
            }
            if($status2 == 2)
            {
                $status = "Picked Up";
            }
            if($status1 == "Closed")
            {
                $status = "Packed";
            }
            if($status1 == "Processing")
            {
                $status = "Processing";
            }
            if($status1 == "Received")
            {
                $status = "Recieved";
            }

            $h["id"] = $row1["lid"];
            $h["name"] = $row1["name"];
            $h["latitude"] = $row1["lati"];
            $h["longitude"] = $row1["longi"];

            $d["id"] = $row2["lid"];
            $d["name"] = $row2["name"];
            $d["phone_no"] = $row4["phone"];
            $d["image"] = $row2["image"];
            $d["latitude"] = $row2["lati"];
            $d["longitude"] = $row2["longi"];
            $d["id"] = $row2["lid"];

            $u["id"] = $uid;
            $u["name"] = $row6["name"];
            $u["latitude"] = $row5["lati"];
            $u["longitude"] = $row5["longi"];

            $tem["order_status"] = $status;
            $tem["branch"] = $h;
            $tem["delivery_person"] = $d;
            $tem["user"] = $u;
            $tem["status"] = "success";
            $tem["message"] = "Status Found";

            $json = json_encode($tem);

            echo $json;
        }
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to Find Status, Order ID does not exists.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to Find Status. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }