<?php

	ini_set('display_errors','off');
    include("session.php");
    include("inc/dbconn.php");
    
	$id = $_GET['id'];
	
	if($id){
		$sql = "SELECT * FROM `product` WHERE id = '$id'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
        
	}

		if(isset($_POST["submit"])){
        	$date = $_POST["date"];
            
        	$storeId = $_POST["storeId"];
            $availablequentity = $_POST['availablequentity'];
        	$wastagequentity = $_POST["wastagequentity"];
            
            $total = $availablequentity - $wastagequentity;
            
            $updateSql = "UPDATE store_inventory SET store_quantity='$total' WHERE product_id='$id' AND store_id='$storeId'";
            
            if($conn->query($updateSql)===TRUE){
                $insertSql = "INSERT INTO store_wastage_inventory (product_id,old_available_quantity,wastage_quantity,created_date)VALUES('$id','$availablequentity','$wastagequentity','$date')";
                if($conn->query($insertSql)===TRUE){
				    header("Location: singlestoreinventory.php?msg=Wastage Inventory Updated!");
			    }
            }
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
	<meta name="description" content="Store | Mato Fresh" />
	
	<!-- OG -->
	<meta property="og:title" content="Store | Mato Fresh" />
	<meta property="og:description" content="Store | Mato Fresh" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>store wastage Inventory | Mato Fresh</title>
	
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
		.form-control
		{
			display: block;
			width: 100%;
			height: 34px;
			padding: 6px 12px;
			font-size: 14px;
			line-height: 1.42857143;
			color: #555;
			background-color: #fff;
			background-image: none;
			border: 1px solid #e1e6eb;
			border-radius: 4px;
			box-shadow: none;
		}
		.
        {
            border-radius: 20px;
            background-color: #36B37E;
            color: #fff;
        }
        .:hover
        {
            background-color: #00875A;
            color: #fff;
		}
		.th
		{
			color: #091E42 !important;
		}
		.hide
		{
			display: none;
		}
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
					<div class="widget-box">
						<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
						<form method="post">
						<div class="card-header">
							<div class="row">
								<div class="col-md-4">
									<h3>store wastage Inventory</h3>
								</div>
								<div class="col-md-4">
                                    <input type="text" class="form-control" value="Product Name: <?php echo $row['name']?>" readonly>
								</div>
                                <div class="col-md-4">
                                    <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d');?>" readonly>
                                </div>
							</div>
						</div>
						<div class="widget-inner">
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php
                                    $warSql = "SELECT * FROM `store_inventory` WHERE product_id='$id' AND store_id='$headid'";
                                    $warResult = $conn->query($warSql);
                                    if($warResult->num_rows > 0){
                                        $warRow = $warResult->fetch_assoc();
                                        $availablity = $warRow['store_quantity'];
                                    }else{
                                        $availablity = "0";
                                    }
                                    ?>
                                    <input type="hidden" name="storeId" value="<?php echo $headid?>">
                                    <label for="">Available Quantity</label>
                                    <input type="number" name="availablequentity" class="form-control" value="<?php echo $availablity;?>" readonly>
                                </div>
                                <?php
                                if($availablity > 0){
                                    ?>
                                    <div class="col-sm-3">
                                        <label for="">Wastage Quantity</label>
                                        <input type="number" name="wastagequentity" class="form-control" placeholder="Enter Wastage" required>
                                    </div>
								    <div class="col-sm-3">
                                        <label for="">Action</label><br>
                                        <input type="submit" name="submit" class="btn" value="Submit">
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
						</div>
                        </form>
                        <hr>
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
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "iDisplayLength": 10
            });
</script>
</body>
</html>