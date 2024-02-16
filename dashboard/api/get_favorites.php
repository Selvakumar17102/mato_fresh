<?php
    include("../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->mobile_number))
    {
        $phone = $data->mobile_number;

        $sql = "SELECT * FROM favs WHERE phone='$phone'";
        $result = $conn->query($sql);
        $tem = array();
        $i = 0;
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $pro = $row["pro_id"];

                $sql1 = "SELECT * FROM product WHERE id='$pro'";
                $result1 = $conn->query($sql1);
                if($result1->num_rows > 0)
                {
                    $row1 = $result1->fetch_assoc();

                    $var = $demo = $amo = $cont = "";
                    $pro = $row1["id"];
                    $categoryid = $row1["cate"];

                    $sql2 = "SELECT * FROM category WHERE id='$categoryid'";
                    $result2 = $conn->query($sql2);
                    if($result2->num_rows > 0)
                    {
                        $row2 = $result2->fetch_assoc();

                        $r = array();

                        $sql5 = "SELECT * FROM price WHERE pid='$pro'";
                        $result5 = $conn->query($sql5);
                        $j = 0;
                        if($result5->num_rows == 1)
                        {
                            $cont = "false";
                            $row5 = $result5->fetch_assoc();

                            $var = $row5["weight"];
                            $demo = $row5["demo"];
                            $amo = $row5["amo"];
                        }
                        else
                        {
                            $cont = "true";
                            while($row5 = $result5->fetch_assoc())
                            {
                                $r[$j]["price_id"] = $row5["id"];
                                $r[$j]["product_weight"] = $row5["weight"];
                                $r[$j]["product_demo_amount"] = $row5["demo"];
                                $r[$j]["product_amount"] = $row5["amo"];

                                $j++;
                            }
                        }

                        if($row1["recom"] == "")
                        {
                            $row1["recom"] = 0;
                        }

                        $tem["Veggis"][$i]["id"] = $row["id"];
                        $tem["Veggis"][$i]["pid"] = $row["pro_id"];
                        $tem["Veggis"][$i]["category_id"] = $row2["id"];
                        $tem["Veggis"][$i]["category_name"] = $row2["name"];
                        $tem["Veggis"][$i]["product_name"] = $row1["name"];
                        $tem["Veggis"][$i]["img_url"] = $row1["image"];
                        $tem["Veggis"][$i]["available"] = $row1["status"];
                        $tem["Veggis"][$i]["recommended"] = $row1["recom"];
                        $tem["Veggis"][$i]["variation"] = $cont;
                        $tem["Veggis"][$i]["variation_name"] = $var;
                        $tem["Veggis"][$i]["demoamt"] = $demo;
                        $tem["Veggis"][$i]["price"] = $amo;
                        $tem["Veggis"][$i]["product_details"] = $r;
                        $tem["Veggis"][$i]["type"] = $row1["type"];

                        $json = json_encode($tem);
                        $i++;
                    }
                }
            }

            if($i == 0)
            {
                $myObj = new \stdClass();
                $myObj->status = "fail";
                $myObj->message = "No Favourites Available.";
                $myJSON = json_encode($myObj);
                echo $myJSON;
            }
            else
            {
                $tem["status"] = "success";
                $tem["message"] = "Favourites Found";
                $json = json_encode($tem);

                echo $json;
            }
        }
        else
        {
            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "No Favourites Available.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "No Favourites Available.Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>