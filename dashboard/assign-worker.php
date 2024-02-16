<?php
    include("inc/dbconn.php");

    $part = $_POST["partner"];
    $sno = $_POST["sno"];
	
    $sql1 = "SELECT * FROM login WHERE id='$part'";
    $result1 = $conn->query($sql1);
    $row1 = $result1->fetch_assoc();
    $phone_number = $row1["phone"];
	$lid = $row1["id"];
	
    $sql2 = "SELECT * FROM order_details WHERE sno = '$sno'";
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();
    $orderid = $row2["orderid"];
	$fcm_token2 = $row2["fcm_token"];
	$mobile_number = $row2['mobile_number'];
	
	$sql4 = "SELECT * FROM users WHERE phone = '$mobile_number'";
	$retval4 = mysqli_query($conn,$sql4);	
	$row4 = $retval4->fetch_assoc();
	$user = $row4['name'];
	
	$sql3 = "SELECT * FROM worker WHERE lid = '$lid'";
    $result3 = $conn->query($sql3);
    $row3 = $result3->fetch_assoc();
	$fcm_token = $row3["fcm_token"];
	$username = $row3["name"];
	
    $sql = "UPDATE order_details SET longitude='$part',product_id='1' WHERE sno='$sno'";
    if($conn->query($sql) === TRUE)
    {
		$url = "https://fcm.googleapis.com/fcm/send";
		$token = $fcm_token;
		$sql5 = "SELECT * FROM api_key WHERE id='1'";
		$result5 = $conn->query($sql5);
		$row5 = $result5->fetch_assoc();

		$serverKey = $row5["fcm_token"];
		$title = "Hi ".$username;
		$body = "New order assigned.";
		$linkUrl = $orderid;
		$img = "https://lapcoffee.com/dashboard/assets/images/orderassigned.png";
		$notification = array('title' =>$title ,'linkUrl' =>$linkUrl , 'body' => $body, 'image' => $img, 'sound' => 'mysound', 'badge' => '1');
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
			$token1 = $fcm_token2;
			$title1 = "Hi ".$user;
			$body1 = "Delivery Partner assigned.";
			$linkUrl1 = $orderid;
			$img1 = "https://lapcoffee.com/dashboard/assets/images/Deliveryboyassigned.png";
			$notification1 = array('title' =>$title1 ,'linkUrl' =>$linkUrl1 , 'body' => $body1, 'image' => $img1, 'sound' => 'default', 'badge' => '1');
			$arrayToSend1 = array('to' => $token1, 'data' => $notification1,'priority'=>'high');
			$json1 = json_encode($arrayToSend1);		
			$headers1 = array();
			$headers1[] = 'Content-Type: application/json';
			$headers1[] = 'Authorization: key='. $serverKey;
			$ch1 = curl_init();
			curl_setopt($ch1, CURLOPT_URL, $url);
			curl_setopt($ch1, CURLOPT_CUSTOMREQUEST,"POST");
			curl_setopt($ch1, CURLOPT_POSTFIELDS, $json1);
			curl_setopt($ch1, CURLOPT_HTTPHEADER,$headers1);
			$response1 = curl_exec($ch1);
			if ($response1 === FALSE)
			{
				die('FCM Send Error: ' . curl_error($ch1));
			}
			else
			{
				header("Location: order.php?msg=Delivery Partner Assigned!");
			}
			curl_close($ch1);
		}
		curl_close($ch);
    }
?>