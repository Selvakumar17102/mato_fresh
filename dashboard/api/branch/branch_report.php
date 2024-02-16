<?php
    include("../../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->user_id) && !empty($data->fromdate) && !empty($data->todate)){
        $user_id = $data->user_id;
        $fromdate = date('Y-m-d', strtotime($data->fromdate));
        $todate = date('Y-m-d', strtotime($data->todate));

        $sql = "SELECT * FROM login WHERE id='$user_id' AND control='2'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $cod = $online = $amount = 0;
            $sql = "SELECT * FROM order_details WHERE latitude='$user_id' AND booking_date BETWEEN '$fromdate' AND '$todate' AND order_status='Accepted' AND product_id='3'";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                if($row['delivery_type'] == 'Cash On Delivery'){
                    $cod++;
                } else{
                    $online++;
                }
                $amount = $row['overall_total_amount'];
            }

            $myObj = new \stdClass();
            $myObj->total_orders = $online + $cod;
            $myObj->cod = $cod;
            $myObj->onile_payment = $online;
            $myObj->total_amount = $amount;
            $myObj->status = "success";
            $myObj->message = "Updated";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        } else{
            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Invalid user";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    } else{
        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "unable to update. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>