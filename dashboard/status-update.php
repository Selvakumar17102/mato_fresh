<?php
    include("inc/dbconn.php");

    $status1 = $_POST["status"];
    $sno = $_POST["sno"];
	$s = 0;
	
	$sql = "SELECT * FROM order_details WHERE sno = '$sno'";
	$retval = mysqli_query($conn,$sql);
	$row = mysqli_fetch_array($retval);
	$fcm_token = $row['fcm_token'];
	$mobile_number = $row['mobile_number'];
	$orderid = $row['orderid'];
	
	$sql2 = "SELECT * FROM users WHERE phone = '$mobile_number'";
	$retval2 = mysqli_query($conn,$sql2);	
	$row2 = $retval2->fetch_assoc();
	$username = $row2['name'];
	
	if($status1 == "Packed")
	{
		$status = "2";
		$s = 1;
	}
	else
	{
		if($status1 == "Dispatched")
		{
			$status = "3";
			$s = 1;
		}
	}
	
	if($s == 1)
	{
		$sql = "UPDATE order_details SET product_id='$status' WHERE sno='$sno'";
	}
	else
	{
		$sql = "UPDATE order_details SET order_status='$status' WHERE sno='$sno'";
	}
    if($conn->query($sql) === TRUE)
    {
        header("Location: dashboard.php?msg=Status Updated!");
		$url = "https://fcm.googleapis.com/fcm/send";
	$token = $fcm_token;
    $sql5 = "SELECT * FROM api_key WHERE id='1'";
	$result5 = $conn->query($sql5);
	$row5 = $result5->fetch_assoc();

	$serverKey = $row5["fcm_token"];
	$title = "Hi ".$username;
    $body = "";
    $linkUrl = $orderid;
	if($status1 != "Packed"){
	$body = "Your Order has been delivered.";
	$image = "https://lapcoffee.com/dashboard/assets/images/orderdelivered.png";
	}
	else{
		$body = "Your Order has been packed.";
		$image = "https://lapcoffee.com/dashboard/assets/images/orderpacked.png";
	}
	$img = $image;
    $notification = array('title' =>$title ,'linkUrl' =>$linkUrl , 'body' => $body, 'image' => $img, 'sound' => 'default', 'badge' => '1', 'status' => $status);
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
    }
?>