<?php
    include("../inc/dbconn.php");
    include("distance-calculator-n.php");

    // get posted data
    $data = json_decode(file_get_contents('php://input'));

    // make sure data is not empty
    if(!empty($data->address_id) &&  !empty($data->booking_date) &&  !empty($data->delivery_type) &&  !empty($data->booking_time) && !empty($data->total_amount))
    {
        $address = $data->address_id;
		
        $nullarray = array();

        $sql = "SELECT * FROM user_address WHERE id='$address'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $lat1 = $row["lati"];
        $lon1 = $row["longi"];

        $sql4 = "SELECT * FROM hotel";
        $result4 = $conn->query($sql4);
        while($row4 = $result4->fetch_assoc())
        {
            $lid = $row4["lid"];
            $lat2 = $row4["lati"];
            $lon2 = $row4["longi"];

            $km = getDistance($lat1,$lon1,$lat2,$lon2);

            $nullarray[$lid] = number_format($km,2);
        }

        asort($nullarray);
        $latitude = $i = 0;

        foreach($nullarray as $x => $x_value)
        {
            if($i == 0)
            {
                $latitude = $x;
                $i++;
            }
        }

        $sql5 = "SELECT * FROM order_details ORDER BY sno DESC LIMIT 1";
        $result5 = $conn->query($sql5);
        $row5 = $result5->fetch_assoc();

        $count = $row5["sno"] + 1;
        
        $name = strtoupper(substr($row4["name"],0,2));
        
        $orderid = "MAT".$name."".date("H")."".date("i")."".date("s")."".$count;
        $username = $data->user_id;
        $booking_date = date('Y-m-d',strtotime($data->booking_date));
        $booking_time = $data->booking_time;
        $delivery_date = date('Y-m-d',strtotime($data->delivery_date));
        $delivery_time = $data->delivery_slot;
        $delivery_type = $data->delivery_type;
        $delivery_charge = $data->delivery_charge;
        $packing_charge = $data->packing_charge;
        $email = $data->email;
        $mobile_number = $data->user_mobile;
        $recipe_total_amount = $data->recipe_total_amount;
        $overall_total_amount = $data->total_amount;
        $landmark = $data->landmark;
        $order_status = $data->order_status;
        $redeem1 = $data->redeem_point_used;
        $redeem2 = $data->redeem_point_recipe;
        $coupon = $data->coupon_applied;
		$fcm_token = $data->fcm_token;
        
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
            $sql = "INSERT INTO order_details (orderid,username,address,booking_date,booking_time,delivery_charge,packing_charge,delivery_type,email,latitude,overall_total_amount,recipe_total_amount,redeem_point,coupon,mobile_number,fcm_token,delivery_date,delivery_slot) VALUES ('$orderid','$username','$address','$booking_date','$booking_time','$delivery_charge','$packing_charge','$delivery_type','$email','$latitude','$overall_total_amount','$recipe_total_amount','$redeem1','$coupon','$mobile_number','$fcm_token','$delivery_date','$delivery_time')";
            if($conn->query($sql) === TRUE)
            {
                foreach($data->recipe as $line)
                {
                    $product_id = $line->recipe_id;
                    $no_quantity = $line->no_quantity;
                    $recipe_price = $line->recipe_price;
                    $vari = $line->variation;
                    $offer = $line->offer;
                    $catid = $scatid = 0;

                    if($offer == 1)
                    {
                        $sql6 = "SELECT * FROM offer_product WHERE id='$product_id'";
                        $result6 = $conn->query($sql6);
                        $row6 = $result6->fetch_assoc();

                        $recipe_image = $row6["image"];
                        $recipe_name = $row6["name"];
                        $recipe_description = "";
                    }
                    else if($offer == 2)
                    {
                        $sql7 = "SELECT * FROM compo_product WHERE id='$product_id'";
                        $result7 = $conn->query($sql7);
                        $row7 = $result7->fetch_assoc();

                        $recipe_image = $row7["image"];
                        $recipe_name = $row7["name"];
                        $recipe_description = $row7["description"];
                    }
                    else
                    {
                        $sql6 = "SELECT * FROM product WHERE id='$product_id'";
                        $result6 = $conn->query($sql6);
                        $row6 = $result6->fetch_assoc();

                        $recipe_image = $row6["image"];
                        $recipe_name = $row6["name"];
                        $catid = $row6["cate"];
                        $recipe_description = "";
                    }

                    $sql1 = "INSERT INTO recipe_details (orderid,product_id,recipe_image,recipe_name,recipe_price,no_quantity,catid,hotel_id,proid,variation,description,offer) VALUES ('$orderid','$product_id','$recipe_image','$recipe_name','$recipe_price','$no_quantity','$catid','$latitude','$price_id','$vari','$recipe_description','$offer')";
                    $conn->query($sql1);
                }
                
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