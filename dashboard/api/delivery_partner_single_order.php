<?php
    include("../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->order_id))
    {   
        $oid = $data->order_id;
        
        $sql = "SELECT * FROM order_details WHERE orderid='$oid' ORDER BY sno DESC LIMIT 1";
        $result = $conn->query($sql);
        $tem = array();
        $i = 0;
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $long = $row["latitude"];
                $address = $row["address"];
                $phone = $row["mobile_number"];
                $order_status = "";
                $r = array();

                $sql1 = "SELECT * FROM recipe_details WHERE orderid='$oid'";
                $result1 = $conn->query($sql1);
                $j = 0;
                while($row1 = $result1->fetch_assoc())
                {
                    $pid = $row1["product_id"];

                    $sql4 = "SELECT * FROM product WHERE id='$pid'";
                    $result4 = $conn->query($sql4);
                    $row4 = $result4->fetch_assoc();

                    $r[$j]["recipe_name"] = $row1["recipe_name"];
                    $r[$j]["recipe_quantity"] = $row1["no_quantity"];
                    $r[$j]["recipe_price"] = $row1["recipe_price"];
                    $r[$j]["cat_id"] = $row4["cate"];

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
                    $order_status = "Delivered";
                }
                else
                {
                    if($row["product_id"] == 2)
                    {
                        $order_status = "Dispatched";
                    }
                    else
                    {
                        if($row["product_id"] == 1)
                        {
                            $order_status = "Delivery Partner Assigned";
                        }
                        else
                        {
                            $order_status = $row["order_status"];
                        }
                    }
                }
                
                $sql4 = "SELECT * FROM user_address WHERE id='$address'";
                $result4 = $conn->query($sql4);
                $row4 = $result4->fetch_assoc();
                
                $sql5 = "SELECT * FROM users WHERE phone='$phone'";
                $result5 = $conn->query($sql5);
                $row5 = $result5->fetch_assoc();

                $c["id"] = $row5["sno"];
                $c["user_name"] = $row5["name"];
                $c["user_address"] = $row4["addr"];
                $c["user_landmark"] = $row4["land"];
                $c["user_mobile"] = $row5["phone"];
                $c["user_latitude"] = $row4["lati"];
                $c["user_longitude"] = $row4["longi"];

                $h["id"] = $row2["lid"];
                $h["name"] = $row2["name"];
                $h["address"] = $row2["addr"];
                $h["mobileno"] = $row3["phone"];
                $h["latitude"] = $row2["lati"];
                $h["longitude"] = $row2["longi"];

                $tem["Veggis"][$i]["id"] = $row["sno"];
                $tem["Veggis"][$i]["orderid"] = $row["orderid"];
                $tem["Veggis"][$i]["booked_date"] = $row["booking_date"];
                $tem["Veggis"][$i]["booked_time"] = $row["booking_time"];
                $tem["Veggis"][$i]["total_amount"] = (string)$row["overall_total_amount"];
                $tem["Veggis"][$i]["tax"] = (string)$row["tax"];
                $tem["Veggis"][$i]["order_status"] = $order_status;
                $tem["Veggis"][$i]["branch"] = $h;
                $tem["Veggis"][$i]["user"] = $c;
                $tem["Veggis"][$i]["recipie_details"] = $r;
                $tem["Veggis"][$i]["total_recipe_amount"] = (string)$row["recipe_total_amount"];
                $tem["Veggis"][$i]["delivery_charges"] = (string) ($row["delivery_charge"] + $row["packing_charge"]);
                $tem["Veggis"][$i]["mode_of_payment"] = $row["delivery_type"];
                $tem["Veggis"][$i]["latitude"] = $row["lati"];
                $tem["Veggis"][$i]["longitude"] = $row["longi"];
                $tem["Veggis"][$i]["coupon_applied"] = $row["coupon"];
                $tem["Veggis"][$i]["delivery_slot"] = $row["delivery_slot"];
                $tem["Veggis"][$i]["total_cost"] = (string)$row["km"];
                $tem["Veggis"][$i]["redeem_point_used"] = $row["redeem_point"];

                $json = json_encode($tem);
                $i++;
            }

            $tem["status"] = "success";
            $tem["message"] = "Order Found";
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