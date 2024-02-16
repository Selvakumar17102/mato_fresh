<?php
    include_once '../inc/dbconn.php';
    date_default_timezone_set("Asia/Calcutta");
    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->mobile_number))
    {
        $phone = $data->mobile_number;
        $fcm = $data->fcm_token;
        $date = date('Y-m-d');

        $sql = "SELECT * FROM users WHERE phone='$phone'";
        $result = $conn->query($sql);
        if($result->num_rows == 0)
        {
            $sql1 = "INSERT INTO users (phone,verify,fcm_token,date) VALUES ('$phone','false','$fcm','$date')";
        }
        else
        {
            $sql1 = "UPDATE users SET fcm_token='$fcm' WHERE phone='$phone'";
        }
        if($conn->query($sql1) === TRUE)
        {
            $myObj = new \stdClass();
            $myObj->status = "success";
            $myObj->message = "Mobile Number available.";
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