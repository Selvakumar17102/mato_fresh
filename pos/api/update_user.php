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
    if(!empty($data->name) && !empty($data->mobile_number) && !empty($data->email))
    {
        $name = $data->name;
        $phone = $data->mobile_number;
        $email = $data->email;

        $sql = "SELECT * FROM users WHERE phone='$phone'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $sql1 = "UPDATE users SET name='$name',email='$email' WHERE phone='$phone'";
            if($conn->query($sql1) === TRUE)
            {
                $myObj = new \stdClass();
                $myObj->status = "success";
                $myObj->message = "User details updated.";
                $myJSON = json_encode($myObj);
                echo $myJSON;
            }
        }
        else
        {
            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to update user details. Mobile Number not available.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to create User. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }

?>