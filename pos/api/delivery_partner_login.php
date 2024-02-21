<?php
    include("../inc/dbconn.php");

    // get posted data
    $data = json_decode(file_get_contents('php://input'));

    // make sure data is not empty
    if(!empty($data->mobile_number) &&  !empty($data->password)) 
    {
        $phone = $data->mobile_number;
        $pass = $data->password;
		$fcm_token  = $data->fcm_token;

        $sql = "SELECT * FROM login WHERE phone='$phone' AND password='$pass'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
			$row = $result->fetch_assoc();
			$lid = $row['id'];
			
			if($fcm_token != "")
			{
				$sql1 = "UPDATE worker SET fcm_token='$fcm_token' WHERE lid='$lid'";
				if($conn->query($sql1) === TRUE)
				{
					http_response_code(200);
				
					$myObj = new \stdClass();
					$myObj->status = "success";
					$myObj->message = "User Successfully Logged In.";
					$myJSON = json_encode($myObj);
					echo $myJSON;
				}
			}
			else
			{
				http_response_code(200);
				
				$myObj = new \stdClass();
				$myObj->status = "success";
				$myObj->message = "User Successfully Logged In.";
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
        $myObj->message = "Unable to Login. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>