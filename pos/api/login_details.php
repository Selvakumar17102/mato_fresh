<?php
    include("../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->mobile_number) && !empty($data->password))
    {
        $phone = $data->mobile_number;
        $pass = $data->password;
        $fcm = $data->fcm_token;

        $sql = "SELECT * FROM users WHERE phone='$phone' AND pass='$pass'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $sql1 = "UPDATE users SET fcm_token='$fcm' WHERE phone='$phone' AND pass='$pass'";
            if($conn->query($sql1) === TRUE)
            {
                $myObj = new \stdClass();
                $myObj->status = "success";
                $myObj->message = "User successfully login.";
                $myJSON = json_encode($myObj);
                echo $myJSON;   
            }
        }
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "User unable to login, Please check your mobile number and password.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "User unable to login. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>