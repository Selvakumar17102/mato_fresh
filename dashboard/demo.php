<?php

    include("inc/dbconn.php");

    $latitudeTo = "25.282501";
    $longitudeTo = "51.525530";

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

        $nullarray[$id] = round($miles * 1.609344, 2);

        $i++;
    }
    
    $not = asort($nullarray);

    foreach($nullarray as $x => $x_value)
    {
        $sql1 = "SELECT * FROM hotel WHERE lid='$x'";
        $result1 = $conn->query($sql1);
        $row1 = $result1->fetch_assoc();
        if($x_value <= 20)
        {
            echo "Branch Name = " . $row1["name"] . ", Distance = " . $x_value." KM";
            echo "<br>";
        }
    }

?>