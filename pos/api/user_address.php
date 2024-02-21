<?php

    include("../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    // make sure data is not empty
    if(!empty($data->address_name) && !empty($data->mobile_number) && !empty($data->address) && !empty($data->latitude) && !empty($data->longitude))
    {
        $name = $data->address_name;
        $phone = $data->mobile_number;
        $addr = $data->address;
        $fno = $data->floor_no;
        $land = $data->landmark;
        $f = $data->floor;
        $type = $data->address_type;
        $lati = $data->latitude;
        $longi = $data->longitude;

        $sql = "SELECT * FROM user_address WHERE name='$name' AND phone='$phone'";
        $result = $conn->query($sql);
		$row2 = $result->fetch_assoc();
        $s = 0;
        if($result->num_rows > 0)
        {
            $sql1 = "UPDATE user_address SET addr='$addr',floor_no='$fno',land='$land',floor='$f',lati='$lati',longi='$longi',type='$type' WHERE phone='$phone' AND name='$name'";
            $s = 1;
        }
        else
        {
            $sql1 = "INSERT INTO user_address (name,phone,addr,floor_no,land,floor,lati,longi,type) VALUES ('$name','$phone','$addr','$fno','$land','$f','$lati','$longi','$type')";
            $s = 0;
        }
        if($conn->query($sql1) === TRUE)
        {
			$sql2 = "SELECT * FROM user_address WHERE name='$name'";
            $result2 = $conn->query($sql2);
            $row2 = $result2->fetch_assoc();
			
            http_response_code(200);

            $msg = "";
            if($s == 0)
            {
                $msg = "User address added.";
            }
            else
            {
                $msg = "User address Updated.";
            }
            
            $myObj = new \stdClass();
            $myObj->status = "success";
            $myObj->message = $msg;
			$myObj->address_id = $row2["id"];
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to add user address.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to add user address. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }

?>