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
    if(!empty($data->mobile_number))
    {

        $phone = $data->mobile_number;

        $sql = "SELECT * FROM login WHERE phone='$phone' AND (control = '2' OR control = '1')";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            http_response_code(200);
            
            $myObj = new \stdClass();
            $myObj->status = "success";
            $myObj->message = "Mobile Number available.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Mobile Number not available.";
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