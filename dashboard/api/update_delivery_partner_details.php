<?php
ini_set('display_errors','off');
    include("../inc/dbconn.php");

    // get posted data
    $data = json_decode(file_get_contents('php://input'));

    // make sure data is not empty
    if(!empty($data->name) && !empty($data->mobile_number)) 
    {
        $name = $data->name;
        $phone = $data->mobile_number;
        $address = $data->address;
        $email = $data->email;
        $gender = $data->gender;
        $dob = date('Y-m-d',strtotime($data->date_of_birth));
        $vname = $data->vehicle_name;
        $vnum = $data->vehicle_number;
        $am = $data->alternatemobile;
        $bg = $data->bloodgroup;

        $sql = "SELECT * FROM login WHERE phone='$phone'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();

            $id = $row["id"];
            $sql1 = "UPDATE worker SET addr='$address',alternatemobile='$am',bloodgroup='$bg',name='$name',email='$email',gender='$gender',dob='$dob',v_name='$vname',v_num='$vnum' WHERE lid='$id'";
            if($conn->query($sql1) === TRUE)
            {
                
                http_response_code(200);
            
                $myObj = new \stdClass();
                $myObj->status = "success";
                $myObj->message = "Delivery Partner Successfully Updated.";
                $myJSON = json_encode($myObj);
                echo $myJSON;
            }
			
        }
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to Update User,Mobile number does not exists.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
		
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to Update. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }