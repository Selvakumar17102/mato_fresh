<?php
    include("../../inc/dbconn.php");

    if(!empty($_POST["zone_id"]))
    {
        $id = $_POST["zone_id"];

        $proSql = "SELECT *,b.id as proid,b.name as productname,b.image as productimage FROM `store_inventory` a LEFT OUTER JOIN product b ON a.product_id=b.id LEFT OUTER JOIN price c ON a.product_id=c.pid WHERE a.store_id = '$id'";
		$proResult = $conn->query($proSql);
        $i = 0;
		while($proRow = $proResult->fetch_assoc()){
            $productId = $proRow["proid"];

            $output['GTS'][$i]['product_id'] = (int)$productId;
			$output['GTS'][$i]['productname'] = $proRow['productname'];
			$output['GTS'][$i]['productimage'] = $proRow['productimage'];
			$output['GTS'][$i]['price'] = $proRow['amo'];
			$output['GTS'][$i]['weight'] = $proRow['weight'];
			$output['GTS'][$i]['count'] = $proRow['store_quantity'];

            $i++;
        }
    }
    echo json_encode($output);
?>