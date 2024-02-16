<?php
	include("../inc/dbconn.php");

	$data = json_decode(file_get_contents("php://input"));

	if( !empty($data->orderid) && !empty($data->payment_status))
	{
		$orderid = $data->orderid;
		$payment_status = $data->payment_status;
		
		$sql1 = "UPDATE order_details SET payment_status='$payment_status' WHERE orderid='$orderid'";
		if($conn->query($sql1) === TRUE)
		{
			$myObj = new \stdClass();
			$myObj->status = "success";
			$msg = "Successful Payment Status Updated.";
			$msg = urlencode($msg);
			$myObj->message = $msg;
			$myJSON = json_encode($myObj);
			echo $myJSON;
			
			http_response_code(201);

			$sql = "SELECT * FROM order_details WHERE orderid = '$orderid' AND payment_status != 'Pending' AND payment_status != 'Fail' AND payment_status != '' AND payment_status != 'Failed' AND payment_status != ''";
			$retval = mysqli_query($conn,$sql);
			while($row = mysqli_fetch_array($retval))
			{
				$orderid = $row['orderid'];
				$address1 = $row['address'];
				$booking_date = $row['booking_date'];
				$booking_time = $row['booking_time'];
				$delivery_charge = number_format($row['delivery_charge'],2);
				$packing_charge = number_format($row['packing_charge'],2);
				$delivery_type = $row['delivery_type'];
				$delivery_date = $row['delivery_date'];
				$delivery_time = $row['delivery_time'];
				//$email = $row['email'];
				$landmark = $row['landmark'];
				$mobile_number = $row['mobile_number'];
				$overall_total_amount = number_format($row['overall_total_amount'],2);
				$recipe_total_amount = number_format($row['recipe_total_amount'],2);
				$order_status = $row['order_status'];
				$payment_status = $row['payment_status'];
				$fcm_token = $row['fcm_token'];
				$coupon = $row['coupon'];
				$redeem_point = $row['redeem_point'];
				$resid = $row["latitude"];
				
				$amount = "";
				
				if($coupon != 0)
				{
					$amount = $coupon;
				}
				else
				{
					if($redeem_point != 0)
					{
						$amount = $redeem_point;
					}
					else
					{
						$amount = 0;
					}
				}
					
				$sql2 = "SELECT * FROM users WHERE phone = '$mobile_number'";
				$retval2 = mysqli_query($conn,$sql2);	
				$row2 = $retval2->fetch_assoc();
				$username = $row2['name'];
				$email = $row2['email'];

				$sql3 = "SELECT * FROM user_address WHERE id = '$address1'";
				$retval3 = mysqli_query($conn,$sql3);	
				$row3 = $retval3->fetch_assoc();
				$address = $row3['addr'];
						
				$sql1 = "SELECT * FROM recipe_details WHERE orderid = '$orderid'";
				$retval1 = mysqli_query($conn,$sql1);

				$to = $email;
				$Bcc = 'dev@gtechwebsolutions.com,appsarasan@gmail.com,aswinbalaji94@gmail.com'; 
				$from = 'noreply@veggis.in'; 
				$fromName = 'Veggis'; 
				
				$subject = "New order $username - $orderid ($booking_date, $booking_time) - $payment_status"; 
				
				$htmlContent = " 
				<html> 
				<head> 
				<title>Welcome to Veggis</title> 
				</head> 
				<body style='background: #F7F7F7;'> 
				<table border='0' cellpadding='0' cellspacing='0' width='600px' style='background-color:#ffffff;border:1px solid #dedede;border-radius:3px!important;margin: 35px auto;'>
				<tbody>
				<center><img src='https://veggis.in/dashboard/assets/images/logo.png' style='margin-top: 20px;'></center>
				<tr>
				<td align='center' valign='top'>
				<table border='0' cellpadding='0' cellspacing='0' width='100%' style='background-color:#43188E;border-radius:3px 3px 0 0!important;color:#ffffff;border-bottom:0;font-weight:bold;line-height:100%;vertical-align:middle;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif'>
				<tbody>
				<tr>
				<td style='padding:20px 48px;display:block'>
				<h1 style='color:#ffffff;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:30px;font-weight:300;line-height:150%;margin:0;text-align:center'>New Customer Order</h1>
				</td>
				</tr>
				</tbody>
				</table>
				</td>
				</tr>
				<tr>
				<td align='center' valign='top'>
				<table border='0' cellpadding='0' cellspacing='0' width='100%'>
				<tbody>
				<tr>
				<td valign='top' style='background-color:#ffffff'>												
				<table border='0' cellpadding='20' cellspacing='0' width='100%'>
				<tbody>
				<tr>
				<td valign='top' style='padding:10px'>
				<div style='color:#636363;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:14px;line-height:150%;text-align:left'>
				<p style='margin:0 0 5px; text-align: center;'>You have received an order from <b>$username</b>. The order is as follows:</p>
				<h2 style='color:#43188E;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 10px;text-align:center'>
				Order ID: $orderid ($booking_date, $booking_time)</h2>
				<div style='margin-bottom:5px'>
				<table cellspacing='0' cellpadding='6' style='width:100%;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;color:#636363;border:1px solid #e5e5e5;vertical-align:middle' border='1'>
				<thead>
				<tr>
				<th scope='col' style='text-align:left;color:#43188E;border:1px solid #e5e5e5;vertical-align:middle;padding:12px'>Product</th>
				<th scope='col' style='text-align:left;color:#43188E;border:1px solid #e5e5e5;vertical-align:middle;padding:12px'>Quantity</th>
				<th scope='col' style='text-align:left;color:#43188E;border:1px solid #e5e5e5;vertical-align:middle;padding:12px'>Price</th>
				<th scope='col' style='text-align:left;color:#43188E;border:1px solid #e5e5e5;vertical-align:middle;padding:12px'>Total</th>
				</tr>
				</thead>
				<tbody>";
				while($row1 = mysqli_fetch_array($retval1))
				{
					$orderid = $row1['orderid'];
					$recipe_image = $row1['recipe_image'];
					$recipe_name = $row1['recipe_name'];
					$recipe_price = number_format($row1['recipe_price'],2);
					$no_quantity = $row1['no_quantity'];
					$total = $no_quantity * $recipe_price;
					$total1 = number_format($total,2);
					$htmlContent .= "<tr>
					<td style='text-align:left;vertical-align:middle;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word;color:#636363;border:1px solid #e5e5e5;padding:12px'>$recipe_name</td>
					<td style='text-align:left;vertical-align:middle;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;color:#636363;border:1px solid #e5e5e5;padding:12px'> $no_quantity</td>
					<td style='text-align:left;vertical-align:middle;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;color:#636363;border:1px solid #e5e5e5;padding:12px'><span>Rs $recipe_price</span></td>
					<td style='text-align:left;vertical-align:middle;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;color:#636363;border:1px solid #e5e5e5;padding:12px'><span>Rs $total1</span></td>
					</tr>";
				}
				$htmlContent .="</tbody>
				<tfoot>
				<tr>
				<th scope='row' colspan='3' style='text-align:right;border-top-width:4px;color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px'>Sub Total:</th>
				<td style='text-align:left;border-top-width:4px;color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px'>
				<span>Rs $recipe_total_amount</span>
				</td>
				</tr>
				<tr>
				<th scope='row' colspan='3' style='text-align:right;color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px'>Payment Method:</th>
				<td style='text-align:left;color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px'>$delivery_type</td>
				</tr>
				<tr>
				<th scope='row' colspan='3' style='text-align:right;color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px'>Delivery Charge:</th>
				<td style='text-align:left;color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px'>Rs $delivery_charge</td>
				</tr>
				<tr>
				<th scope='row' colspan='3' style='text-align:right;color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px'>Packing Charge:</th>
				<td style='text-align:left;color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px'>Rs $packing_charge</td>
				</tr>
				<tr>
				<th scope='row' colspan='3' style='text-align:right;color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px'>Discount:</th>
				<td style='text-align:left;color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px'>Rs $amount</td>
				</tr>
				<tr>
				<th scope='row' colspan='3' style='text-align:right;color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px'>Grand Total:</th>
				<td style='text-align:left;color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px'>
				<span>Rs $overall_total_amount</span>
				</td>
				</tr>
				</tfoot>
				</table>
				</div>
				<table cellspacing='0' cellpadding='0' style='width:100%;vertical-align:top;margin-bottom:5px;padding:0' border='0'>
				<tbody>
				<tr>
				<td style='text-align:left;border:0;padding:0' valign='top' width='50%'>
				<h2 style='color:#43188E;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:10px 0 18px;text-align:left'>Billing address</h2>
				<address style='padding:12px 12px 0;color:#636363;border:1px solid #e5e5e5'>
				$username<br>$address<br><a href='tel:$mobile_number' target='_blank'>$mobile_number</a>												
				<p style='margin:0 0 16px'><a href='mailto:$email' target='_blank'>$email</a></p>
				</address>
				</td>
				</tr>
				</tbody>
				</table>
				</div>
				</td>
				</tr>
				</tbody>
				</table>
				</td>
				</tr>
				</tbody>
				</table>
				</td>
				</tr>
				<tr>
				<td align='center' valign='top'>
				<table border='0' cellpadding='10' cellspacing='0' width='100%' id='m_8444486789857113272template_footer'>
				<tbody>
				<tr>
				<td valign='top' style='padding:0'>
				<table border='0' cellpadding='10' cellspacing='0' width='100%'>
				<tbody>
				<tr>
				<td colspan='2' valign='middle' style='padding:0 48px 10px 48px;border:0;color:#c09bb9;font-family:Arial;font-size:12px;line-height:125%;text-align:center'>
				<p style='margin-bottom: 0;'>- Veggis Super Market -</p>
				</td>
				</tr>
				</tbody>
				</table>
				</td>
				</tr>
				</tbody>
				</table>
				</td>
				</tr>
				</tbody>
				</table>"; 
			}

			$url = "https://fcm.googleapis.com/fcm/send";
			$token = $fcm_token;
			
			$sql5 = "SELECT * FROM api_key WHERE id='1'";
			$result5 = $conn->query($sql5);
			$row5 = $result5->fetch_assoc();

			if($payment_status != "Payment Failed")
			{
				$serverKey = $row5["fcm_token"];
				$title = "Hi ".$username;
				$body = "";
				$linkUrl = $orderid;
				$status = "processing";
				$body = "Your Order has been placed Successfully.";
				$image = "https://lapcoffee.com/dashboard/assets/images/orderplaced.png";
				$img = $image;
				$notification = array('title' =>$title ,'linkUrl' =>$linkUrl , 'body' => $body, 'image' => $img, 'sound' => 'default', 'badge' => '1', 'status' => $status, 'type' => 'order');
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
					$sql6 = "SELECT * FROM login WHERE id = '$resid'";
					$retval6 = mysqli_query($conn,$sql6);	
					$row6 = $retval6->fetch_assoc();

					$fcm_token1 = $row6['fcm'];
					
					$username1 = $row6['username'];
					$token1 = $fcm_token1;
					$serverKey1 = $serverKey;
					$title1 = "Hi ".$username1;
					$body1 = "New Order has been Placed";
					$linkUrl1 = $orderid;
					$image1 = "https://bakerymaharaj.com/dashboard/assets/images/notification/placed.png";		
					$notification1 = array('title' =>$title1 ,'linkUrl' =>$linkUrl1 , 'body' => $body1, 'image' => $image1, 'sound' => 'mysound', 'badge' => '1', 'status' => $status, 'type'=> 'order');
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
					$response1 = curl_exec($ch1);
					if ($response1 === FALSE) 
					{
						die('FCM Send Error: ' . curl_error($ch1));
					}
					else
					{
						$headers = "MIME-Version: 1.0" . "\r\n"; 
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
						
						$headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n"; 
						$headers .= 'Cc:' . "\r\n"; 
						$headers .= 'Bcc:' .$Bcc. "\r\n"; 
						
						mail($to, $subject, $htmlContent, $headers);
					}
					curl_close($ch1);
				}
				curl_close($ch);
			}
		}
		else
		{
			http_response_code(200);

			$myObj = new \stdClass();
			$myObj->status = "fail";
			$myObj->message = "Unable to update Status.";
			$myJSON = json_encode($myObj);
			echo $myJSON;
		}
	}
	else
	{
		http_response_code(200);

		$myObj = new \stdClass();
		$myObj->status = "fail";
		$myObj->message = "Unable to update Status. Data is incomplete.";
		$myJSON = json_encode($myObj);
		echo $myJSON;
	}
?>

