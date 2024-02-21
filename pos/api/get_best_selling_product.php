<?php
    include("../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));
    $mobile_number = $data->mobile_number;

    $sql = "SELECT * FROM recipe_details GROUP BY product_id ORDER BY count(*) DESC LIMIT 5";
    $result = $conn->query($sql);
    $tem = array();
    $i = 0;
    $json = "";
    if($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            $pid = $row["product_id"];
            $var = $demo = $amo = $cont = "";

            $sql2 = "SELECT * FROM product WHERE id='$pid'";
            $result2 = $conn->query($sql2);
            if($result2->num_rows > 0){
                $row2 = $result2->fetch_assoc();

                $cate = $row2["cate"];

                $sql6 = "SELECT * FROM favs WHERE phone='$mobile_number' AND pro_id = '$pid'";
                $result6 = $conn->query($sql6);
                if($result6->num_rows > 0)
                {
                    $fav = 1;
                } else {
                    $fav = 0;
                }

                $sql3 = "SELECT * FROM category WHERE id='$cate' AND status='0'";
                $result3 = $conn->query($sql3);

                $r = array();

                $sql5 = "SELECT * FROM price WHERE pid='$pid'";
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

                if($result3->num_rows > 0)
                {
                    $tem["Veggis"][$i]["id"] = $pid;
                    $tem["Veggis"][$i]["category_id"] = $row2["cate"];
                    $tem["Veggis"][$i]["product_name"] = $row2["name"];
                    $tem["Veggis"][$i]["img_url"] = $row2["image"];
                    $tem["Veggis"][$i]["product_desciption"] = $row2["descrip"];
                    $tem["Veggis"][$i]["variation"] = $cont;
                    $tem["Veggis"][$i]["variation_name"] = $var;
                    $tem["Veggis"][$i]["demoamt"] = $demo;
                    $tem["Veggis"][$i]["price"] = $amo;
                    $tem["Veggis"][$i]["product_details"] = $r;
                    $tem["Veggis"][$i]["is_favourite"] = $fav;

                    $json = json_encode($tem);
                    $i++;
                }
            }
        }

        if($i != 0)
        {
            $tem["status"] = "success";
            $tem["message"] = "Product Found";
            $json = json_encode($tem);
        }
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to Find Products.";
            $json = json_encode($myObj);
        }
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to Find Products.";
        $json = json_encode($myObj);
    }

    if($json == "")
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "No Products Available.";
        $json = json_encode($myObj);
    }

    echo $json;    
?>