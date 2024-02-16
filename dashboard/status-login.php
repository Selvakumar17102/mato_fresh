<?php

    include("inc/dbconn.php");

    $id = $_REQUEST["id"];
    $m = $_REQUEST["m"];
    $status = "";

    $sql = "SELECT * FROM login WHERE id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
	$lid = $row["id"];
	
    if($row["status"] == 0)
    {
        $status = 1;
		$approved = "false";
		$msg = "deactivated.";
		$image = "https://lapcoffee.com/dashboard/assets/images/AccountDeactivated.png";
    }
    else
    {
        $status = 0;
		$approved = "true";
		$msg = "activated.";
		$image = "https://lapcoffee.com/dashboard/assets/images/AccountActivated.png";
    }
		
    $sql1 = "UPDATE login SET status='$status' WHERE id='$id'";
    if($conn->query($sql1) === TRUE)
    {
        if($m == 1)
        {
            header("Location: add-hotel.php");
        }
        else
        {
            if($m == 2)
            {
                $sql3 = "SELECT * FROM worker WHERE lid = '$lid'";
                $result3 = $conn->query($sql3);
                $row3 = $result3->fetch_assoc();

                $fcm_token = $row3["fcm_token"];
                $username = $row3["name"];
                
                $sql2 = "UPDATE worker SET approved = '$approved' WHERE lid='$lid'";
                $result2 = $conn->query($sql2);
                
                $url = "https://fcm.googleapis.com/fcm/send";
                $token = $fcm_token;
                $sql5 = "SELECT * FROM api_key WHERE id='1'";
                $result5 = $conn->query($sql5);
                $row5 = $result5->fetch_assoc();

                $serverKey = $row5["fcm_token"];
                $title = "Hi ".$username;
                $body = "Your account has been ".$msg;
                $linkUrl = $orderid;
                $img = $image;
                $notification = array('title' =>$title ,'linkUrl' =>$linkUrl , 'body' => $body, 'image' => $img, 'sound' => 'default', 'badge' => '1');
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
                if ($response === FALSE) {
                die('FCM Send Error: ' . curl_error($ch));
                }
                curl_close($ch);
                header("Location: add-worker.php");
            }
            else
            {
                header("Location: add-admin.php");
            }
        }
    }
?>