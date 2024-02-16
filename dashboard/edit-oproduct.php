<?php

	ini_set('display_errors','off');
    include("session.php");
    include("inc/dbconn.php");
    
    $id = $_REQUEST["id"];

    $sql = "SELECT * FROM offer_product WHERE id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $oid = $row["oid"];

	if(isset($_POST["add"]))
	{
		$name = $_POST["name"];
		$image = $_POST["image"];
		$demo = $_POST["demo"];
		$amo = $_POST["amo"];
		$vari = $_POST["vari"];
		$qua = $_POST["qua"];
        
		$sql1 = "UPDATE offer_product SET name='$name',image='$image',demo='$demo',amo='$amo',vari='$vari',qua='$qua' WHERE id='$id'";
		if($conn->query($sql1) === TRUE)
		{
			header("Location: offer-product.php?id=$oid&msg=Product Updated!");
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
	<meta name="description" content="Offers | Mato Fresh" />
	
	<!-- OG -->
	<meta property="og:title" content="Offers | Mato Fresh" />
	<meta property="og:description" content="Offers | Mato Fresh" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Add Product | Mato Fresh</title>
	
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
        .2
        {
            border-radius: 20px;
            background-color: #FFF;
            color: #000 !important;
            border: 1px solid #000;
        }
        .2:hover
        {
            background-color: #FFF;
            color: #F00 !important;
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
				<div class="col-lg-12 ">
					<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
					<div class="widget-box">
						<div class="card-header">
                            <div class="row">
                                <div class="col-sm-10">
                                    <h3>Edit Offer Product</h3>
                                </div>
                            </div>
						</div>
						<div class="widget-inner">
							<form class="edit-profile" method="post" enctype="multipart/form-data">
								<div class="">
									<div class="form-group row">
										<div class="col-sm-6">
											<input type="text" name="name" class="form-control" required placeholder="Name" value="<?php echo $row["name"] ?>">
										</div>
										<div class="col-sm-6">
											<input type="text" name="image" required class="form-control" placeholder="Image" value="<?php echo $row["image"] ?>">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-6">
											<input type="number" min="0" name="demo" class="form-control" required placeholder="Demo Amount" value="<?php echo $row["demo"] ?>">
										</div>
										<div class="col-sm-6">
											<input type="number" min="1" name="amo" required class="form-control" placeholder="Original Amount" value="<?php echo $row["amo"] ?>">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-6">
											<input type="text" name="vari" class="form-control" required placeholder="Variation" value="<?php echo $row["vari"] ?>">
										</div>
										<div class="col-sm-6">
											<input type="number" min="1" name="qua" required class="form-control" placeholder="Add to cart quantity" value="<?php echo $row["qua"] ?>">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-11"></div>
										<div class="col-sm-1">
											<input type="submit" name="add" class="btn " value="Save">
										</div>
									</div>
								</div>
							</form>
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
</body>
</html>