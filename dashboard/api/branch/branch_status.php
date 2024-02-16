<?php
    include("../../inc/dbconn.php");

    // get posted data
    $data = json_decode(file_get_contents('php://input'));

    $user_id = $data->user_id;
    $status = $data->status;
    // make sure data is not empty
    if($user_id !="" && $status!="")
    {
        $sql = "SELECT * FROM hotel WHERE lid='$user_id'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
			$row = $result->fetch_assoc();
			$id = $row['id'];
			
			$sql1 = "UPDATE hotel SET res_status='$status' WHERE id='$id'";
			if($conn->query($sql1) === TRUE)
			{
				http_response_code(200);
			
				$myObj = new \stdClass();
				$myObj->status = "success";
				$myObj->message = "Status updated";
				$myJSON = json_encode($myObj);
				echo $myJSON;
            }
            else
            {
                http_response_code(200);

                $myObj = new \stdClass();
                $myObj->status = "fail";
                $myObj->message = "Unable to update.";
                $myJSON = json_encode($myObj);
                echo $myJSON;
            }
		}
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to Update, Please check your Userid.";
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