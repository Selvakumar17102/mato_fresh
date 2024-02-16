<?php
    ini_set('display_errors','off');
    include("../inc/dbconn.php");

    $sql = "SELECT * FROM price WHERE demo!='0' GROUP BY pid";
    $result = $conn->query($sql);
    $json = "";
    $tem = array();
    $i = 0;
    if($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            $pro = $row["pid"];

            $sql1 = "SELECT * FROM product WHERE id='$pro'";
            $result1 = $conn->query($sql1);
            if($result1->num_rows > 0)
            {
                $row1 = $result1->fetch_assoc();

                $categoryid = $row1["cate"];
                $var = $demo = $amo = $cont = "";

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

                $sql2 = "SELECT * FROM category WHERE id='$categoryid'";
                $result2 = $conn->query($sql2);
                $row2 = $result2->fetch_assoc();

                if($row1["recom"] == "")
                {
                    $row1["recom"] = 0;
                }
                
                $per = "0";            
                if($row["demo"] != "" && $row["demo"] != 0)
                {
                    $per = $row["amo"] / $row["demo"] * 100;
                }

                $tem["Veggis"][$i]["id"] = $row1["id"];
                $tem["Veggis"][$i]["category_id"] = $row2["id"];
                $tem["Veggis"][$i]["category_name"] = $row2["name"];
                $tem["Veggis"][$i]["product_name"] = $row1["name"];
                $tem["Veggis"][$i]["variation"] = $cont;
                $tem["Veggis"][$i]["variation_name"] = $var;
                $tem["Veggis"][$i]["demoamt"] = $demo;
                $tem["Veggis"][$i]["price"] = $amo;
                $tem["Veggis"][$i]["price_offer_percentage"] = number_format(100 - $per)." %";
                $tem["Veggis"][$i]["product_details"] = $r;
                $tem["Veggis"][$i]["img_url"] = $row1["image"];
                $tem["Veggis"][$i]["available"] = $row1["status"];
                $tem["Veggis"][$i]["recommended"] = $row1["recom"];
                $tem["Veggis"][$i]["type"] = $row1["type"];
                    
                $json = json_encode($tem);
                $i++;
            }
        }

        if($i == 0)
        {
            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "No Products Available.";
            $json = json_encode($myObj);
        }
        else
        {
            $tem["status"] = "success";
            $tem["message"] = "Products Found";
            $json = json_encode($tem);   
        }
    }
    else
    {
        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "No Products Available.";
        $json = json_encode($myObj);
    }
    echo $json;
    
?>