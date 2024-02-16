<?php
    include("../inc/dbconn.php");

    // get posted data
    $data = json_decode(file_get_contents('php://input'));

    // make sure data is not empty
    if(!empty($data->address_id) &&  !empty($data->booking_date) &&  !empty($data->delivery_type) &&  !empty($data->booking_time) && !empty($data->total_amount) && !empty($data->branch_id)) {

        // set product property values
        $latitude = $data->branch_id;

        $sql4 = "SELECT * FROM hotel WHERE lid='$latitude'";
        $result4 = $conn->query($sql4);
        $row4 = $result4->fetch_assoc();

        $sql5 = "SELECT * FROM order_details";
        $result5 = $conn->query($sql5);
        $count = $result5->num_rows+1;
        
        $name = strtoupper(substr($row4["name"],0,2));
        
        $orderid = "Veggis".$name."".date("d")."".date("m")."".date("y")."".$count;
        $username = $data->user_id;
        $address = $data->address_id;
        $pid = $data->product_id;
        $booking_date = $data->booking_date;
        $booking_time = $data->booking_time;
        $delivery_date = $data->delivery_date;
        $delivery_time = $data->delivery_time;
        $delivery_type = $data->delivery_type;
        $delivery_charge = $data->delivery_charge;
        $packing_charge = $data->packing_charge;
        $email = $data->email;
        $mobile_number = $data->user_mobile;
        $recipe_total_amount = $data->recipe_amount;
        $overall_total_amount = $data->total_amount;
        $landmark = $data->landmark;
        $longitude = $data->longitude;
        $order_status = $data->order_status;
        $lati = $data->lati;
        $longi = $data->longi;
        $redeem1 = $data->redeem_point_used;
        $redeem2 = $data->redeem_point_recipe;
        $coupon = $data->coupon_applied;
        
        $sql2 = "SELECT * FROM users WHERE phone='$mobile_number'";
        $result2 = $conn->query($sql2);
        $row2 = $result2->fetch_assoc();
        
        $red = "";
        if($redeem1 == 0)
        {
            $red = $row2["reddem"] + $redeem2;
        }
        else
        {
            $red = $row2["reddem"] - $redeem1;
        }

        $sql3 = "UPDATE users SET reddem='$red' WHERE phone='$mobile_number'";
        if($conn->query($sql3) === TRUE)
        {
            $sql = "INSERT INTO order_details (orderid,username,address,booking_date,booking_time,delivery_charge,packing_charge,delivery_type,email,latitude,overall_total_amount,recipe_total_amount,redeem_point,coupon,mobile_number) VALUES ('$orderid','$username','$address','$booking_date','$booking_time','$delivery_charge','$packing_charge','$delivery_type','$email','$latitude','$overall_total_amount','$recipe_total_amount','$redeem1','$coupon','$mobile_number')";
            if($conn->query($sql) === TRUE)
            {
                foreach($data->recipe as $line)
                {
                    $product_id = $line->recipe_id;
                    $price_id = $line->price_id;
                    $recipe_image = $line->recipe_image;
                    $recipe_name = $line->recipe_name;
                    $recipe_price = $line->recipe_price;
                    $no_quantity = $line->no_quantity;
                    $catid = $line->cat_id;
                    $scatid = $line->sub_cat_id;

                    $sql1 = "INSERT INTO recipe_details (orderid,product_id,recipe_image,recipe_name,recipe_price,no_quantity,catid,scatid,hotel_id,proid) VALUES ('$orderid','$product_id','$recipe_image','$recipe_name','$recipe_price','$no_quantity','$catid','$scatid','$latitude','$price_id')";
                    if($conn->query($sql1) === TRUE)
                    {
                        // set response code - 201 created
                        http_response_code(200);
                    }
                    else
                    {
                        // set response code - 503 service unavailable
                        http_response_code(200);
                    }
                }
                http_response_code(200);
                
                $myObj = new \stdClass();
                $myObj->status = "success";
                $myObj->message = "Order was created.";
                $myObj->order_id = $orderid;
                $myJSON = json_encode($myObj);
                echo $myJSON;
            }
            else
            {
                http_response_code(200);

                $myObj = new \stdClass();
                $myObj->status = "fail";
                $myObj->message = "Unable to create Order.";
                $myJSON = json_encode($myObj);
                echo $myJSON;
            }
        }
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to create Order. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>