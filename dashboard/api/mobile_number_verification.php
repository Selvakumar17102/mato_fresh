<?php
    include("../inc/dbconn.php");
    
    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->mobile_number) && !empty($data->mobile_verify))
    {
        $phone = $data->mobile_number;
        $verify = $data->mobile_verify;

        $sql = "UPDATE users SET verify='$verify' WHERE phone='$phone'";
        if($conn->query($sql) === TRUE)
        {
            if($verify == "true")
            {
                $tem["status"] = "success";
                $tem["message"] = "Mobile Number successfully verified";

                $json = json_encode($tem);
            }
            else
            {
                $tem["status"] = "fail";
                $tem["message"] = "OTP failed,Please check your mobile number";

                $json = json_encode($tem);
            }
        }
    }
    else
    {
        $tem["status"] = "fail";
        $tem["message"] = "Data is incomplete.";

        $json = json_encode($tem);
    }

    echo $json;
?>