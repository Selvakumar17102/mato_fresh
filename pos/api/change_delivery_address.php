<?php
    include("../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->latitude) && !empty($data->longitude))
    {
        $latitudeTo = $data->latitude;
        $longitudeTo = $data->longitude;
        $hotelid = $data->branch_id;

        $nullarray = array();
        $sql = "SELECT * FROM hotel";
        $result = $conn->query($sql);
        $i = 0;
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

            $kms = round($miles * 1.609344, 2);
            
            $nullarray[$id] = $kms;
        }

        asort($nullarray);

        $km = $i = 0;

        foreach($nullarray as $x => $x_value)
        {
            if($i == 0)
            {
                $km = $x_value;
            }
            $i++;
        }

        $sql3 = "SELECT * FROM charges WHERE id='1'";
        $result3 = $conn->query($sql3);
        $row3 = $result3->fetch_assoc();
        
        if($row3["distance"] >= $km)
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "success";
            $myObj->message = "Shop is in Service.";
            $json = json_encode($myObj);
        }
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Delivery not available for your location. Delivery available only within ".$row3['distance']."km.";
            $json = json_encode($myObj);
        }
        echo $json;
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "No Status Available.Data is Incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }

?>