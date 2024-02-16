<?php
include("inc/dbconn.php");

if(isset($_POST['inventorysubmit'])){
    $date = $_POST['inventorydate'];
    $storequantity= $_POST['storequantity'];

   
    $productId =$_POST['productId'];

    echo $productId;
    die();

    

    // foreach ($productId as $key => $value) {
    //         $product = $productId[$key];
    //         $master = $masterquantity[$key];
            
    //         $storeid=$_POST['storeid'][$key+1];
            
            // foreach ($storeid as $skey => $svalue) {
            //     $storequantityvalue = $storequantity[$key+1][$skey];

            //     $store = $_POST['storeid'][$key+1][$skey];

            //     $inventorySql = "INSERT INTO inventory (inventory_date,product_id,master_quantity,store_id,store_quantity) VALUES('$date','$product','$master','$store','$storequantityvalue')";
            //     if($conn->query($inventorySql)=== TRUE){
            //         header('location:inventory.php?msg=Inventory Added Successfully.');
            //     }
            // }
    // }
}
?>