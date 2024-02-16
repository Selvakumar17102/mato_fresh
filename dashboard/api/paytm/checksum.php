<?php
/*
* import checksum generation utility
* You can get this utility from https://developer.paytm.com/docs/checksum/
*/
include("../../inc/dbconn.php");
require_once("PaytmChecksum.php");
$data = json_decode(file_get_contents('php://input'));

$paytmParams = array();
$sql = "SELECT * FROM api_key ORDER BY id ASC LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$MK = $row["merchant_key"];
$MID = $row["merchant_id"];

$paytmParams["body"] = array(
"requestType" => "Payment",
"mid" => $MID,
"websiteName" => $data->WEBSITE,
"orderId" => $data->ORDER_ID,
"callbackUrl" => "https://securegw.paytm.in/theia/paytmCallback?ORDER_ID=$data->ORDER_ID",
"txnAmount" => array(
"value" => $data->TXN_AMOUNT,
"currency" => "INR",
),
"userInfo" => array(
"custId" => $data->CUST_ID,
),
);

/*
* Generate checksum by parameters we have in body
* Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
*/
$checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $MK);

$paytmParams["head"] = array(
"signature" => $checksum
);

$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

// for Staging /
//$url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=$MID&orderId=$data->ORDER_ID";

// for Production /
  $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=$MID&orderId=$data->ORDER_ID";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
$response = curl_exec($ch);

print_r($response);
?>