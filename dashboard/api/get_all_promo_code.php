<?php
    include("../inc/dbconn.php");

    $sql = "SELECT * FROM offers";
    $result = $conn->query($sql);
    $tem = array();
    $json = "";
    $i = 0;
    if($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            $det = "Flat Rs.".$row["max"]." OFF on Purchase of Rs.".$row["min"]." and Above";
		
            $tem["Veggis"][$i]["sno"] = $row["percent"]."%";
            $tem["Veggis"][$i]["promocode"] = $row["code"];
            $tem["Veggis"][$i]["promoprice"] = $row["min"];
            $tem["Veggis"][$i]["promohighprice"] = $row["max"];
            $tem["Veggis"][$i]["promodetailes"] = $det;
            $tem["Veggis"][$i]["promo_in_app"] = '0';
            $tem["Veggis"][$i]["promo_status"] = $row["status"];
                
            $json = json_encode($tem);
            $i++;
        }

        $tem["status"] = "success";
        $tem["message"] = "Offer Found";
        $json = json_encode($tem);

        echo $json;
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to Find Promo Code.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>