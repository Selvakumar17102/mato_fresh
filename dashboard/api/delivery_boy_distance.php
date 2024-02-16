<?php
    include("../inc/dbconn.php");
    include("distance-calculator-n.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->delivery_latitude) && !empty($data->delivery_longitude) && !empty($data->latitude) && !empty($data->longitude))
    {
        $latitudeTo = $data->delivery_latitude;
        $longitudeTo = $data->delivery_longitude;
        $latitudeFrom = $data->latitude;
        $longitudeFrom = $data->longitude;
        
        $kms = getDistance($latitudeFrom,$longitudeFrom,$latitudeTo,$longitudeTo);

        $nullarray = array();
        if($kms < 10)
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "success";
            $myObj->message = "Delivery Boy is in the Zone.";
            $json = json_encode($myObj);
            
            echo $json;
        }
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Delivery Boy is out of Zone.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
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