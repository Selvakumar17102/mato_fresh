<?php
    include("inc/dbconn.php");

    $delivery_boy = $_GET["delivery_boy"];
    $orderid = $_GET["order_id"];

    if($delivery_boy !="" && $orderid !="")
    {
        $sql = "UPDATE order_details SET product_id='1',longitude='$delivery_boy' WHERE orderid='$orderid'";
        if($conn->query($sql)==TRUE)
        {
            $sql5 = "SELECT * FROM api_key WHERE id='1'";
            $result5 = $conn->query($sql5);
            $row5 = $result5->fetch_assoc();
            $serverKey = $row5["fcm_token"];

            $sql4 = "SELECT * FROM worker WHERE lid='$delivery_boy'";
            $result4 = $conn->query($sql4);
            $row4 = $result4->fetch_assoc();

            $username = $row4["name"];
            $url = "https://fcm.googleapis.com/fcm/send";
            $token = $row4["fcm_token"];
            $title = "Hi ".$username;
            $body = "New Order has been arrived. Order Id : ".$orderid;
            $linkUrl = $orderid;
            $img = "https://sevagan.co.in/dashboard/assets/images/Order%20placed.png";
            $notification = array('title' =>$title,'linkUrl' =>$orderid,'body' => $body, 'image' => $img, 'sound' => 'default', 'badge' => '1', 'type'=>'2');
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
                header("Location: order.php?msg=Delivery boy assigned!");
            }
            curl_close($ch1);
        }
    }

?>