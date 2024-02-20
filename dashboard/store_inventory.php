<?php

	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
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
	<title>Store Inventory | Mato Fresh</title>
	
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
					<form action="storeinventory.php" method="post">
					<div class="widget-box">
						<div class="card-header">
							<div class="row">
                        	<div class="col-md-10">
								<h3>Product Store Inventory</h3>
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
											<th>Available Quantity (kg)</th>
											<?php
											 $storeSql = "SELECT * FROM `login`WHERE control ='2' AND status='0'";
											 $storeResult = $conn->query($storeSql);
											 while($storeRow = $storeResult->fetch_assoc()){
												?>
												<th><?php echo $storeRow['username'];?></th>
												<?php
											 }
											?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql = "SELECT *,a.id as warehouseId FROM `warehouse_inventory` a INNER JOIN product b ON a.product_id=b.id WHERE b.status = '1'";
                                            $result = $conn->query($sql);
                                            $count = 0;
                                            while($row = $result->fetch_assoc()){
												$count++;

												$proId =$row["id"];
												$warehouseId =$row["warehouseId"];
                                        ?>
												<tr>
													<td><center><?php echo $count; ?></center></td>
													<td><center><?php echo $row["name"] ?></center></td>
													<td><center><input type="text" class="form-control" name="productAvailable[]" value="<?php echo $row["available_quentity"].' kg' ?>" readonly></center></td>
													<input type="hidden" name="productId[]" value="<?php echo $proId;?>">
													<?php
													$storeSql1 = "SELECT * FROM `login`  WHERE control ='2' AND status='0'";
													$storeResult1 = $conn->query($storeSql1);
													while($storeRow1 = $storeResult1->fetch_assoc()){
														$stoid = $storeRow1['id'];
														$invenSql = "SELECT * FROM `store_inventory` WHERE product_id='$proId' AND store_id='$stoid'";
														$invenResult = $conn->query($invenSql);
														if($invenResult->num_rows > 0){
															$invenRow = $invenResult->fetch_assoc();
															
																$value = $invenRow['store_quantity'];
															
														}else{
															$value="0";
														}
														
													   ?>
													   <input type="hidden" name="storeId[<?php echo $count;?>][]" value="<?php echo $storeRow1['id'] ?>">
													   <td>
															<input type="number" class="form-control" name="storequantity[<?php echo $count;?>][]">
													   		<p style="color:green"><?php echo "Available: ".$value.' kg'?></p>
														</td>
													   <?php
													}
													?>
												</tr>
                                        <?php
                                            }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
					<div class="row m-3">
						<div class="col-md-5"></div>
						<div class="col-md-2">
							<input type="submit" class="form-control" name="inventorysubmit" value="Submit">
						</div>
					</div>
					</form>
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
function storequantity(id,sid) {
   
	let quntity = document.getElementById("productquantity"+id).value;

	
	let totalstore = document.getElementById("totalstore").value;

	// alert(totalstore);
	// for(var i=1;i<= totalstore;i++){
	
		var store += document.getElementById(sid+"storequantity1"+id).value;
		
		
	// }
	alert(store);
    
}
</script>
</body>
</html>