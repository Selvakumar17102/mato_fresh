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
    if(!empty($data->name) && !empty($data->mobile_number) && !empty($data->password))
    {

        $name = $data->name;
        $phone = $data->mobile_number;
        $email = $data->email;
        $pass = $data->password;
		$fcm_token = $data->fcm_token;

        $sql = "SELECT * FROM users WHERE phone='$phone'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Mobile Number already exists.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
        else
        {
            $sql = "SELECT * FROM users WHERE email='$email'";
            $result = $conn->query($sql);
            if($result->num_rows > 0)
            {
                http_response_code(200);

                $myObj = new \stdClass();
                $myObj->status = "fail";
                $myObj->message = "Email Id already exists.";
                $myJSON = json_encode($myObj);
                echo $myJSON;
            }
            else
            {
                $sql1 = "INSERT INTO users (name,phone,email,pass,fcm_token) VALUES ('$name','$phone','$email','$pass','$fcm_token')";
                if($conn->query($sql1) === TRUE)
                {
                    http_response_code(200);
                    
                    $myObj = new \stdClass();
                    $myObj->status = "success";
                    $myObj->message = "User was created.";
                    $myJSON = json_encode($myObj);
                    echo $myJSON;
                }
            }
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