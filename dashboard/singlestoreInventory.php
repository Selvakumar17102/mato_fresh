<?php

	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	
	if(isset($_POST['submit'])){
		$date = $_POST['date'];
	}else{
		$date = date('Y-m-d');
	}
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
	<title>Single Store Inventory | Mato Fresh</title>
	
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
					<form action="" method="post">
					<div class="widget-box">
						<div class="card-header">
						<div class="row">
                                <div class="col-sm-9">
                                    <h3>Product Inventory</h3>
                                </div>
								<form method="post">
                                <div class="col-sm-2">
                                    <input type="date" class="form-control" name="date" value = "<?php echo $date?>">
                                </div>
								<div class="col-sm-1">
                                    <input type="submit" class="form-control" name="submit" value="submit">
                                </div>
								</form>
                            </div>
							<h3></h3>
						</div>
						<div class="widget-inner">
							<div class="table-responsive">
                                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
											<th>Product name</th>
											<th>Product Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                            // $sql = "SELECT * FROM inventory a LEFT OUTER JOIN product b ON a.product_id = b.id LEFT OUTER JOIN login c on a.store_id = c.id WHERE a.store_id=$headid";
                                            $sql = "SELECT * FROM `product` WHERE status = '1' ORDER BY name ASC";
                                            $result = $conn->query($sql);
                                            $count = 0;
                                            while($row = $result->fetch_assoc())
                                            {
												$count++;
                                                $id = $row['id'];
												

                                                $inventorySql = "SELECT * FROM inventory WHERE product_id = '$id' AND store_id = '$headid' AND inventory_date = '$date'";
                                                $inventoryResult = $conn->query($inventorySql);
                                                $inventoryrow = $inventoryResult->fetch_assoc();
                                                if($inventoryrow['store_quantity'] == NULL){
                                                    $storevalue = "0";
                                                }else{
                                                    $storevalue = $inventoryrow['store_quantity'];
                                                }

                                        ?>
												<tr>
													<td><center><?php echo $count; ?></center></td>
													<td><center><?php echo $row["name"] ?></center></td>
													<td><center><input type="number" class="form-control" name="masterquantity" id="masterquantity<?php echo $count; ?>" value="<?php echo $storevalue; ?>" readonly></center></td>
												</tr>
                                        <?php
                                            }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
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
                "iDisplayLength": 10,
            });
</script>

<script>
function handleClick(id){
	alert(id);
	
}
function masteramt(id) {
   
	let masterquntity = document.getElementById("masterquantity"+id).value;
	let totalstore = document.getElementById("totalstore").value;

	for(var i=1;i<= totalstore;i++){

		var perstore = masterquntity/totalstore;
		document.getElementById(i+"storequantity"+id).value = perstore;
	}
	
	let storeid = document.getElementById("storeid"+id).value;
    
}

</script>
</body>
</html>