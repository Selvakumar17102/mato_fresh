<?php
    include("../../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->search_keyword)){
        $search_keyword = $data->search_keyword;

        $sql = "SELECT * FROM product WHERE name LIKE '%$search_keyword%' ORDER BY name ASC";
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
                        $r[$j]["variation_id"] = $row5["id"];
                        $r[$j]["variation"] = $row5["weight"];
                        $r[$j]["demo_amount"] = $row5["demo"];
                        $r[$j]["amount"] = $row5["amo"];

                        $j++;
                    }
                }

                if($row["recom"] == "")
                {
                    $row["recom"] = 0;
                }

                $sql6 = "SELECT * FROM favs WHERE phone='$mobile_number' AND pro_id = '$pro'";
                $result6 = $conn->query($sql6);
                if($result6->num_rows > 0)
                {
                    $fav = 1;
                } else {
                    $fav = 0;
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
                $tem["Veggis"][$i]["price_variation"] = $r;
                $tem["Veggis"][$i]["product_status"] = $row["status"];
                $tem["Veggis"][$i]["status"] = "success";
                $tem["Veggis"][$i]["message"] = "Products Found";
                    
                $json = json_encode($tem);
                $i++;
            }
            $tem["status"] = "success";
            $tem["message"] = "Products Found";
            echo json_encode($tem);
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
    else{
        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "unable to update. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>