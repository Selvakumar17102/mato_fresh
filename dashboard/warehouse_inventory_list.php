<?php

	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");

//    if(isset($_POST['submit'])){
//         $date = $_POST['inventorydate'];
//         $master = $_POST['masterquantity'];

// 		$sql = "SELECT * FROM `product` WHERE status = '1'";
//         $result = $conn->query($sql);
//         $i = 0;
//         while($row = $result->fetch_assoc()){
			
// 			$proId = $row['id'];

// 			$checkSql = "SELECT * FROM warehouse_inventory WHERE product_id='$proId'";
// 			$checkResult = $conn->query($checkSql);
// 			if($checkResult->num_rows > 0){
               
// 				$oldrow = $checkResult->fetch_assoc();

// 				$oldvalue = $oldrow['available_quentity'];
				
              

// 				if($master[$i] == NULL){
// 					$mquentity=$oldvalue;
//                     $getquantity = 0;
// 				}else{
// 					$mquentity = $master[$i]+$oldvalue;
//                     $getquantity = $master[$i];
// 				}

// 				$updateSql = "UPDATE warehouse_inventory SET available_quentity='$mquentity' WHERE product_id='$proId'";
//                 $updateResult = $conn->query($updateSql);
// 				if($updateResult === TRUE){
//                     $updateSqlHistory = "INSERT INTO warehouse_inventory_history (date,product_id,master_quentity) VALUES('$date','$proId','$getquantity')";
//                     $updateResultHistroy = $conn->query($updateSqlHistory);
//                 }

// 				$i++;
// 			}else{
			    
// 				if($master[$i] != NULL){
// 					$mquentity = $master[$i];
                    
//                     $insertsql = "INSERT INTO warehouse_inventory (product_id,available_quentity) VALUES('$proId','$mquentity')";
//                     if($conn->query($insertsql) === TRUE){ 
//                         $insertsqlHistory = "INSERT INTO warehouse_inventory_history (date,product_id,master_quentity) VALUES('$date','$proId','$mquentity')";
//                         $insertResultHistory = $conn->query($insertsqlHistory);
//                     }

// 				}

// 				$i++;
// 			}
// 		}

// 		if($insertResultHistory === TRUE){
// 			header("location:warehouse_inventory.php?msg=Inventory Added Successfully.");
// 		}

// 		if($updateResultHistroy === TRUE){
// 			header("location:warehouse_inventory.php?msg=Inventory updated Successfully.");
// 		}
		
//    }
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<!-- META ============================================= -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	
	<!-- DESCRIPTION -->
	<meta name="description" content="All Users | Mato Fresh" />
	
	<!-- OG -->
	<meta property="og:title" content="All Users | Mato Fresh" />
	<meta property="og:description" content="All Users | Mato Fresh" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Warehouser Inventory list | Mato Fresh</title>
	
	<!-- MOBILE SPECIFIC ============================================= -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!--[if lt IE 9]>
	<script src="assets/js/html5shiv.min.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->
	
	<!-- All PLUGINS CSS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/assets.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/calendar/fullcalendar.css">
	
	<!-- TYPOGRAPHY ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/typography.css">
	
	<!-- SHORTCODES ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/shortcodes/shortcodes.css">
	
	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
	<link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">

	<style>
		.back-1
		{
			height: 80px;
			background: transparent linear-gradient(180deg, #61C200 0%, #00991A 100%) 0% 0% no-repeat padding-box;
			box-shadow: 0px 3px 6px #00000029;
		}
		.back-2
		{
			height: 80px;
			background: transparent linear-gradient(180deg, #009BF5 0%, #005DC7 100%) 0% 0% no-repeat padding-box;
			box-shadow: 0px 3px 6px #00000029;
		}
		.back-3
		{
			height: 80px;
			background: transparent linear-gradient(180deg, #822BD9 0%, #871B87 100%) 0% 0% no-repeat padding-box;
			box-shadow: 0px 3px 6px #00000029;
		}
		.back-4
		{
			height: 80px;
			background: transparent linear-gradient(180deg, #F7A100 0%, #E66F00 100%) 0% 0% no-repeat padding-box;
			box-shadow: 0px 3px 6px #00000029;
		}
		option:disabled {background: #dcdcdc; }
	</style>
	
</head>
<body class="ttr-opened-sidebar ttr-pinned-sidebar">
	
	<!-- header start -->
	<?php include_once("inc/header.php");?>
	<!-- header end -->
	<!-- Left sidebar menu start -->
	<?php include_once("inc/sidebar.php");?>
	<!-- Left sidebar menu end -->

	<!--Main container start -->
	<main class="ttr-wrapper">
		<div class="container-fluid">
			<div class="row m-b30">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12">
					<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
					<div class="widget-box">
						<div class="card-header">
							<div class="row">
                        	<div class="col-md-10">
								<h3>Warehouse Inventory List</h3>
                        	</div>
                        	<div class="col-md-2">
								<input type="date" class="form-control" name="inventorydate" id="inventorydate" value="<?php echo date('Y-m-d');?>" readonly>
                        	</div>
							</div>
						</div>
						<div class="widget-inner">
							<div class="table-responsive">
                                <table id="" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
											<th>Product name</th>
											<th>Avalable Quentity</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql = "SELECT *,a.id as proId FROM `product` a LEFT OUTER JOIN warehouse_inventory b ON a.id=b.product_id WHERE a.status = '1' ORDER BY available_quentity DESC";
                                            $result = $conn->query($sql);
                                            $count = 0;
                                            while($row = $result->fetch_assoc())
                                            {
												$count++;
                                        ?>
												<tr>
													<td><center><?php echo $count; ?></center></td>
													<td><center><?php echo $row["name"] ?></center></td>
                                                    <td><center><?php if($row['available_quentity'] != NULL){ echo $row['available_quentity'].' kg';}else{ echo "0 kg";} ?></center></td>
                                                    <td>
														<center>
															<a href="edit_warehouse_inventory.php?id=<?php echo $row['proId'] ?>"><img src="assets/images/icons/edit.svg"></a>
															<a href="warehouse_wastage_inventory.php?id=<?php echo $row['proId'] ?>"><img src="assets/images/icons/delete.svg"></a>
														</center>
													</td>
												</tr>
                                        <?php
                                            }
                                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</main>
	<div class="ttr-overlay"></div>

<!-- External JavaScripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/vendors/datatables/dataTables.bootstrap4.min.js"></script>
<script src="assets/vendors/datatables/dataTables.min.js"></script>
<script src="assets/js/admin.js"></script>
<script>
// Start of jquery datatable
            $('#dataTableExample1').DataTable({
                "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "lengthMenu": [
                    [6, 10, 25, -1],
                    [6, 10, 25, "All"]
                ],
                "iDisplayLength": 25,
            });
</script>

<script>
function handleClick(id){
	alert(id);
	
}
</script>
</body>
</html>