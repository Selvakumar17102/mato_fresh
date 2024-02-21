<?php
    include("../inc/dbconn.php");

    // get posted data
    $data = json_decode(file_get_contents('php://input'));

    // make sure data is not empty
    if(!empty($data->mobile_number) && !empty($data->fcm_token)) 
    {
        $phone = $data->mobile_number;
        $fcm = $data->fcm_token;

        $sql = "SELECT * FROM login WHERE phone='$phone'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();

            $id = $row["id"];

            $sql1 = "UPDATE worker SET fcm='$fcm' WHERE lid='$id'";
            if($conn->query($sql1) === TRUE)
            {
                http_response_code(200);
                
                $myObj = new \stdClass();
                $myObj->status = "success";
                $myObj->message = "FCM Token Updated Successfully.";
                $myJSON = json_encode($myObj);
                echo $myJSON;
            }
        }
        else
        {
            http_response_code(200);
                
            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to Update FCM Token. No user detected with this Mobile Number.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to Update FCM Token. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>