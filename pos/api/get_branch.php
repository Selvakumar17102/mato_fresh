<?php
    include("../inc/dbconn.php");

    $sql = "SELECT * FROM zone ORDER BY name ASC";
    $result = $conn->query($sql);
    $tem = array();
    $i = 0;
    if($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            if($row["status"] == 0)
            {
                $tem["Veggis"][$i]["id"] = $row["id"];
                $tem["Veggis"][$i]["branch_name"] = $row["name"];

                $i++;
            }
        }

        if($i == 0)
        {
            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to Find Branch.";
            $json = json_encode($myObj);
        }
        else
        {
            $tem["status"] = "success";
            $tem["message"] = "Branch found.";

            $json = json_encode($tem);
        }
    }
    else
    {
        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to Find Branch.";
        $json = json_encode($myObj);
    }

    echo $json;
?>