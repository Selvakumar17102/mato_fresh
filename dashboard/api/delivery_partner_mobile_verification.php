<?php
    include("../inc/dbconn.php");
    
    $data = json_decode(file_get_contents('php://input'));

    $phone = $data->mobile_number;
    $verify = $data->mobile_verify;

    $sql = "SELECT * FROM login WHERE phone='$phone'";
    $result = $conn->query($sql);
    if($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();

        $id = $row["id"];

        $sql1 = "UPDATE worker SET verify='$verify' WHERE lid='$id'";
        if($conn->query($sql1) === TRUE)
        {
            if($verify == "true")
            {
                $tem["status"] = "Success";
                $tem["message"] = "Mobile Number successfully verified";

                $json = json_encode($tem);
            }
            else
            {
                $tem["status"] = "Failed";
                $tem["message"] = "OTP failed,Please check your mobile number";

                $json = json_encode($tem);
            }
        }

        echo $json;
        $conn->close();
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to Verify,Mobile number does not exists.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
    
?>