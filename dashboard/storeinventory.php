<?php
include("inc/dbconn.php");

if(isset($_POST['inventorysubmit'])){

    $date = $_POST['inventorydate'];
    
    $productId =$_POST['productId'];
    $productAvailable =$_POST['productAvailable'];

    $storeId = $_POST['storeId'];

    $storequantity= $_POST['storequantity'];
    foreach ($storequantity as $skey => $svalue) {

        $proId = $productId[$skey-1];
        $proAvailable = $productAvailable[$skey-1];

        $total=0;
        foreach ($svalue as $key => $value) {
            $stoId = $storeId[$skey][$key];
            
            if($value){
                $total += $value;
            
                $inventorySql = "INSERT INTO store_inventory (product_id,store_id,store_quantity) VALUES('$proId','$stoId','$value')";
                if($conn->query($inventorySql)===TRUE){

                    $inventorySql1 = "INSERT INTO store_inventory_history (date,product_id,store_id,store_quantity) VALUES('$date','$proId','$stoId','$value')";
                    $insertResult1 = $conn->query($inventorySql1);
                }
            }
        }
        if($total){

            $totalvalue = $proAvailable-$total;

            $updateSql = "UPDATE warehouse_inventory SET available_quentity='$totalvalue' WHERE product_id='$proId'";
            $updateResult = $conn->query($updateSql);
        }
    }

    if($insertResult1 === TRUE){
        header('location:store_inventory.php?msg=Store Inventory Added Successfully.');
    }

}
?>