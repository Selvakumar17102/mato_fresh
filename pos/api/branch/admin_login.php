<?php
    include("../../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->username) && !empty($data->password))
    {
        $user_name = $data->username;
        $pass = $data->password;
        $fcm = $data->fcm_token;

        $sql = "SELECT * FROM login WHERE username='$user_name' AND password='$pass'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $id = $row['id'];

            $sql1 = "UPDATE login SET fcm='$fcm' WHERE id='$id'";
            if($conn->query($sql1) === TRUE)
            {
                $myObj = new \stdClass();
                $output_array['user_id'] = $row['id'];
                $output_array['status'] = "success";
                $output_array['message'] = "User successfully login.";
                $myJSON = json_encode($output_array);
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