<?php
    include("../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->schemeid) && !empty($data->userid)){
        $userid = $data->userid;
        $schemeid = $data->schemeid;

        $json = "";

        $sql = "SELECT * FROM `subscription` WHERE id= '$schemeid'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();

            // $schemetotaldays = $row['schemeday'];

            $schemeday =$row['schemeday'];
            $schemestartDate = date('Y-m-d');
            $schemeendDate = date('Y-m-d',strtotime(+$schemeday."days"));
            $schemeamount = $row['schemeamount'];

            $razorpay_order_id = "54327656543543";
            $razorpay_payment_id = "54327656543543";

            $payment_status = "1";
            $is_wallet = "0";

            if($payment_status == 1){
                
            }else{
                http_response_code(200);
                $myObj = new \stdClass();
                $myObj->status = "fail";
                $myObj->message = "payment failed.";
                $myJSON = json_encode($myObj);
                echo $myJSON;
            }

            
            $json = json_encode($tem);
                
            if($json == ""){
                http_response_code(200);

                $myObj = new \stdClass();
                $myObj->status = "fail";
                $myObj->message = "No Products Available.";
                $json = json_encode($myObj);
            }else{
                $tem["status"] = "success";
                $tem["message"] = "Products Found";
                $json = json_encode($tem);
            }
            echo $json;
        }else{
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to Find Products.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }else{
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to Find Scheme.Data is Incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>