<?php
    include("../inc/dbconn.php");

    // get posted data
    $data = json_decode(file_get_contents('php://input'));

    // make sure data is not empty
    if(!empty($data->name) && !empty($data->mobile_number) && !empty($data->password) && !empty($data->branch_id)) 
    {
        $name = $data->name;
        $phone = $data->mobile_number;
        $pass = $data->password;
        $email = $data->email;
        $branch = $data->branch_id;
		$fcm_token = $data->fcm_token;

        $sql = "SELECT * FROM login WHERE phone='$phone' AND control = '3'";
        $result = $conn->query($sql);
        if($result->num_rows == 0)
        {
            $sql1 = "INSERT INTO login (username,password,phone,control) VALUES ('$name','$pass','$phone','3')";
            if($conn->query($sql1) === TRUE)
            {
                $sql2 = "SELECT * FROM login WHERE phone='$phone' AND control = '3'";
                $result2 = $conn->query($sql2);
                $row2 = $result2->fetch_assoc();

                $id = $row2["id"];

                $sql3 = "INSERT INTO worker (lid,name,email,fcm_token,zone) VALUES ('$id','$name','$email','$fcm_token','$branch')";
                if($conn->query($sql3) === TRUE)
                {
                    http_response_code(200);
            
                    $myObj = new \stdClass();
                    $myObj->status = "success";
                    $myObj->message = "User Successfully SignedUp.";
                    $myJSON = json_encode($myObj);
                    echo $myJSON;
                }
            }
        }
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to SignUp User,Mobile number already exists.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to SignUp. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>