<?php

	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");

	$email = $_SESSION["username"];

	$thismonth = date('m');
	$totalorders = $totalamount = $totalres = $totaldel = 0;

	$sql = "SELECT * FROM order_details";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc())
	{
		$totalorders++;
		$totalamount += $row["overall_total_amount"];
	}

	$sql1 = "SELECT * FROM login";
	$result1 = $conn->query($sql1);
	while($row1 = $result1->fetch_assoc())
	{
		if($row1["control"] == 2)
		{
			$totalres++;
		}
		if($row1["control"] == 3)
		{
			$totaldel++;
		}
	}

	$today = date('d-m-Y');
	$sevendaysbefore = date('d-m-Y', strtotime('-7 days'));
			
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
	<meta name="description" content="Orders | Mato Fresh" />
	<meta http-equiv="refresh" content="300">
	
	<!-- OG -->
	<meta property="og:title" content="Orders | Mato Fresh" />
	<meta property="og:description" content="Orders | Mato Fresh" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Orders | Mato Fresh</title>
	
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
							<h3>New Orders</h3>
						</div>
						<div class="widget-inner">
							<div class="table-responsive">
                                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
											<th>Order ID</th>
											<th>From</th>
											<th>Order Status</th>
											<th>Delivery Partners</th>
											<th>Name</th>
                                            <th>Mobile No</th>
											<th>Email</th>
											<th>Address</th> 
                                            <th>Booking Date / Time</th>
                                            <th>Grand Total</th>
											<th>Delivery Type</th>
											<th>Payment Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
												
										<?php 
											$sql = "SELECT * FROM order_details WHERE order_status !='Cancelled' AND payment_status != 'Cancelled' AND payment_status != 'Pending' AND payment_status != 'Failed' AND product_id !='3' ORDER BY sno DESC";
											$retval = mysqli_query($conn,$sql);
											$count = 0;
											while($row = mysqli_fetch_array($retval))
											{
												$hotelid = $row['latitude'];

												$sno = $row['sno'];
												$orderid = $row['orderid'];
												$username = $row['username'];
												$address = $row['address'];
												$booking_date = $row['booking_date'];
												$booking_time = $row['booking_time'];
												$delivery_charge = $row['delivery_charge'];
												$delivery_date = $row['delivery_date'];
												$delivery_time = $row['delivery_time'];
												$delivery_type = $row['delivery_type'];
												$email = $row['email'];
												$landmark = $row['landmark'];
												$mobile_number = $row['mobile_number'];
												$overall_total_amount = $row['overall_total_amount'];
												$recipe_total_amount = $row['recipe_total_amount'];
												$order_status = $row['order_status'];
												$payment_status = $row['payment_status'];
												$longitude = $row['longitude'];

												$sql6 = "SELECT * FROM user_address WHERE id='$address'";
												$result6 = $conn->query($sql6);
												$row6 = $result6->fetch_assoc();

												$phn = $row6["phone"];

												$sql7 = "SELECT * FROM users WHERE phone='$phn'";
												$result7 = $conn->query($sql7);
												$row7 = $result7->fetch_assoc();

												$username = $row7["name"];
												$address = $row6["addr"];
												$email = $row7["email"];
												
												$ofrom = $row['web'];
												if($ofrom == '1'){
													$from = "WEB";
												} else {
													$from = "APP";
												}
												
											?>
												<tr>
													<td><center><?php echo ++$count; ?></center></td>
													<td><a href="view-order.php?id=<?php echo $row["sno"] ?>"><?php echo $orderid; ?></a></td>
													<td><?php echo $from; ?></td>
													<td>
													<?php
														if($order_status == "Placed")
														{
													?>
														<form action="update-status.php" class="edit-profile">
															<table>
																<tr>
																	<td>
																		<select style="width: 200px" name="status" class="form-control" required>
																			<option value disabled selected>Select Status</option>
																			<option value="Accepted">Accepted</option>
																			<option value="Cancelled">Cancelled</option>
																		</select>
																	</td>
																	<td>
																		<input type="hidden" name="sno" value=<?php echo $sno ?>>
																		<input type="submit" class="btn" value="Update">
																	</td>
																</tr>
															</table>
														</form>
													<?php
														}
														else
														{
													?>
															<center><?php echo $order_status; ?></center>
													<?php
														}
													?>
													</td>
													<td>
													<?php
														if($order_status != "Cancelled")
														{
													?>
														<form action="update-delivery.php" class="edit-profile">
															<table>
																<tr>
																	<td>
																		<input type="hidden" name="order_id" value="<?php echo $row['orderid'];?>">
																		<?php
																			if($row['order_status'] == "Placed" && $row['product_id'] =="0")
																			{
																				echo "Accept the order first";
																			}
																			else
																			{
																				if($row['order_status'] =="Accepted" && $row['product_id'] =="0" || $row['product_id']=="1")
																				{
																					?>
																						<select style="width: 200px" name="delivery_boy" class="form-control" required>
																							<option value="" selected value disabled> select delivery boy</option>
																						<?php
																						$sql2 = "SELECT * FROM hotel WHERE lid='$hotelid'";
																						$result2 = $conn->query($sql2);
																						$row2 = $result2->fetch_assoc();

																						$zone = $row2['zone'];

																						$sql8 = "SELECT * FROM login WHERE control='3'";
																						$result8 = $conn->query($sql8);
																						while($row8 = $result8->fetch_assoc())
																						{
																							$wid = $row8['id'];
																							$sql2 = "SELECT * FROM worker WHERE status='Online' AND zone='$zone' AND lid='$wid'";
																							$result2 = $conn->query($sql2);
																							if($result2->num_rows > 0){
																								if($row['product_id'] =="1")
																								{
																									if($row['longitude'] == $row8['id'])
																									{
																										$selected = "selected";
																									}
																									else
																									{
																										$selected = "";
																									}
																								}
																			?>
																								<option value="<?php echo $row8['id'];?>" <?php echo $selected;?>><?php echo $row8['username'];?></option>	
																			<?php
																							}
																						}
																				}
																				else
																				{
																					if($row['product_id'] =="2")
																					{
																						$sql9 = "SELECT * FROM login WHERE id='$longitude'";
																						$result9 = $conn->query($sql9);
																						$row9 = $result9->fetch_assoc();
																						
																						echo $row9['username'];
																					}
																				}
																				
																			}
																		?>
																			
																		</select>
																	</td>
																	<?php
																		if($row['order_status'] == "Accepted" && $row['product_id'] =="0" || $row['product_id']=="1")
																		{
																			?>
																				<td>
																					<input type="hidden" name="delivery_sno" value=<?php echo $sno ?>>
																					<input type="submit" class="btn" value="Update">
																				</td>
																			<?php
																		}
																	?>
																</tr>
															</table>
														</form>
													<?php
														}
														else
														{
													?>
															<center><?php echo $order_status; ?></center>
													<?php
														}
													?>
													</td>
													<td><?php echo $username; ?></td>
													<td><?php echo $mobile_number; ?></td>
													<td><?php echo $email; ?></td>
													<td><?php echo $address . ' <br> ' . $landmark; ?></td>
													<td><?php echo $booking_date . ' / ' . $booking_time; ?></td>
													<td><?php echo number_format($overall_total_amount) ?></td>
													<td><?php echo $delivery_type; ?></td>
													<td><?php echo $payment_status; ?></td>
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
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"]
                ],
                "iDisplayLength": 25,
            });
</script>
</body>
</html>