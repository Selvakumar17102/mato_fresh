<?php
    include("../inc/dbconn.php");

    $sql = "SELECT * FROM timeslot";
    $result = $conn->query($sql);
    $tem = array();
    $i = 0;
    if($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            $tem["Veggis"][$i]["id"] = $row["id"];
            $tem["Veggis"][$i]["in_slot"] = date('H:i', strtotime($row["time"]));
            $tem["Veggis"][$i]["out_slot"] = date('H:i', strtotime($row["time2"]));

            $json = json_encode($tem);
            $i++;
        }
		
		$tem["status"] = "success";
		$tem["message"] = "Time slot found.";
		
		$json = json_encode($tem);

        echo $json;
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "No Time Slot available.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>