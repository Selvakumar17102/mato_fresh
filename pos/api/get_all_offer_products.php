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
            $row1 = $result1->fetch_assoc();

            $categoryid = $row1["cate"];
            $subcategoryid = $row1["sub_cate"];

            $sql2 = "SELECT * FROM category WHERE id='$categoryid'";
            $result2 = $conn->query($sql2);
            $row2 = $result2->fetch_assoc();

            if($row1["recom"] == "")
            {
                $row1["recom"] = 0;
            }

            $tem["Veggis"][$i]["id"] = $row1["id"];
            $tem["Veggis"][$i]["category_id"] = $row2["id"];
            $tem["Veggis"][$i]["category_name"] = $row2["name"];
            $tem["Veggis"][$i]["product_name"] = $row1["name"];
            $tem["Veggis"][$i]["img_url"] = $row1["image"];
            $tem["Veggis"][$i]["available"] = $row1["status"];
            $tem["Veggis"][$i]["recommended"] = $row1["recom"];
            $tem["Veggis"][$i]["type"] = $row1["type"];
                
            $json = json_encode($tem);
            $i++;
        }

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
    echo $json;
    
?>