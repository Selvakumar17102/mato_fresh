<?php
    ini_set('display_errors','off');
    include("../inc/dbconn.php");
    $data = json_decode(file_get_contents('php://input'));

        $sql = "SELECT * FROM compo_product WHERE status ='1' ORDER BY id DESC";
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
				$tem["Veggis"][$i]["quantity"] = $row["qua"];
				$tem["Veggis"][$i]["description"] = $row["description"];

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
?>