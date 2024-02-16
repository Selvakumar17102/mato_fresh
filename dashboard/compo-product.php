<?php
	ini_set('display_errors','off');
    include("session.php");
    include("inc/dbconn.php");

	if(isset($_POST["add"]))
	{
		$name = $_POST["name"];
		$image = $_POST["image"];
		$description = $_POST["description"];
		$demo = $_POST["demo"];
		$amo = $_POST["amo"];
		$qua = $_POST["qua"];
        
		$sql1 = "INSERT INTO compo_product (name,image,description,demo,amo,qua) VALUES ('$name','$image','$description','$demo','$amo','$qua')";
		if($conn->query($sql1) === TRUE)
		{
			header("Location: compo-product.php?msg=Compo Product Added!");
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
	<meta name="description" content="Compo Product | Mato Fresh" />
	
	<!-- OG -->
	<meta property="og:title" content="Compo Product | Mato Fresh" />
	<meta property="og:description" content="Compo Product | Mato Fresh" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Compo Product | Mato Fresh</title>
	
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
                                    <h3>Add Compo Product</h3>
                                </div>
                            </div>
						</div>
						<div class="widget-inner">
							<form class="edit-profile" method="post" enctype="multipart/form-data">
								<div class="">
									<div class="form-group row">
										<div class="col-sm-6">
											<input type="text" name="name" class="form-control" required placeholder="Name">
										</div>
										<div class="col-sm-6">
											<input type="text" name="image" required class="form-control" placeholder="Image">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-4">
											<input type="number" min="0" name="demo" class="form-control" required placeholder="Demo Amount">
										</div>
										<div class="col-sm-4">
											<input type="number" min="1" name="amo" required class="form-control" placeholder="Original Amount">
										</div>
										<div class="col-sm-4">
											<input type="number" min="1" name="qua" required class="form-control" placeholder="Add to cart quantity">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-12">
											<textarea name="description" class="form-control" required placeholder="Description" style="height: 100px !important;"></textarea>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-11"></div>
										<div class="col-sm-1">
											<input type="submit" name="add" class="btn " value="Add">
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div class="row m-b30">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 ">
					<div class="widget-box">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h3>All Compo Products</h3>
                                </div>
                            </div>
                        </div>
						<div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Description</th>
                                            <th>Demo Amount</th>
                                            <th>Original Amount</th>
                                            <th>Add to cart Quantity</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
									<tbody>
										<?php
											$sql = "SELECT * FROM compo_product ORDER BY name ASC";
											$result = $conn->query($sql);
											$count = 1;
											while($row = $result->fetch_assoc())
											{
										?>
												<tr>
													<td><center><?php echo $count++ ?></center></td>
													<td><center><?php echo $row["name"] ?></center></td>
													<td><center><img style="width: 150px" src="<?php echo $row["image"] ?>" alt=""></center></td>
													<td><center><?php echo $row["description"] ?></center></td>
													<td><center>₹ <?php echo number_format($row["demo"]) ?></center></td>
													<td><center>₹ <?php echo number_format($row["amo"]) ?></center></td>
													<td><center><?php echo number_format($row["qua"]) ?></center></td>
                                                    <td>
													<center>
														<?php
															if($row["status"] == 1)
															{
														?>
																<a onClick="return confirm('Sure to Inactive this Product!');" href="compo-status.php?id=<?php echo $row["id"] ?>"><img src="assets/images/on.png" alt=""></a>
														<?php
															}
															else
															{
														?>
																<a onClick="return confirm('Sure to Active this Product!');" href="compo-status.php?id=<?php echo $row["id"] ?>"><img src="assets/images/off.png" alt=""></a>
														<?php
															}
														?>
													</center>
												</td>
													<td><center>
														<table style="width:100px">
															<tr>
																<td style="border: none !important">
																	<a href="edit-compo-product.php?id=<?php echo $row["id"] ?>"><img src="assets/images/icons/edit.svg" alt=""></a>
																</td>
																<td style="border: none !important">
																	<a onClick="return confirm('Sure to Delete this Product!');" href="delete-compo-product.php?id=<?php echo $row["id"] ?>"><img src="assets/images/icons/delete.svg" alt=""></a>
																</td>
															</tr>
														</table>
                                                    </center></td>
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
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "iDisplayLength": 10
            });
</script>
</body>
</html>