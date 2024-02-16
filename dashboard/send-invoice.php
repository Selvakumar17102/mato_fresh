<?php
ini_set('display_errors','off');
include("session.php");
include("inc/dbconn.php");
$id = $_REQUEST['id'];
$sql = "SELECT * FROM order_details WHERE sno = '$id'";
$retval = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($retval))
 {
	$orderid = $row['orderid'];
	$username = $row['username'];
	$address = $row['address'];
	$booking_date = $row['booking_date'];
	$booking_time = $row['booking_time'];
	$delivery_charge = number_format($row['delivery_charge'],2);
	$packing_charge = number_format($row['packing_charge'],2);
	$delivery_type = $row['delivery_type'];
	$delivery_date = $row['delivery_date'];
	$delivery_time = $row['delivery_time'];
	$email = $row['email'];
	$landmark = $row['landmark'];
	$mobile_number = $row['mobile_number'];
	$overall_total_amount = number_format($row['overall_total_amount'],2);
	$recipe_total_amount = number_format($row['recipe_total_amount'],2);
	$order_status = $row['order_status'];
	$payment_status = $row['payment_status'];
	$coupon = $row['coupon'];
	$redeem_point = $row['redeem_point'];
	
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
 }
$sql1 = "SELECT * FROM recipe_details WHERE orderid = '$orderid'";
$retval1 = mysqli_query($conn,$sql1);
$to = $email;  
$from = 'noreply@gtechwebsolutions.com'; 
$fromName = 'Veggis';  
$subject = "Order Invoice $orderid";  
$htmlContent = " 
<html> 
<head> 
<title>Welcome to Veggis</title> 
</head> 
<body style='background: #F7F7F7;'> 
<table border='0' cellpadding='0' cellspacing='0' width='600' style='background-color:#ffffff;border:1px solid #dedede;border-radius:3px!important;margin: 20px auto;'>
<tbody>
<center><img src='https://veggis.in/dashboard/assets/images/logo.png' style='margin-top: 20px;'></center>
<tr>
<td align='center' valign='top'>
<table border='0' cellpadding='0' cellspacing='0' width='600' style='background-color:#43188E;border-radius:3px 3px 0 0!important;color:#ffffff;border-bottom:0;font-weight:bold;line-height:100%;vertical-align:middle;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif'>
<tbody>
<tr>
<td style='padding:36px 48px;display:block'>
<h1 style='color:#ffffff;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:30px;font-weight:300;line-height:150%;margin:0;text-align:center'>Order Invoice</h1>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td align='center' valign='top'>
<table border='0' cellpadding='0' cellspacing='0' width='600'>
<tbody>
<tr>
<td valign='top' style='background-color:#ffffff'>												
<table border='0' cellpadding='20' cellspacing='0' width='100%'>
<tbody>
<tr>
<td valign='top' style='padding:28px 48px 0'>
<div style='color:#636363;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:14px;line-height:150%;text-align:left'>
<p style='margin:0 0 16px'>Hi there. Your recent order on Veggis has been completed. Your order details are shown below for your reference:</p>
<h2 style='color:#43188E;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left'>
Order ID: $orderid ($booking_date, $booking_time)</h2>
<div style='margin-bottom:40px'>
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
<td style='text-align:left;vertical-align:middle;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word;color:#636363;border:1px solid #e5e5e5;padding:12px'>" .$recipe_name."</td>
<td style='text-align:left;vertical-align:middle;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;color:#636363;border:1px solid #e5e5e5;padding:12px'>" .$no_quantity."</td>
<td style='text-align:left;vertical-align:middle;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;color:#636363;border:1px solid #e5e5e5;padding:12px'><span>Rs " .$recipe_price."</span></td>
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
<th scope='row' colspan='3' style='text-align:right;color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px'>Payment method:</th>
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
<table cellspacing='0' cellpadding='0' style='width:100%;vertical-align:top;margin-bottom:40px;padding:0' border='0'>
<tbody>
<tr>
<td style='text-align:left;border:0;padding:0' valign='top' width='50%'>
<h2 style='color:#43188E;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left'>Billing address</h2>
<address style='padding:12px 12px 0;color:#636363;border:1px solid #e5e5e5'>
$address<br><a href='tel:$mobile_number' target='_blank'>$mobile_number</a>												
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
<table border='0' cellpadding='10' cellspacing='0' width='600' id='m_8444486789857113272template_footer'>
<tbody>
<tr>
<td valign='top' style='padding:0'>
<table border='0' cellpadding='10' cellspacing='0' width='100%'>
<tbody>
<tr>
<td colspan='2' valign='middle' style='padding:0 48px 48px 48px;border:0;color:#c09bb9;font-family:Arial;font-size:12px;line-height:125%;text-align:center'>
<p style='margin-bottom: 0;'>- Veggis Super Market -</p></td>
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
</table>
</body> 
</html>"; 
$headers = "MIME-Version: 1.0" . "\r\n"; 
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
$headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n"; 
$headers .= 'Cc:' . "\r\n"; 
$headers .= 'Bcc:' . "\r\n"; 
mail($to, $subject, $htmlContent, $headers);
header("Location: view-order.php?id=$id&msg=Invoice Sent to customer email!");
?>