<?php
    include("../inc/dbconn.php");

    $sql = "SELECT * FROM api_key";
    $result = $conn->query($sql);
    $tem = array();
    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();

        $sql1 = "SELECT * FROM charges";
        $result1 = $conn->query($sql1);
        $row1 = $result1->fetch_assoc();

        $sql1 = "SELECT * FROM compo_product WHERE status ='1'";
        $result1 = $conn->query($sql1);
		if($result1->num_rows > 0)
		{
            $combo_status = '1';
        }
        else
        {
            $combo_status = '0';
        }

        $tem["fcm_token"] = $row["fcm_token"];
        $tem["api"] = $row["api"];
        $tem["merchant_id"] = $row["merchant_id"];
        $tem["merchant_key"] = $row["merchant_key"];
        $tem["app_version_name"] = $row["app_version_name"];
        $tem["delivery_app_version_name"] = $row["delivery_app_version_name"];
        $tem["cart_count"] = $row1["addcart"];        
        $tem["compo_product_banner"] = $row["compo_product_banner"];
        $tem["compo_product_status"] = $combo_status;

        $json = json_encode($tem);
    }
    else
    {
        echo "No Results Found.";
    }
    echo $json;
?>