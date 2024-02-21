<?php
    include("../../inc/dbconn.php");

    $sql = "SELECT * FROM category WHERE status = '0' ORDER BY arrange ASC";
    $result = $conn->query($sql);
    $tem = array();
    $i = 0;
    if($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            $tem["Veggis"][$i]["category_id"] = $row["id"];
            $tem["Veggis"][$i]["category_name"] = $row["name"];
            $tem["Veggis"][$i]["category_image"] = $row["image"];
            $tem["Veggis"][$i]["category_status"] = $row["status"];

            $json = json_encode($tem);
            $i++;
        }

        $tem["status"] = "success";
        $tem["message"] = "Category Found";
        $json = json_encode($tem);
        
        echo $json;
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "No Categories Available.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>