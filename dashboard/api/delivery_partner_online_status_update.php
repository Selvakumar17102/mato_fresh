<?php
    include("../inc/dbconn.php");

    // get posted data
    $data = json_decode(file_get_contents('php://input'));

    // make sure data is not empty
    if(!empty($data->status) && !empty($data->mobile_number) && !empty($data->latitude) && !empty($data->longitude)) 
    {
        $status = $data->status;
        $phone = $data->mobile_number;
        $lati = $data->latitude;
        $longi = $data->longitude;

        $sql = "SELECT * FROM login WHERE phone='$phone'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();

            $id = $row["id"];
            $sql1 = "UPDATE worker SET status='$status',lati='$lati',longi='$longi' WHERE lid='$id'";
            if($conn->query($sql1) === TRUE)
            {
                http_response_code(200);
            
                $myObj = new \stdClass();
                $myObj->status = "success";
                $myObj->message = "Delivery Partner Status Successfully Updated.";
                $myJSON = json_encode($myObj);
                echo $myJSON;
            }
        }
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to Update Status,Mobile number does not exists.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to Update Status. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }