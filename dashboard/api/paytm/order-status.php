<?php
/*
* import checksum generation utility
* You can get this utility from https://developer.paytm.com/docs/checksum/
*/
include("../../inc/dbconn.php");
require_once("checksum.php");
$data = json_decode(file_get_contents('php://input'));
$paytmParams = array();
$sql = "SELECT * FROM api_key ORDER BY id ASC LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$MK = $row["MerchantKey"];
$MID = $row["MerchantID"];
$paytmParams["MID"] = $MID;
$paytmParams["ORDERID"] = $data->ORDER_ID;

/*
* Generate checksum by parameters we have
* Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
*/
$checksum = PaytmChecksum::generateSignature($paytmParams, $MK);

$paytmParams["CHECKSUMHASH"] = $checksum;

$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

// for Staging /
//$url = "https://securegw-stage.paytm.in/order/status";

// for Production /
 $url = "https://securegw.paytm.in/order/status";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$response = curl_exec($ch);
print_r($response);

?>