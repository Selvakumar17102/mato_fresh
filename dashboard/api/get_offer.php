<?php
    include("../inc/dbconn.php");

    $sql = "SELECT * FROM product_offer WHERE status='0' ORDER BY name ASC";
    $result = $conn->query($sql);
    $json = "";
    if($result->num_rows > 0)
    {
        $tem = array();
        $i = 0;
        while($row = $result->fetch_assoc())
        {
            $id = $row["id"];

            $sql1 = "SELECT * FROM offer_product WHERE oid='$id'";
            $result1 = $conn->query($sql1);
            if($result1->num_rows > 0)
            {
                $tem["Veggis"][$i]["id"] = $row["id"];
                $tem["Veggis"][$i]["name"] = $row["name"];
                $tem["Veggis"][$i]["image"] = $row["image"];

                $i++;
                $json = json_encode($tem);
            }
        }
        if($i == 0)
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "Fail";
            $myObj->message = "No offer available.";
            $json = json_encode($myObj);
        }
        else
        {
            $tem["status"] = "success";
            $tem["message"] = "Offers Found";
            $json = json_encode($tem);
        }
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "Fail";
        $myObj->message = "No offer available.";
        $json = json_encode($myObj);
    }
    echo $json;
?>