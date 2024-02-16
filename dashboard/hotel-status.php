<?php
ini_set('display_errors','off');
	include("inc/dbconn.php");
	include("api/distance-calculator-n.php");

    $status = $_POST["status"];
    $sno = $_POST["sno"];    
    $s = "";
	
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
	
	if($status == "Accepted")
	{
		$sql = "UPDATE order_details SET order_status='$status',product_id='1' WHERE sno='$sno'";
	}
	else
	{
		$sql = "UPDATE order_details SET order_status='$status' WHERE sno='$sno'";
	}
    if($conn->query($sql) === TRUE)
    {
		if($status == "Accepted")
		{
			$body1 = "Your Order has been Accepted.";
			$image1 = "https://lapcoffee.com/dashboard/assets/images/orderaccepted.png";
			$s = "processing";
		}
		else
		{
			$body1 = "Your Order has been Cancelled.";
			$image1 = "https://lapcoffee.com/dashboard/assets/images/ordercancelled.png";
			$s = "cancelled";
		}
		$url = "https://fcm.googleapis.com/fcm/send";
		$token = $fcm_token2;

		$sql5 = "SELECT * FROM api_key WHERE id='1'";
		$result5 = $conn->query($sql5);
		$row5 = $result5->fetch_assoc();

		$serverKey = $row5["fcm_token"];
		$title = "Hi ".$user;
		$body = $body1;
		$linkUrl = $orderid;
		$image = $image1;
		$notification = array('title' =>$title ,'linkUrl' =>$linkUrl , 'body' => $body, 'image' => $image, 'sound' => 'default', 'badge' => '1', 'status'=> $s, 'type'=>'order');
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

		if($status == "Accepted")
		{
			$sql1 = "SELECT * FROM order_details WHERE sno='$sno'";
			$result1 = $conn->query($sql1);
			$row1 = $result1->fetch_assoc();

			$hotelid = $row1["latitude"];

			$sql2 = "SELECT * FROM hotel WHERE lid='$hotelid'";
			$result2 = $conn->query($sql2);
			$row2 = $result2->fetch_assoc();

			$latitudeTo = $row2["lati"];
			$longitudeTo = $row2["longi"];
			$zone = $row2["zone"];

			$sql3 = "SELECT * FROM worker WHERE status='Online' AND approved='true' AND lati!='' AND zone='$zone'";
			$result3 = $conn->query($sql3);
			if($result3->num_rows > 0)
			{
				$i = 0;
				$nullarray = array();
				while($row3 = $result3->fetch_assoc())
				{
					$id = $row3["lid"];

					$sql5 = "SELECT * FROM login WHERE id='$id'";
					$result5 = $conn->query($sql5);
					if($result5->num_rows > 0)
					{
						$latitudeFrom = $row3["lati"];
						$longitudeFrom = $row3["longi"];

						echo getDistance($latitudeFrom,$longitudeFrom,$latitudeTo,$longitudeTo);
						$nullarray[$id] = getDistance($latitudeFrom,$longitudeFrom,$latitudeTo,$longitudeTo);

						$i++;
					}
				}

				asort($nullarray);
				$i = 0;

				foreach($nullarray as $x => $x_value)
				{
					if($i < 5)
					{
						$sql4 = "SELECT * FROM worker WHERE lid='$x'";
						$result4 = $conn->query($sql4);
						$row4 = $result4->fetch_assoc();

						$username = $row4["name"];

						$token = $row4["fcm_token"];
						$title = "Hi ".$username;
						$body = "New Order has been arrived. Order Id : ".$orderid;
						$linkUrl = $orderid;
						$img = "https://sevagan.co.in/dashboard/assets/images/Order%20placed.png";
						$notification = array('title' =>$title,'linkUrl' =>$orderid,'body' => $body, 'image' => $img, 'sound' => 'default', 'badge' => '1', 'type'=>'order');
						$arrayToSend = array('to' => $token, 'data' => $notification,'priority'=>'high');
						$json = json_encode($arrayToSend);
						
						$headers = array();
						$headers[] = 'Content-Type: application/json';
						$headers[] = 'Authorization: key='. $serverKey;
						$ch1 = curl_init();
						curl_setopt($ch1, CURLOPT_URL, $url);
						curl_setopt($ch1, CURLOPT_CUSTOMREQUEST,"POST");
						curl_setopt($ch1, CURLOPT_POSTFIELDS, $json);
						curl_setopt($ch1, CURLOPT_HTTPHEADER,$headers);
						$response = curl_exec($ch1);
						if ($response === FALSE)
						{
							die('FCM Send Error: ' . curl_error($ch));
						}
						else
						{
								header("Location: dashboard.php?msg=Status Updated!");
						}
						curl_close($ch1);
					}
				}
			}
			curl_close($ch);
		}
		else
		{
				header("Location: dashboard.php?msg=Status Updated!");
		}
    }
?>