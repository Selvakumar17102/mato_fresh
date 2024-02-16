<?php
    include("../inc/dbconn.php");
    $output_array = array();

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->offer_coupon)){
        $offer_coupon = $data->offer_coupon;

        $sql = "SELECT * FROM offers WHERE code='$offer_coupon' AND status='0'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            http_response_code(200);
            $output_array['Veggis']['offer_id'] = $row['id'];
            $output_array['Veggis']['offer_coupon'] = $row['code'];
            $output_array['Veggis']['offer_percentage'] = $row['percent'];
            $output_array['Veggis']['minimum_ordering_amount'] = $row['min'];
            $output_array['Veggis']['maximum_discount_amount'] = $row['max'];
            $output_array['Veggis']['promo_string'] = 'Get '.$row['percent'].'% OFF upto ₹'.$row['max'].' on order of above ₹'.$row['min'].'.';
            $output_array['status'] = 'success';
            $output_array['message'] = 'Ok';
        } else{
            http_response_code(404);
            $output_array['status'] = 'fail';
            $output_array['message'] = 'Coupon not found';
        }
    } else{
        http_response_code(400);
        $output_array['status'] = 'fail';
        $output_array['message'] = 'Bad Request';
    }

    echo json_encode($output_array);
?>