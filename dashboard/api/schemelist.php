<?php
    include("../inc/dbconn.php");

    $sql = "SELECT * FROM subscription";
    $result = $conn->query($sql);
    $tem = array();
    $i = 0;
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            
            $explodeproduct = explode(",",$row["productId"]);
            
            

                $tem["scheme"][$i]["id"] = $row["id"];
                $tem["scheme"][$i]["schemename"] = $row["schemename"];
                $tem["scheme"][$i]["schemeday"] = $row["schemeday"]." Days";
                $tem["scheme"][$i]["schemeamount"] = $row["schemeamount"];
                $tem["scheme"][$i]["totaldelivery"] = $row["totaldelivery"];
                $tem["scheme"][$i]["productcount"] = $row["productcount"];
                $tem["scheme"][$i]["mainproductcount"] = sizeof($explodeproduct);
                $i++;
        }

        if($i == 0){
            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Scheme Data Not found.";
            $json = json_encode($myObj);
        }else{
            $tem["status"] = "success";
            $tem["message"] = "Scheme found.";
            $json = json_encode($tem);
        }
    }else{
        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Scheme Data Not found.";
        $json = json_encode($myObj);
    }

    echo $json;
?>