<?php
    include("../../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->user_id))
    {
        $user_id = $data->user_id;

        $sql = "SELECT * FROM order_details WHERE latitude='$user_id' AND product_id='3' OR order_status='Cancelled' ORDER BY sno DESC";
        $result = $conn->query($sql);
        $tem = array();
        $i = 0;
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $username = $row['username'];
                $address_id = $row['address'];

                $oid = $row["orderid"];
                $long = $row["latitude"];
                $wid = $row["longitude"];
                $order_status = "";
                $r = $h = array();

                $sql1 = "SELECT * FROM recipe_details WHERE orderid='$oid'";
                $result1 = $conn->query($sql1);
                $j = 0;
                while($row1 = $result1->fetch_assoc())
                {
                    $pid = $row1["product_id"];

                    $sql4 = "SELECT * FROM product WHERE id='$pid'";
                    $result4 = $conn->query($sql4);
                    $row4 = $result4->fetch_assoc();

                    $priceid = $row1["proid"];

                    $sql5 = "SELECT * FROM price WHERE id='$priceid'";
                    $result5 = $conn->query($sql5);
                    $row5 = $result5->fetch_assoc();

                    $r[$j]["recipe_id"] = $row1["sno"];
                    $r[$j]["recipe_name"] = $row1["recipe_name"];
                    $r[$j]["price_name"] = $row5["variation"];
                    $r[$j]["recipe_quantity"] = $row1["no_quantity"];
                    $r[$j]["recipe_price"] = $row1["recipe_price"];
                    $r[$j]["description"] = $row1["description"];

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

                $h["id"] = $row2["id"];
                $h["name"] = $row2["name"];
                $h["name_arab"] = $row2["ar_name"];
                $h["address"] = $row2["addr"];
                $h["mobileno"] = $row3["phone"];
                $h["latitude"] = $row2["lati"];
                $h["longitude"] = $row2["longi"];

                $sql2 = "SELECT * FROM users WHERE sno='$username'";
                $result2 = $conn->query($sql2);
                $row2 = $result2->fetch_assoc();

                $sql3 = "SELECT * FROM user_address WHERE id='$address_id'";
                $result3 = $conn->query($sql3);
                $row3 = $result3->fetch_assoc();

                $sql4 = "SELECT * FROM order_details WHERE latitude='$user_id' AND username='$username'";
                $result4 = $conn->query($sql4);
                $num_times_order = $result4->num_rows;

                $d["id"] = $row2["sno"];
                $d["name"] = $row2["name"];
                $d["mobile_number"] = $row2["phone"];
                $d["address"] = $row3["addr"];
                $d["no_of_times_order"] = $num_times_order;

                $tem["status"] = "success";
                $tem["message"] = "Branch found";
                $tem["Veggis"][$i]["id"] = $row["sno"];
                $tem["Veggis"][$i]["orderid"] = $oid;
                $tem["Veggis"][$i]["booked_date"] = date('d-m-Y', strtotime($row["booking_date"]));
                $tem["Veggis"][$i]["booked_time"] = $row["booking_time"];
                $tem["Veggis"][$i]["delivery_slot"] = $row["delivery_slot"];
                $tem["Veggis"][$i]["order_status"] = $order_status;
                $tem["Veggis"][$i]["total_amount"] = $row["overall_total_amount"];
                $tem["Veggis"][$i]["total_recipe_amount"] = $row["recipe_total_amount"];
                $tem["Veggis"][$i]["packing_charge"] = $row["packing_charge"];
                $tem["Veggis"][$i]["delivery_charges"] = $row["delivery_charge"];
                $tem["Veggis"][$i]["mode_of_payment"] = $row["delivery_type"];

                $tem["Veggis"][$i]["recipie_details"] = $r;
                $tem["Veggis"][$i]["user_details"] = $d;
                $tem["Veggis"][$i]["latitude"] = $row["lati"];
                $tem["Veggis"][$i]["longitude"] = $row["longi"];
                $tem["Veggis"][$i]["coupon_applied"] = $row["coupon"];
                $tem["Veggis"][$i]["redeem_point_used"] = $row["redeem_point"];

                $json = json_encode($tem);
                $i++;
            }
            $json = json_encode($tem);

            echo $json;
        }
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to Find Brance.";
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