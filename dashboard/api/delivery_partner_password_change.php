<?php

    include_once '../inc/dbconn.php';

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->mobile_number) && !empty($data->password))
    {
        $phone = $data->mobile_number;
        $pass = $data->password;

        $sql = "SELECT * FROM login WHERE phone='$phone' AND control = '3'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
             $sql1 = "UPDATE login SET password='$pass' WHERE phone='$phone' AND control = '3'";
        }
        if($conn->query($sql1) === TRUE)
        {
            http_response_code(200);
            
            $myObj = new \stdClass();
            $myObj->status = "success";
            $myObj->message = "Delivery Partner Password Changed.";
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