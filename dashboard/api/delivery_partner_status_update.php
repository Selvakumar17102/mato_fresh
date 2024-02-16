<?php
    include("../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->mobile_number) && !empty($data->order_status)) 
    {
        $phone = $data->mobile_number;
        $oid = $data->order_id;
        $os = $data->order_status;
		
        $sql = "SELECT * FROM order_details WHERE orderid = '$oid'";
        $retval = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($retval);

        $fcm_token = $row['fcm_token'];
        $mobile_number = $row['mobile_number'];
        
        $sql2 = "SELECT * FROM users WHERE phone = '$mobile_number'";
        $retval2 = mysqli_query($conn,$sql2);	
        $row2 = $retval2->fetch_assoc();
        $username = $row2['name'];
	
        $status = "0";

        if($os == "Dispatched")
        {
            $status = 2;
        }
        if($os == "Delivered")
        {
            $status = 3;
        }

        $sql = "SELECT * FROM login WHERE phone='$phone' ";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();

            $id = $row["id"];

            $sql1 = "UPDATE order_details SET product_id='$status' WHERE orderid='$oid'";
            if($conn->query($sql1) === TRUE)
            {
				$url = "https://fcm.googleapis.com/fcm/send";
                $token = $fcm_token;

                $sql5 = "SELECT * FROM api_key WHERE id='1'";
                $result5 = $conn->query($sql5);
                $row5 = $result5->fetch_assoc();

                $serverKey = $row5["fcm_token"];
                
                $title = "Hi ".$username;
                if($status == '2')
                {
                    $body = "Your Order has been Picked Up.";
                    $image = "https://lapcoffee.com/dashboard/assets/images/orderpickedup.png";
                }
                else
                {
                    $body = "Your Order has been Delivered.";
                    $image = "https://lapcoffee.com/dashboard/assets/images/orderdelivered.png";
                }
                $linkUrl = $oid;
                $img = $image;
                $notification = array('title' =>$title ,'linkUrl' =>$linkUrl , 'body' => $body, 'image' => $img, 'sound' => 'default', 'badge' => '1', 'status' => 'processing');
                $arrayToSend = array('to' => $token, 'data' => $notification,'priority'=>'high');
                $json = json_encode($arrayToSend);
                
                $headers = array();
                $headers[] = 'Content-Type: application/json';
                $headers[] = 'Authorization: key='. $serverKey;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
                $response = curl_exec($ch);
                if ($response === FALSE)
                {
                    die('FCM Send Error: ' . curl_error($ch));
                }
                else
                {
                    http_response_code(200);
                
                    $myObj = new \stdClass();
                    $myObj->status = "success";
                    $myObj->message = "Status Updated Successfully.";
                    $myJSON = json_encode($myObj);
                    echo $myJSON;
                }
                curl_close($ch);
            }
        }
        else
        {
            http_response_code(200);
                
            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to Update status. No user detected with this Mobile Number.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to Update status. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>