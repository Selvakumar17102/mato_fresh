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
	<title>Scheme List | Mato Fresh</title>
	
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
                                <div class="col-sm-10">
                                    <h3>List Scheme</h3>
                                </div>
                                <div class="col-sm-2">
                                    <a href="createScheme.php" class="btn 2 float-right">Add Scheme</a>
                                </div>
                            </div>
						</div>
						<div class="widget-inner">
							<div class="table-responsive">
                                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
											<th>Scheme Name</th>
											<th>Scheme Days</th>
											<th>Scheme Amount</th>
											<td>Limited Delivery</td>
                                            <td>Limited Product Count</td>
											<td>Main Product Name</td>
											
											<td>Action</td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                            $sql = "SELECT * FROM `subscription` ORDER BY id ASC";
                                            $result = $conn->query($sql);
                                            $count = 0;
											while($row = $result->fetch_assoc()){
												$count++;

												$explodeproduct = explode(",",$row["productId"]);

												$explodevariation = explode(",",$row["variation"]);
                                        ?>
													<tr>
														<td><center><?php echo $count ?></center></td>
														<td><center><?php echo $row["schemename"] ?></center></td>
														<td><center><?php echo $row["schemeday"] ?></center></td>
														<td><center><?php echo $row["schemeamount"] ?></center></td>
														<td><center><?php echo $row["totaldelivery"] ?></center></td>
														<td><center><?php echo $row["productcount"] ?></center></td>

														<td>
															<center>
																<select class="form-control">
																	<?php
																	foreach ($explodeproduct as $key => $productvalue) {
																		$productSql = "SELECT * FROM `product` WHERE id = $productvalue";
																		$productResult = $conn->query($productSql);
																		while ($productRow = $productResult->fetch_assoc()) {
																			echo "<option>".$productRow['name']."-".$explodevariation[$key]."</option>";
																		}
																	}
																	?>
																</select>
															</center>
														</td>
														
														<td>
															<center>
																<a href="createScheme.php?id=<?php echo $row["id"] ?>"><img src="assets/images/icons/edit.svg"></a>
                                                    			<!-- <a href="delete-category.php?id=<?php echo $row["id"] ?>"><img src="assets/images/icons/delete.svg"></a> -->
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
                "iDisplayLength": 6,
            });
</script>
</body>
</html>