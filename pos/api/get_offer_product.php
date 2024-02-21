<?php
    include("../inc/dbconn.php");
    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->offer_id))
    {
        $oid = $data->offer_id;

        $sql = "SELECT * FROM offer_product WHERE oid='$oid'";
        $result = $conn->query($sql);
        $tem = array();
        $i = 0;
		if($result->num_rows > 0)
		{
			while($row = $result->fetch_assoc())
			{
				$tem["Veggis"][$i]["id"] = $row["id"];
				$tem["Veggis"][$i]["name"] = $row["name"];
				$tem["Veggis"][$i]["image"] = $row["image"];
				$tem["Veggis"][$i]["demo_amount"] = $row["demo"];
				$tem["Veggis"][$i]["original_amount"] = $row["amo"];
				$tem["Veggis"][$i]["variation"] = $row["vari"];
				$tem["Veggis"][$i]["quantity"] = $row["qua"];

				$i++;
				$json = json_encode($tem);
			}
        $tem["status"] = "success";
        $tem["message"] = "Products Found";
        $json = json_encode($tem);
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "Fail";
        $myObj->message = "Products Not Found.";
        $json = json_encode($myObj);
    }
    echo $json;
	}
?>