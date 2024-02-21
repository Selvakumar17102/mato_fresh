<?php
    include_once '../inc/dbconn.php';
    include("distance-calculator-n.php");

    $data = json_decode(file_get_contents('php://input'));

    // make sure data is not empty
    if(!empty($data->order_id) && !empty($data->mobile_number) && !empty($data->status))
    {
        $oid = $data->order_id;
        $phone = $data->mobile_number;
        $status = $data->status;
        
        if($status == "Accept")
        {
            $sql = "SELECT * FROM order_details WHERE orderid='$oid' AND (longitude='0' OR longitude IS NULL)";
            $result = $conn->query($sql);
            if($result->num_rows > 0)
            {
                $row = $result->fetch_assoc();

                $hid = $row["latitude"];
                $uid = $row["address"];
                $fcm_token2 = $row["fcm_token"];
                $uphone = $row["mobile_number"];

                $sql6 = "SELECT * FROM users WHERE phone='$uphone'";
                $result6 = $conn->query($sql6);
                $row6 = $result6->fetch_assoc();

                $user = $row6["name"];

                $sql2 = "SELECT * FROM user_address WHERE id='$uid'";
                $result2 = $conn->query($sql2);
                $row2 = $result2->fetch_assoc();

                $lat1 = $row2["lati"];
                $lon1 = $row2["longi"];

                $sql3 = "SELECT * FROM hotel WHERE lid='$hid'";
                $result3 = $conn->query($sql3);
                $row3 = $result3->fetch_assoc();

                $lat2 = $row3["lati"];
                $lon2 = $row3["longi"];

                $sql4 = "SELECT * FROM charges WHERE id='1'";
                $result4 = $conn->query($sql4);
                $row4 = $result4->fetch_assoc();

                $km = round(getDistance($lat1,$lon1,$lat2,$lon2), 2);

                // $cost = $km * $row4["cost"];

                $sql1 = "SELECT * FROM login WHERE phone='$phone' AND control='3'";
                $result1 = $conn->query($sql1);
                if($result1->num_rows > 0)
                {
                    $row1 = $result1->fetch_assoc();
    
                    $lid = $row1["id"];
    
                    $sql2 = "UPDATE order_details SET longitude='$lid',product_id='1',km='$km' WHERE orderid='$oid'";
                    if($conn->query($sql2) === TRUE)
                    {
                        $url = "https://fcm.googleapis.com/fcm/send";
                        $token1 = $fcm_token2;
                        
                        $sql5 = "SELECT * FROM api_key where id = '1'";
                        $result5 = $conn->query($sql5);
                        $row5 = $result5->fetch_assoc();

                        $serverKey1 = $row5['fcm_token'];

                        $title1 = "Hi ".$user;
                        $body1 = "Delivery partner has been assigned to your order.";
                        $linkUrl1 = $oid;
                        $img1 = "https://sevagan.co.in/dashboard/assets/images/Pickup%20Partner%20Assigned.png";
                        $notification1 = array('title' =>$title1 ,'linkUrl' =>$linkUrl1 , 'body' => $body1, 'image' => $img1, 'sound' => 'default', 'badge' => '1','status' => 'processing', 'type' => 'order');
                        $arrayToSend1 = array('to' => $token1, 'data' => $notification1,'priority'=>'high');
                        $json1 = json_encode($arrayToSend1);		
                        $headers1 = array();
                        $headers1[] = 'Content-Type: application/json';
                        $headers1[] = 'Authorization: key='. $serverKey1;
                        $ch1 = curl_init();
                        curl_setopt($ch1, CURLOPT_URL, $url);
                        curl_setopt($ch1, CURLOPT_CUSTOMREQUEST,"POST");
                        curl_setopt($ch1, CURLOPT_POSTFIELDS, $json1);
                        curl_setopt($ch1, CURLOPT_HTTPHEADER,$headers1);
                        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, TRUE);
                        $response1 = curl_exec($ch1);
                        if ($response1 === FALSE)
                        {
                            die('FCM Send Error: ' . curl_error($ch1));
                        }
                        else
                        {
                            $myObj = new \stdClass();
                            $myObj->status = "success";
                            $myObj->message = "Order Accepted!";
                            $myJSON = json_encode($myObj);
                            echo $myJSON;
                        }
                        curl_close($ch1);
                    }
                }
                else
                {
                    http_response_code(200);
    
                    $myObj = new \stdClass();
                    $myObj->status = "fail";
                    $myObj->message = "Cannot detect delivery partner mobile number";
                    $myJSON = json_encode($myObj);
                    echo $myJSON;
                }
            }
            else
            {
                http_response_code(200);
    
                $myObj = new \stdClass();
                $myObj->status = "fail";
                $myObj->message = "Order already accepted!";
                $myJSON = json_encode($myObj);
                echo $myJSON;
            }   
			
		
        }
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to update status. Invalid status.";
            $myJSON = json_encode($myObj);
            echo $myJSON;    
        }
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to update status. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }

?>