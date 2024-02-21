<?php
    include("../../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->user_id) && !empty($data->product_id)){
        $user_id = $data->user_id;
        $product_id = $data->product_id;
        $quantity = $data->quantity;

        $sql1 = "INSERT INTO request(hotel_id,product_id,quantity) VALUES ('$user_id','$product_id','$quantity')";
        if($conn->query($sql1) === TRUE){
            $myObj = new \stdClass();
            $myObj->status = "success";
            $myObj->message = "Updated";
            $myJSON = json_encode($myObj);
            echo $myJSON;   
        }
    }
    else{
        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "unable to update. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>