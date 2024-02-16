<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // get database connection
    include_once '../inc/dbconn.php';
    // get posted data
    $data = json_decode(file_get_contents('php://input'));

    // make sure data is not empty
    if(!empty($data->name) && !empty($data->mobile_number) && !empty($data->email) &&  !empty($data->password))
    {

        $devname = $data->name;
        $appname = $data->appname;
        $phone = $data->mobile_number;
        $fcm = $data->fcm_token;
        $devmodel = $data->device_model;

        $sql1 = "UPDATE users SET dev_name='$devname',app_name='$appname',dev_model='$devmodel',fcm='$fcm' WHERE phone='$phone'";
        if($conn->query($sql1) === TRUE)
        {
            http_response_code(200);
            
            $myObj = new \stdClass();
            $myObj->status = "success";
            $myObj->message = "Successfully added to your FCM list.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "failed your order.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to create User. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }

?>