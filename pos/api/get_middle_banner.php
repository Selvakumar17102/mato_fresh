<?php
    include("../inc/dbconn.php");

    $sql = "SELECT * FROM banner WHERE posit='2'";
    $result = $conn->query($sql);
    $tem = array();
    $i = 0;
    if($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            $cate = $row["cate"];

            $sql1 = "SELECT * FROM category WHERE id='$cate'";
            $result1 = $conn->query($sql1);
            $row1 = $result1->fetch_assoc();

            $tem["Veggis"][$i]["banner_id"] = $row["id"];
            $tem["Veggis"][$i]["banner_image"] = $row["image"];
            $tem["Veggis"][$i]["category_id"] = $row["cate"];
            $tem["Veggis"][$i]["category_name"] = $row1["name"];

            $json = json_encode($tem);
            $i++;
        }

        $tem["status"] = "success";
        $tem["message"] = "Banner Found";
        $json = json_encode($tem);

        echo $json;
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to Find Banner.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>