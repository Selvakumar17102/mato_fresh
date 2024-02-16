<?php
	$url = "https://fcm.googleapis.com/fcm/send";
	$token = "dy2x9KJhRzeat-w-84_Sg9:APA91bG6Lva-muCRkA5NAVsBrd9fs5nEtiIBC_BzZPo8IRZOnT6s1PrVDDBaPNVt6F5Fj7FuuvpA5KVtIJ8ySZiKgFgJi8BhPGrwsb5-uzHqnps1wsUjny-Di7bDIQNgf75fAegB8bv-";
	$sql5 = "SELECT * FROM api_key WHERE id='1'";
	$result5 = $conn->query($sql5);
	$row5 = $result5->fetch_assoc();

	$serverKey = $row5["fcm_token"];
	$title = "Hi ".$username;
	$body = "New order assigned.";
	$linkUrl = $orderid;
	$img = "https://i.pinimg.com/originals/c9/04/28/c904281c7ddbbfacca2b404ac3ab441e.png";
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
	if ($response === FALSE)
	{
		die('FCM Send Error: ' . curl_error($ch));
	}
	curl_close($ch);
?>