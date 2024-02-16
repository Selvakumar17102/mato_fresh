<?php
    include("../inc/dbconn.php");
    
    $data = json_decode(file_get_contents('php://input'));

    $phone = $data->mobile_number;

    $sql = "SELECT * FROM login WHERE phone='$phone'";
    $result = $conn->query($sql);
    if($result->num_rows > 0)
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "success";
        $myObj->message = "OTP Send to Mobile Number";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Mobile number is not register";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
    
?>