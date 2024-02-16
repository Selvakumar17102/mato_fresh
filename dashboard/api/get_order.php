<?php
    include("../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->mobile_number) && !empty($data->order_id))
    {
        $phone = $data->mobile_number;
        $oid = $data->order_id;
        
       $sql = "SELECT * FROM order_details WHERE mobile_number='$phone' AND orderid='$oid' ORDER BY sno DESC LIMIT 1";
        $result = $conn->query($sql);
        $tem = array();
        $i = 0;
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $long = $row["latitude"];
                $wid = $row["longitude"];
                $order_status = "";
                $r = array();

                $sql1 = "SELECT * FROM recipe_details WHERE orderid='$oid'";
                $result1 = $conn->query($sql1);
                $j = 0;
                while($row1 = $result1->fetch_assoc())
                {
                    $pid = $row1["product_id"];
                    $offer = $row1["offer"];
                    if($offer == 1)
                    {
                        $sql8 = "SELECT * FROM offer_product WHERE id='$pid'";
                        $result8 = $conn->query($sql8);
                        $row8 = $result8->fetch_assoc();

                        $recipe_image = $row8["image"];
                        $recipe_name = $row8["name"];
                        $recipe_description = "";
                        $variation = $row8["vari"];
                        $qty = $row8["qua"];
                        $price = $row8["amo"];
                    }
                    else if($offer == 2)
                    {
                        $sql7 = "SELECT * FROM compo_product WHERE id='$pid'";
                        $result7 = $conn->query($sql7);
                        $row7 = $result7->fetch_assoc();

                        $recipe_image = $row7["image"];
                        $recipe_name = $row7["name"];
                        $recipe_description = $row7["description"];
                        $variation = "";
                        $qty = $row7["qua"];
                        $price = $row7["amo"];
                    }
                    else 
                    {
                    $sql4 = "SELECT * FROM product WHERE id='$pid'";
                    $result4 = $conn->query($sql4);
                    $row4 = $result4->fetch_assoc();

                    $priceid = $row1["proid"];

                    $sql5 = "SELECT * FROM price WHERE id='$priceid'";
                    $result5 = $conn->query($sql5);
                    $row5 = $result5->fetch_assoc();

                    $recipe_name = $row1["recipe_name"];
                    $variation = $row1["variation"];
                    $qty = $row1["no_quantity"];
                    $price = $row1["recipe_price"];
                    $recipe_image = $row1["recipe_image"];
                    $recipe_description = "";
                    }

                    $r[$j]["recipe_name"] = $recipe_name;
                    $r[$j]["price_name"] = $variation;
                    $r[$j]["recipe_quantity"] = $qty;
                    $r[$j]["recipe_price"] = $price;
					$r[$j]["recipe_image"] = $recipe_image;
					$r[$j]["recipe_description"] = $recipe_description;
                    
                    $j++;
                }

                $sql2 = "SELECT * FROM hotel WHERE lid='$long'";
                $result2 = $conn->query($sql2);
                $row2 = $result2->fetch_assoc();

                $sql3 = "SELECT * FROM login WHERE id='$long'";
                $result3 = $conn->query($sql3);
                $row3 = $result3->fetch_assoc();

                if($row["product_id"] == 3)
                {
                    $order_status = "Order Delivered";
                }
                else
                {
                    if($row["product_id"] == 2)
                    {
                        $order_status = "Order Picked";
                    }
                    else
                    {
                        if($row["product_id"] == 1 && $row['longitude'] !=null)
                        {
                            $order_status = "Delivery Partner Assigned";
                        }
                        else
                        {
                            $order_status = $row["order_status"];
                        }
                    }
                }

                $h["id"] = $row2["id"];
                $h["name"] = $row2["name"];
                $h["address"] = $row2["addr"];
                $h["mobileno"] = $row3["phone"];
                $h["latitude"] = $row2["lati"];
                $h["longitude"] = $row2["longi"];

                $sql2 = "SELECT * FROM worker WHERE lid='$wid'";
                $result2 = $conn->query($sql2);
                $row2 = $result2->fetch_assoc();

                $d["id"] = $row2["lid"];
                $d["name"] = $row2["name"];
                $d["mobileno"] = $row2["phone"];
                $d["latitude"] = $row2["lati"];
                $d["longitude"] = $row2["longi"];

                $tem["Veggis"][$i]["id"] = $row["sno"];
                $tem["Veggis"][$i]["orderid"] = $row["orderid"];
                $tem["Veggis"][$i]["booked_date"] = date('d-m-Y', strtotime($row["booking_date"]));
                $tem["Veggis"][$i]["booked_time"] = $row["booking_time"];
                $tem["Veggis"][$i]["total_amount"] = $row["overall_total_amount"];
                $tem["Veggis"][$i]["order_status"] = $order_status;
                $tem["Veggis"][$i]["branch"] = $h;
                $tem["Veggis"][$i]["recipie_details"] = $r;
                $tem["Veggis"][$i]["delivery_partner"] = $d;
                $tem["Veggis"][$i]["total_recipe_amount"] = $row["recipe_total_amount"];
                $tem["Veggis"][$i]["delivery_charges"] = $row["delivery_charge"] + $row["packing_charge"];
                $tem["Veggis"][$i]["mode_of_payment"] = $row["delivery_type"];
                $tem["Veggis"][$i]["latitude"] = $row["lati"];
                $tem["Veggis"][$i]["longitude"] = $row["longi"];
                $tem["Veggis"][$i]["coupon_applied"] = $row["coupon"];
                $tem["Veggis"][$i]["delivery_slot"] = $row["delivery_slot"];
                $tem["Veggis"][$i]["redeem_point_used"] = $row["redeem_point"];

                $json = json_encode($tem);
                $i++;
            }

            $tem["status"] = "success";
            $tem["message"] = "Orders Found";
            $json = json_encode($tem);

            echo $json;
        }
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to Find Order.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "Fail";
        $myObj->message = "Unable to Find Order. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>