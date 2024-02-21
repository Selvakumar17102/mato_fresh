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
    if(!empty($data->mobile_number) && !empty($data->password))
    {

        $phone = $data->mobile_number;
        $pass = $data->password;

        $sql = "SELECT * FROM users WHERE phone='$phone'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $sql1 = "UPDATE users SET pass='$pass' WHERE phone='$phone'";
        }
        if($conn->query($sql1) === TRUE)
        {
            http_response_code(200);
            
            $myObj = new \stdClass();
            $myObj->status = "success";
            $myObj->message = "User Password Changed.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to change password. Mobile Number not available.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }

?>