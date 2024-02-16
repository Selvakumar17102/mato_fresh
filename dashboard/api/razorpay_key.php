<?php
    ini_set('display_errors','off');
    include("../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->order_id))
    {
        $r = $data->order_id;
        
        $sql = "SELECT * FROM order_details WHERE orderid='$r'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        
        $sql1 = "SELECT * FROM api_key WHERE id=1";
        $result1 = $conn->query($sql1);
        $row1 = $result1->fetch_assoc();

        $merchant_key = $row1['merchant_key'];
        $merchant_id = $row1['merchant_id'];

        $amo = $row["overall_total_amount"] * 100;

        $url = "https://api.razorpay.com/v1/orders";

        $arrayToSend = array("amount"=> $amo,"currency"=> "INR","receipt"=> $r);
        $json = json_encode($arrayToSend);
        
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_USERPWD, $merchant_key.':'.$merchant_id);
        $response = curl_exec($ch);
    }
    else
    {
        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Key cannot be generated. Data is incomplete.";
        $json = json_encode($myObj);
        echo $json;
    }
?>