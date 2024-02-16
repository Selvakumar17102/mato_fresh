<?php
    include("../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    $phone = $data->mobile_number;

    $sql = "SELECT * FROM user_address WHERE phone='$phone'";
    $result = $conn->query($sql);
    $tem = array();
    $i = 0;
    if($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            $tem["Veggis"][$i]["address_id"] = $row["id"];
			$tem["Veggis"][$i]["address_name"] = $row["name"];
            $tem["Veggis"][$i]["address"] = $row["addr"];
            $tem["Veggis"][$i]["floor_no"] = $row["floor_no"];
			$tem["Veggis"][$i]["floor"] = $row["floor"];
			$tem["Veggis"][$i]["address_type"] = $row["type"];
            $tem["Veggis"][$i]["landmark"] = $row["land"];
            $tem["Veggis"][$i]["latitude"] = $row["lati"];
            $tem["Veggis"][$i]["longitude"] = $row["longi"];

            $json = json_encode($tem);
            $i++;
        }

        $tem["status"] = "success";
        $tem["message"] = "User address Found";
        $json = json_encode($tem);

        echo $json;
        $conn->close();
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to Find User Adress.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>