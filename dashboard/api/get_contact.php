<?php
    include("../inc/dbconn.php");

    $sql = "SELECT * FROM contacts WHERE id='1'";
    $result = $conn->query($sql);
    if($result->num_rows > 0)
    {
        $tem = array();
        $row = $result->fetch_assoc();

        $tem["about_us"] = $row["about"];
        $tem["contact_us"] = $row["contact"];
        $tem["privacy_policy"] = $row["privacy"];

        $json = json_encode($tem);

        $tem["status"] = "success";
        $tem["message"] = "Contact Found";
        $json = json_encode($tem);
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to Find Privacy Policy.";
        $myJSON = json_encode($myObj);
        $json = $myJSON;
    }

    echo $json;    
?>