<?php
    include("../inc/dbconn.php");

    // get posted data
    $data = json_decode(file_get_contents('php://input'));

    // make sure data is not empty
    if(!empty($data->mobile_number)) 
    {
        $phone = $data->mobile_number;

        $sql = "SELECT * FROM login WHERE phone='$phone'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();

            $id = $row["id"];

            $sql = "SELECT * FROM order_details WHERE longitude='$id' ORDER BY sno DESC";
            $result = $conn->query($sql);
            $tem = array();
            $i = 0;
            if($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc())
                {
                    $long = $row["latitude"];
                    $oid = $row["orderid"];
                    $order_status = "";
                    $r = array();

                    $sql1 = "SELECT * FROM recipe_details WHERE orderid='$oid'";
                    $result1 = $conn->query($sql1);
                    $j = 0;
                    while($row1 = $result1->fetch_assoc())
                    {
                        $r[$j]["recipe_name"] = $row1["recipe_name"];
                        $r[$j]["recipe_quantity"] = $row1["no_quantity"];
                        $r[$j]["variation"] = $row1["variation"];
                        $r[$j]["recipe_price"] = $row1["recipe_price"];

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

                    $h["id"] = $row2["lid"];
                    $h["name"] = $row2["name"];
                    $h["address"] = $row2["addr"];
                    $h["mobileno"] = $row3["phone"];
                    $h["latitude"] = $row2["lati"];
                    $h["longitude"] = $row2["longi"];

                    $tem["Veggis"][$i]["id"] = $row["sno"];
                    $tem["Veggis"][$i]["orderid"] = $row["orderid"];
                    $tem["Veggis"][$i]["booked_date"] = date('d-m-Y',strtotime($row["booking_date"]));					
                    $tem["Veggis"][$i]["booked_time"] = $row["booking_time"];
                    $tem["Veggis"][$i]["total_amount"] = $row["overall_total_amount"];
                    $tem["Veggis"][$i]["order_status"] = $order_status;
                    $tem["Veggis"][$i]["branch"] = $h;
                    $tem["Veggis"][$i]["recipie_details"] = $r;
                    $tem["Veggis"][$i]["total_recipe_amount"] = $row["recipe_total_amount"];
                    $tem["Veggis"][$i]["delivery_charges"] = $row["delivery_charge"];
                    $tem["Veggis"][$i]["delivery_slot"] = $row["delivery_slot"];
                    $tem["Veggis"][$i]["mode_of_payment"] = $row["delivery_type"];
                    $tem["Veggis"][$i]["total_cost"] = (string)$row["km"];

                    $json = json_encode($tem);
                    $i++;
                }

                $tem["status"] = "success";
                $tem["message"] = "Delivery Partner Found";
                $json = json_encode($tem);

                echo $json;
            }
            else
            {
                http_response_code(503);

                $myObj = new \stdClass();
                $myObj->status = "fail";
                $myObj->message = "Unable to Find Order.";
                $myJSON = json_encode($myObj);
                echo $myJSON;
            }
        }
        else
        {
            http_response_code(503);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to Find Order,Mobile number does not exists.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        http_response_code(400);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to Find Order. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }