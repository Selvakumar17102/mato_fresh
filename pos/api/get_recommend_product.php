<?php
    ini_set('display_errors','off');
    include("../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

        $count = $data->count;
        $json = $variation = "";

        if($count != "" || $count != "0")
        {
            $max = ($count + 1) * 10;
            $start = $max - 10;

            $sql = "SELECT * FROM product WHERE recom = '1' ORDER BY name ASC";
            $result = $conn->query($sql);
            if($max >= $result->num_rows)
            {
                $variation = "true";
            }
            else
            {
                $variation = "false";
            }

            $sql = "SELECT * FROM product WHERE recom = '1' ORDER BY name ASC LIMIT $max";
            $result = $conn->query($sql);
            $tem = array();
            $i = 0;
            $j1 = 1;
            if($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc())
                {
                    if($j1 > $start)
                    {
                        $var = $demo = $amo = $cont = "";
                        $pro = $row["id"];
                        $categoryid = $row["cate"];

                        $sql2 = "SELECT * FROM category WHERE id='$categoryid'";
                        $result2 = $conn->query($sql2);
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
                                $per = "0";
                                if($row5["demo"] != "")
                                {
                                    $per = $row5["amo"] / $row5["demo"] * 100;
                                }
                                $r[$j]["price_id"] = $row5["id"];
                                $r[$j]["product_weight"] = $row5["weight"];
                                $r[$j]["product_demo_amount"] = $row5["demo"];
                                $r[$j]["product_amount"] = $row5["amo"];
                                $r[$j]["price_offer_percentage"] = number_format(100 - $per)." %";
                                $j++;
                            }
                        }

                        if($row["recom"] == "")
                        {
                            $row["recom"] = 0;
                        }

                        $per = "0";
                        if($row5["demo"] != "")
                        {
                            $per = $row5["amo"] / $row5["demo"] * 100;
                        }

                        $tem["Veggis"][$i]["id"] = $row["id"];
                        $tem["Veggis"][$i]["category_id"] = $row2["id"];
                        $tem["Veggis"][$i]["category_name"] = $row2["name"];
                        $tem["Veggis"][$i]["product_name"] = $row["name"];
                        $tem["Veggis"][$i]["img_url"] = $row["image"];
                        $tem["Veggis"][$i]["variation"] = $cont;
                        $tem["Veggis"][$i]["variation_name"] = $var;
                        $tem["Veggis"][$i]["demoamt"] = $demo;
                        $tem["Veggis"][$i]["price"] = $amo;
                        $tem["Veggis"][$i]["product_details"] = $r;
                        $tem["Veggis"][$i]["available"] = $row["status"];
                        $tem["Veggis"][$i]["recommended"] = $row["recom"];
                        $tem["Veggis"][$i]["type"] = $row["type"];
                        $tem["Veggis"][$i]["price_offer_percentage"] = number_format(100 - $per)." %";
                            
                        $json = json_encode($tem);
                        $i++;
                    }
                    $j1++;
                }
                $tem["total"] = $variation;
                $tem["status"] = "success";
                $tem["message"] = "Products Found";
                $json = json_encode($tem);
            }
            else
            {
                http_response_code(200);

                $myObj = new \stdClass();
                $myObj->status = "fail";
                $myObj->message = "No Products Available.";
                $json = json_encode($myObj);
            }
        }
        else
        {
            $sql = "SELECT * FROM product WHERE recom='1' ORDER BY name ASC LIMIT 10";
            $result = $conn->query($sql);
            $tem = array();
            $i = 0;
            if($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc())
                {
                    $var = $demo = $amo = $cont = "";
                    $pro = $row["id"];
                    $categoryid = $row["cate"];

                    $sql2 = "SELECT * FROM category WHERE id='$categoryid'";
                    $result2 = $conn->query($sql2);
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
                            $per = "0";
                            if($row5["demo"] != "")
                            {
                                $per = $row5["amo"] / $row5["demo"] * 100;
                            }
                            $r[$j]["price_id"] = $row5["id"];
                            $r[$j]["product_weight"] = $row5["weight"];
                            $r[$j]["product_demo_amount"] = $row5["demo"];
                            $r[$j]["product_amount"] = $row5["amo"];
                            $r[$j]["price_offer_percentage"] = number_format(100 - $per)." %";
                            $j++;
                        }
                    }

                    if($row["recom"] == "")
                    {
                        $row["recom"] = 0;
                    }

                    $per = "0";
                    if($row5["demo"] != "")
                    {
                        $per = $row5["amo"] / $row5["demo"] * 100;
                    }

                    $tem["Veggis"][$i]["id"] = $row["id"];
                    $tem["Veggis"][$i]["category_id"] = $row2["id"];
                    $tem["Veggis"][$i]["category_name"] = $row2["name"];
                    $tem["Veggis"][$i]["product_name"] = $row["name"];
                    $tem["Veggis"][$i]["img_url"] = $row["image"];
                    $tem["Veggis"][$i]["variation"] = $cont;
                    $tem["Veggis"][$i]["variation_name"] = $var;
                    $tem["Veggis"][$i]["demoamt"] = $demo;
                    $tem["Veggis"][$i]["price"] = $amo;
                    $tem["Veggis"][$i]["product_details"] = $r;
                    $tem["Veggis"][$i]["available"] = $row["status"];
                    $tem["Veggis"][$i]["recommended"] = $row["recom"];
                    $tem["Veggis"][$i]["type"] = $row["type"];
                    $tem["Veggis"][$i]["price_offer_percentage"] = number_format(100 - $per)." %";
                        
                    $json = json_encode($tem);
                    $i++;
                }

                $tem["total"] = "false";
                $tem["status"] = "success";
                $tem["message"] = "Products Found";
                $json = json_encode($tem);
            }
            else
            {
                http_response_code(200);

                $myObj = new \stdClass();
                $myObj->status = "fail";
                $myObj->message = "No Products Available.";
                $json = json_encode($myObj);
            }
        }
    echo $json;
?>