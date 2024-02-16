<?php
    include("../inc/dbconn.php");

    // get posted data
    $data = json_decode(file_get_contents('php://input'));

    // make sure data is not empty
    if(!empty($data->address_id)) 
    {
        $addr = $data->address_id;

        $sql = "SELECT * FROM user_address WHERE id='$addr'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $sql1 = "DELETE FROM user_address WHERE id='$addr'";
            if($conn->query($sql1) === TRUE)
            {
                http_response_code(200);
                
                $myObj = new \stdClass();
                $myObj->status = "success";
                $myObj->message = "User Address Deleted Successfully.";
                $myJSON = json_encode($myObj);
                echo $myJSON;
            }
            else
            {
                http_response_code(200);
                
                $myObj = new \stdClass();
                $myObj->status = "fail";
                $myObj->message = "User Address Delete failed.";
                $myJSON = json_encode($myObj);
                echo $myJSON;
            }
        }
        else
        {
            http_response_code(200);
                
            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "No User Address found.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to Delete Address. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>