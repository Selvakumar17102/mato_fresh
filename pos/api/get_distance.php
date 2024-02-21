<?php
    include("../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->latitude) && !empty($data->longitude))
    {
        $latitudeTo = $data->latitude;
        $longitudeTo = $data->longitude;

        $nullarray = array();
        $sql = "SELECT * FROM hotel";
        $result = $conn->query($sql);
        $i = 0;
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $id = $row["lid"];
                $latitudeFrom = $row["lati"];
                $longitudeFrom = $row["longi"];

                $theta    = $longitudeFrom - $longitudeTo;
                $dist    = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
                $dist    = acos($dist);
                $dist    = rad2deg($dist);
                $miles    = $dist * 60 * 1.1515;

                $nullarray[$id] = round($miles * 1.609344, 2);

                $i++;
            }
            
            $not = asort($nullarray);
            $tem = array();
            $i = 0;
            $json = "";

            foreach($nullarray as $x => $x_value)
            {
                $sql1 = "SELECT * FROM hotel WHERE lid='$x'";
                $result1 = $conn->query($sql1);
                $row1 = $result1->fetch_assoc();

                $tem["Pickneats"][$i]["id"] = $row1["lid"];
                $tem["Pickneats"][$i]["branch_name"] = $row1["name"];
                $tem["Pickneats"][$i]["branch_image"] = "pickneats.com/dashboard/".$row1["image"];
                $tem["Pickneats"][$i]["distance"] = $x_value." Km";

                $json = json_encode($tem);
                $i++;
            }

            echo $json;
        }
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "No Branch Found.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "No Branch Available.Data is Incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }

?>