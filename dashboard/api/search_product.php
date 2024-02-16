<?php
    include("../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->search_keyword))
    {
        $key = $data->search_keyword;
        $mobile_number = $data->mobile_number;

        $json = "";

        $sql = "SELECT * FROM product WHERE keyw LIKE '%$key%'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $i = 0;
            while($row = $result->fetch_assoc())
            {
                $var = $demo = $amo = $cont = "";
                $pro = $row["id"];
                $categoryid = $row["cate"];
                $subcategoryid = $row["sub_cate"];

                $sql6 = "SELECT * FROM favs WHERE phone='$mobile_number' AND pro_id = '$pid'";
                $result6 = $conn->query($sql6);
                if($result6->num_rows > 0)
                {
                    $fav = 1;
                } else {
                    $fav = 0;
                }

                $sql2 = "SELECT * FROM category WHERE id='$categoryid'";
                $result2 = $conn->query($sql2);
                $row2 = $result2->fetch_assoc();

                $sql7 = "SELECT * FROM subcategory WHERE id='$subcategoryid'";
                $result7 = $conn->query($sql7);
                $row7 = $result7->fetch_assoc();

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

                if($row["recom"] == "")
                {
                    $row["recom"] = 0;
                }

                $tem["Veggis"][$i]["id"] = $row["id"];
                $tem["Veggis"][$i]["category_id"] = $row2["id"];
                $tem["Veggis"][$i]["category_name"] = $row2["name"];
                $tem["Veggis"][$i]["subcategory_id"] = $row7["id"];
                $tem["Veggis"][$i]["subcategory_name"] = $row7["name"];
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
                $tem["Veggis"][$i]["is_favourite"] = $fav;
                    
                $json = json_encode($tem);
                $i++;
            }

            if($json == "")
            {
                http_response_code(200);

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
            echo $json;
        }
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to Find Products.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to Find Products.Data is Incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>