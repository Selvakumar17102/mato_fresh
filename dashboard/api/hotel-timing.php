<?php

    include("../inc/dbconn.php");

    $sql = "SELECT * FROM charges";
    $result = $conn->query($sql);
    $tem = array();
    $i = 0;
    if($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();

        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->intime = date('H:i', strtotime($row["intime"]));
        $myObj->outtime = date('H:i', strtotime($row["outtime"]));
        $myObj->status = "success";
        $myObj->message = "Timings found.";
        $myJSON = json_encode($myObj);
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to Find Branch.";
        $myJSON = json_encode($myObj);
    }

    echo $myJSON;
?>