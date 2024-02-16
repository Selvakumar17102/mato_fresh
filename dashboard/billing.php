<?php
ini_set('display_errors','off');
include("session.php");
include("inc/dbconn.php");
$id = $_REQUEST['id'];
?>
 <html>
<head>
<style type="text/css">
@media print{
    input.print1 {display:none !important;}
}
.print1 {color: #fff;
    padding: 10px 20px;
    display: inline-block;
    font-size: 14px;
    outline: none;
    cursor: pointer;
    outline: none;
    border-width: 0;
    border-style: solid;
    border-color: transparent;
    line-height: 1.42857;
    border-radius: 3px;
    font-weight: 400;
    text-align: center;
	background-color: #EFBB20;
float: right;
	}
</style>
</head>
<body onload="window.print()">
<input class="print1" type="button" value="Print" onclick="window.print()">
<?php
$sql = "SELECT * FROM order_details WHERE sno = '$id'";
$retval = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($retval))
 {
	$orderid = $row['orderid'];
	$username = $row['username'];
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

echo "
<table border='0' cellpadding='0' cellspacing='0' width='100%' style='background-color:#ffffff;border:1px solid #dedede;border-radius:3px!important;margin: 5px auto;'>
<tbody>
<center><img src='https://veggis.in/dashboard/assets/images/logo.png' style='margin-top: 0px;'></center>
<tr>
<td align='center' valign='top'>
<table border='0' cellpadding='0' cellspacing='0' width='100%' style='background-color:#43188E;border-radius:3px 3px 0 0!important;color:#ffffff;border-bottom:0;font-weight:bold;line-height:100%;vertical-align:middle;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif'>
<tbody>
<tr>
<td style='padding:0px 48px;display:block'>
<h1 style='color:#ffffff;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:30px;font-weight:300;line-height:150%;margin:0;text-align:center'>Order Invoice</h1>
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
<p style='margin:0 0 5px; text-align: center;'>Your order details are shown below for your reference:</p>
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
echo "
<tr>
<td style='text-align:left;vertical-align:middle;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word;color:#636363;border:1px solid #e5e5e5;padding:12px'>$recipe_name</td>
<td style='text-align:left;vertical-align:middle;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;color:#636363;border:1px solid #e5e5e5;padding:12px'> $no_quantity</td>
<td style='text-align:left;vertical-align:middle;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;color:#636363;border:1px solid #e5e5e5;padding:12px'><span>Rs $recipe_price</span></td>
<td style='text-align:left;vertical-align:middle;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;color:#636363;border:1px solid #e5e5e5;padding:12px'><span>Rs $total1</span></td>
</tr>";
}

echo "</tbody>
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

?>

</body>
</html>