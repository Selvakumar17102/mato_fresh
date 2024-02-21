<?php
    include("../inc/dbconn.php");

    // get posted data
    $data = json_decode(file_get_contents('php://input'));

    // make sure data is not empty
    if(!empty($data->username) && !empty($data->password) && !empty($data->fcm)) 
    {
        $user = $data->username;
        $pass = $data->password;
		$fcm  = $data->fcm;

        $sql = "SELECT * FROM login WHERE username='$user' AND password='$pass'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
			$row = $result->fetch_assoc();
			$id = $row['id'];
			
			$sql1 = "UPDATE login SET fcm='$fcm' WHERE id='$id'";
			if($conn->query($sql1) === TRUE)
			{
				http_response_code(200);
			
				$myObj = new \stdClass();
				$myObj->status = "success";
				$myObj->message = "Login Successful.";
				$myJSON = json_encode($myObj);
				echo $myJSON;
            }
            else
            {
                http_response_code(200);

                $myObj = new \stdClass();
                $myObj->status = "fail";
                $myObj->message = "Unable to add fcm.";
                $myJSON = json_encode($myObj);
                echo $myJSON;
            }
		}
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to login, Please check your Username and Password.";
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