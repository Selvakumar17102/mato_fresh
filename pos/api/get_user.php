<?php
    include("../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->mobile_number))
    {
        $phone = $data->mobile_number;

        $sql = "SELECT * FROM users WHERE phone='$phone'";
        $result = $conn->query($sql);
        $tem = array();
        $i = 0;
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
        
            $tem["id"] = $row["sno"];
            $tem["name"] = $row["name"];
            $tem["mobile_number"] = $row["phone"];
            $tem["email"] = $row["email"];
            $tem["user_verify"] = $row["verify"];
            $tem["status"] = "success";
            $tem["message"] = "User Found";

            $json = json_encode($tem);
            echo $json;
        }
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "No User Available";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "No User Available.Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>