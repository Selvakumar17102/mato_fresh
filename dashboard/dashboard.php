<?php

	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");

	$email = $_SESSION["username"];

	$thismonth = date('m');
	$totalorders = $totalamount = $totalres = $totaldel = 0;
	$totalorders1 = $totalamount1 = $totalres1 = $totaldel1 = 0;

	$sql = "SELECT * FROM order_details WHERE product_id = '3'";
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

	$sql = "SELECT * FROM order_details WHERE product_id = '3'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc())
	{
		$hid = $row["latitude"];

		$sql2 = "SELECT * FROM login WHERE id='$hid'";
		$result2 = $conn->query($sql2);
		if($result2->num_rows > 0)
		{
			$totalorders1++;
			$totalamount1 += $row["overall_total_amount"];
		}
	}

	$sql1 = "SELECT * FROM login WHERE city='$city'";
	$result1 = $conn->query($sql1);
	while($row1 = $result1->fetch_assoc())
	{
		if($row1["control"] == 2)
		{
			$totalres1++;
		}
		if($row1["control"] == 3)
		{
			$totaldel1++;
		}
	}

	$today = date('Y-m-d');
	$sevendaysbefore = date('Y-m-d', strtotime('-7 days'));

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
	<meta name="description" content="Dashboard | Mato Fresh" />

	<meta http-equiv="refresh" content="300">
	
	<!-- OG -->
	<meta property="og:title" content="Dashboard | Mato Fresh" />
	<meta property="og:description" content="Dashboard | Mato Fresh" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Dashboard | Mato Fresh</title>
	
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
			background: #fff;
			box-shadow: 0px 3px 6px #00000029;
		}
		.back-2
		{
			height: 80px;
			background: #fff;
			box-shadow: 0px 3px 6px #00000029;
		}
		.back-3
		{
			height: 80px;
			background: #fff;
			box-shadow: 0px 3px 6px #00000029;
		}
		.back-4
		{
			height: 80px;
			background: #fff;
			box-shadow: 0px 3px 6px #00000029;
		}
		.b
		{
			width: 25% !important;
		}
		.c
		{
			width: 75% !important;
		}
		.widget-box .widget-inner {padding: 0;}
		.widget-box .widget-inner {background: #f7f7f7;}
		.ttr-wrapper {padding-top: 60px;}
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
						<div class="widget-inner">
							<?php
								if($rhead["control"] == 2)
								{
							?>
							<div class="table-responsive">
                                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
											<th>Order ID</th>
                                            <th>Order Status</th>
											<th>Delivery Partner</th>
											<th>Delivery Partner Status</th>
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
											$hotelid = $rhead["id"];
											$sql = "SELECT * FROM order_details WHERE latitude='$hotelid' AND product_id!='3' AND order_status!='dispatched' AND order_status!='Cancelled' ORDER BY sno DESC";
											$retval = mysqli_query($conn,$sql);
											$count = 0;
											if($retval->num_rows == 0)
											{
										?>
												<h3><center>No Orders Available.</center></h3>
										<?php
											}
											else
											{
												while($row = mysqli_fetch_array($retval))
												{
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
													$latitude = $row['latitude'];

													$sql8 = "SELECT * FROM hotel WHERE lid='$latitude'";
													$result8 = $conn->query($sql8);
													$row8 = $result8->fetch_assoc();
													$zone1 = $row8["zone"];

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
											?>
													
												<tr>
													<td><center><?php echo ++$count; ?></center></td>
													<td><a href="view-order.php?id=<?php echo $sno; ?>"><?php echo $orderid; ?></a></td>
													<td>
														<?php
															if($row["delivery_type"] != "Take Away")
															{
																if($order_status == "Placed")
																{
														?>
																<form action="hotel-status.php" method="post" class="edit-profile">
																	<table>
																		<tr>
																			<td>
																				<select style="width: 200px" name="status" class="form-control" required>
																					<option value selected disabled>Select Status</option>
																					<option value="Accepted">Accepted</option>
																					<option value="Cancelled">Cancelled</option>
																				</select>
																				<input type="hidden" name="sno" value="<?php echo $sno ?>">
																			</td>
																			<td>
																				<input type="submit" class="btn" value="Update">
																			</td>
																		</tr>
																	</table>
																</form>
														<?php
																}
																else
																{
																	echo $order_status;
																}
															}
															else
															{
																$s1 = $s2 = "";
																if($row["product_id"] == "2")
																{
																	$s2 = "Selected";
																}
																
																else
																{
																	if($row["order_status"] == "Accepted")
																	{
																		$s1 = "Selected";
																	}
																}
														?>
																<form action="status-update.php" method="post" class="edit-profile">
																	<table>
																		<tr>
																			<td>
																				<select style="width: 200px" name="status" class="form-control">
																					<option <?php echo $s1 ?> value="Accepted">Accepted</option>
																					<option <?php echo $s2 ?> value="Packed">Packed</option>
																					<option value="Dispatched">Dispatched</option>
																					<option value="Cancelled">Cancelled</option>
																				</select>
																				<input type="hidden" name="sno" value="<?php echo $sno ?>">
																				<input type="hidden" name="m" value="1">
																			</td>
																			<td>
																				<input type="submit" class="btn" value="Update">
																			</td>
																		</tr>
																	</table>
																</form>
														<?php
															}
														?>
													</td>
													<td>
														<?php
															if($row["delivery_type"] != "Take Away")
															{
																if($row["product_id"] == 0 || $row["product_id"] == 1)
																{
															?>
															<form action="assign-worker.php" class="edit-profile">
																<table>
																	<tr>
																		<td>
																			<select style="width: 200px" name="partner" class="form-control" required>
																				<option value disavled selected>Select Partner</option>
																				<?php
																					$sql2 = "SELECT * FROM login WHERE control='3' AND status='0'";
																					$result2 = $conn->query($sql2);
																					while($row2 = $result2->fetch_assoc())
																					{
																						$pid = $row2["id"];
																						$s = "";

																						if($row["longitude"] == $pid)
																						{
																							$s = "selected";
																						}

																						$sql3 = "SELECT * FROM worker WHERE lid='$pid' AND zone='$zone1' AND status='Online'";
																						$result3 = $conn->query($sql3);
																						$row3 = $result3->fetch_assoc();
																					?>
																						<option <?php echo $s ?> value="<?php echo $pid ?>"><?php echo $row3["name"] ?></option>
																					<?php																			
																					}
																				?>
																			</select>
																			<input type="hidden" name="sno" value="<?php echo $sno ?>">
																		</td>
																		<td>
																			<input type="submit" class="btn" value="Assign">
																		</td>
																	</tr>
																</table>
															</form>
															<?php
																}
																else
																{
																	$workid = $row["longitude"];

																	$sql4 = "SELECT * FROM worker WHERE lid='$workid'";
																	$result4 = $conn->query($sql4);
																	$row4 = $result4->fetch_assoc();
															?>
																<center><?php echo $row4["name"] ?></center>
															<?php
																}
															}
															else
															{
															?>
																<center>Mode Take Away</center>
															<?php
															}
														?>
													</td>
													<td><center>
													<?php
														if($row["delivery_type"] == "Take Away")
														{
															echo "Mode Take Away";
														}
														else
														{
															if($row["product_id"] == 0)
															{
																echo "Select Delivery Partner";
															}
															if($row["product_id"] == 1)
															{
																echo "Delivery Partner Assigned";
															}
															if($row["product_id"] == 2)
															{
																echo "Order Picked Up";
															}
															if($row["product_id"] == 3)
															{
																echo "Order Delivered";
															}
														}
													?>
													</center></td>
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
											}
										?>                            
                                                    
                                    </tbody>
                                </table>
                            </div>
							<?php
								}
								if($rhead["control"] == 3)
								{
							?>
							<div class="table-responsive">
                                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
											<th>Order ID</th>
											<th>Status</th>
											<th>Branch Name</th>
											<th>Name</th>
                                            <th>Mobile No</th>
											<th>Email</th>
											<th>Address</th> 
                                            <th>Booking Date / Time</th>
                                            <th>Grand Total</th>
											<th>Delivery Type</th>
                                            <th>Order Status</th>
											<th>Payment Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
												
										<?php 
											$workerid = $rhead["id"];
											$sql = "SELECT * FROM order_details WHERE longitude='$workerid' AND product_id!='3' ORDER BY sno DESC";
											$retval = mysqli_query($conn,$sql);
											$count = 0;
											while($row = mysqli_fetch_array($retval))
											{
												$hotelid = $row['latitude'];

												$sql1 = "SELECT * FROM hotel WHERE lid='$hotelid'";
												$result1 = $conn->query($sql1);
												$row1 = $result1->fetch_assoc();

												$sno = $row['sno'];
												$orderid = $row['orderid'];
												$name = $row1['name'];
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

										?>
												
                                            <tr>
                                                <td><center><?php echo ++$count; ?></center></td>
												<td><a href="view-order.php?id=<?php echo $sno; ?>"><?php echo $orderid; ?></a></td>
												<td>
													<form action="assign-order.php" class="edit-profile">
														<table>
															<tr>
																<td>
																	<select style="width: 200px" name="status" class="form-control" required>
																		<option value disabled Selected>Select Status</option>
																		<option <?php echo $s1 ?> value="2">Order Picked</option>
																		<option <?php echo $s2 ?> value="3">Order Delivered</option>
																	</select>
																	<input type="hidden" name="sno" value=<?php echo $sno ?>>
																</td>
																<td>
																	<input type="submit" class="btn" value="Update">
																</td>
															</tr>
														</table>
													</form>
												</td>
												<td><?php echo $name; ?></td>
												<td><?php echo $username; ?></td>
                                                <td><?php echo $mobile_number; ?></td>
												<td><?php echo $email; ?></td>
												<td><?php echo $address . ' <br> ' . $landmark; ?></td>
                                                <td><?php echo $booking_date . ' / ' . $booking_time; ?></td>
                                                <td><?php echo number_format($overall_total_amount) ?></td>
												<td><?php echo $delivery_type; ?></td>                                                        
                                                <td><?php echo $order_status; ?></td>
												<td><?php echo $payment_status; ?></td>
												<?php
													if($row["product_id"] == 2)
													{
														$s1 = "selected";
													}
													if($row["product_id"] == 3)
													{
														$s2 = "selected";
													}
												?>
                                            </tr>
										<?php 
											} 
										?>                            
                                                    
                                    </tbody>
                                </table>
                            </div>
							<?php
								}
								if($rhead["control"] == 0)
								{
							?>	
								<div class="row m-b30">
									<div class="col-sm-3">
										<div class="back-1">
											<div class="row" style="height: 80px">
												<div class="col-sm-3 b">
													<img style="padding-left: 20px;height: 80px" src="assets/images/hdollar.svg" alt="">
												</div>
												<div class="col-sm-9 c">
													<h6 style="color: #4F596E;padding-top: 10px">Total Sales</h6>
													<h6 style="color: #4F596E;">Rs <?php echo number_format($totalamount) ?></h6>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-3">
										<a href="orders.php">
											<div class="back-2">
												<div class="row" style="height: 80px">
													<div class="col-sm-3 b">
														<img style="padding-left: 20px;height: 80px" src="assets/images/horder.svg" alt="">
													</div>
													<div class="col-sm-9 c">
														<h6 style="color: #4F596E;padding-top: 10px">Total Orders</h6>
														<h6 style="color: #4F596E;"><?php echo number_format($totalorders) ?></h6>
													</div>
												</div>
											</div>
										</a>
									</div>
									<div class="col-sm-3">
										<a href="add-hotel.php">
											<div class="back-3">
												<div class="row" style="height: 80px">
													<div class="col-sm-3 b">
														<img style="padding-left: 20px;height: 80px" src="assets/images/hrest.svg" alt="">
													</div>
													<div class="col-sm-9 c">
														<h6 style="color: #4F596E;padding-top: 10px">Total Branches</h6>
														<h6 style="color: #4F596E;"><?php echo number_format($totalres) ?></h6>
													</div>
												</div>
											</div>
										</a>
									</div>
									<div class="col-sm-3">
										<a href="add-worker.php">
											<div class="back-4">
												<div class="row" style="height: 80px">
													<div class="col-sm-3 b">
														<img style="padding-left: 20px;height: 80px" src="assets/images/hdeliv.svg" alt="">
													</div>
													<div class="col-sm-9 c">
														<h6 style="color: #4F596E;padding-top: 10px">Total Delivery Partners</h6>
														<h6 style="color: #4F596E;"><?php echo number_format($totaldel) ?></h6>
													</div>
												</div>
											</div>
										</a>
									</div>
								</div>
								<div class="widget-box m-b30" style="width: 100%;">
									<div class="widget-inner" style="box-shadow: 0px 3px 6px #00000029;">
										<div class="row">
											<div class="col-sm-12">
												<div id="columnchart_values" style="width: 100%"></div>
											</div>
										</div>
									</div>
								</div>

								
								<div class="row m-b30">
									<div class="col-sm-6">
										<div class="widget-box" style="background-color:#fff !important">
											<div class="widget-inner" style="box-shadow: 0px 3px 6px #00000029;">
												<div id="daychart" style="width: 100%;"></div>
											</div>
											<div class="card-header" style="background-color:#7DD481 !important; height: auto;">
												<h5 style="color: #fff;margin-bottom: 0;">Today Reports</h5>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="widget-box" style="background-color:#fff !important">
											<div class="widget-inner" style="box-shadow: 0px 3px 6px #00000029;">
												<div id="weekchart" style="width: 100%"></div>
											</div>
											<div class="card-header"style="background-color:#FFA3B1 !important; height: auto;">
												<h5 style="color: #fff;margin-bottom: 0;">Week Reports</h5>
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-6">
										<h5 style="color:#8697BB;">Top Branch</h5>

										<?php
											$sql = "SELECT * FROM order_details GROUP BY latitude ORDER BY count(*) DESC LIMIT 5";
											$result = $conn->query($sql);
											while($row = $result->fetch_assoc())
											{
												$hid = $row["latitude"];
												$ta = $to = 0;

												$sql1 = "SELECT * FROM hotel WHERE lid='$hid'";
												$result1 = $conn->query($sql1);
												$row1 = $result1->fetch_assoc();

												$sql2 = "SELECT * FROM order_details WHERE latitude='$hid'";
												$result2 = $conn->query($sql2);
												while($row2 = $result2->fetch_assoc())
												{
													$ta += $row2["overall_total_amount"];
													$to++;
												}
										?>
											<div class="widget-box m-b10">
												<div class="widget-inner" style="background: #fff;padding: 20px;box-shadow: 0px 3px 6px #00000029;">
													<h6 style="color:#00408C"><?php echo $row1["name"] ?></h6>
													<h6 style="color:#808080"><img src="assets/images/location.svg" alt=""> <?php echo $row1["addr"] ?></h6>
													<div class="row">
														<div class="col-sm-6">
															<h6 style="color: #808080">Total Sales</h6>
															<h6 style="color: #000000">Rs <?php echo number_format($ta) ?></h6>
														</div>
														<div class="col-sm-6">
															<h6 style="color: #808080">Total orders</h6>
															<h6 style="color: #000000"><?php echo number_format($to) ?></h6>
														</div>
													</div>
												</div>
											</div>
										<?php
											}
										?>
									</div>
									<div class="col-sm-6">
										<h5 style="color:#8697BB;">Top Users</h5>

										<?php
											$sql = "SELECT * FROM order_details GROUP BY mobile_number ORDER BY count(*) DESC LIMIT 5";
											$result = $conn->query($sql);
											while($row = $result->fetch_assoc())
											{
												$hid = $row["mobile_number"];
												$ta = $to = 0;

												$sql1 = "SELECT * FROM users WHERE phone='$hid'";
												$result1 = $conn->query($sql1);
												$row1 = $result1->fetch_assoc();

												$sql2 = "SELECT * FROM order_details WHERE mobile_number='$hid'";
												$result2 = $conn->query($sql2);
												while($row2 = $result2->fetch_assoc())
												{
													$ta += $row2["overall_total_amount"];
													$to++;
												}
										?>
											<div class="widget-box m-b10">
												<div class="widget-inner" style="background: #fff;padding: 20px;box-shadow: 0px 3px 6px #00000029;">
													<h6 style="color:#00408C"><?php echo $row1["name"] ?></h6>
													<h6 style="color:#808080"><img src="assets/images/phone.svg" alt=""> <?php echo $row1["phone"] ?></h6>
													<div class="row">
														<div class="col-sm-6">
															<h6 style="color: #808080">Total Sales</h6>
															<h6 style="color: #000000">Rs <?php echo number_format($ta) ?></h6>
														</div>
														<div class="col-sm-6">
															<h6 style="color: #808080">Total orders</h6>
															<h6 style="color: #000000"><?php echo number_format($to) ?></h6>
														</div>
													</div>
												</div>
											</div>
										<?php
											}
										?>
									</div>
								</div>
							<?php
								}
							?>
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
                    [100, 200, 500, -1],
                    [100, 200, 500, "All"]
                ],
                "iDisplayLength": 100,
            });
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
	google.charts.load("current", {packages:['corechart']});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
	var data = google.visualization.arrayToDataTable([
		["Month","Amount",{ role:"style"}],
		<?php
			for($i=1;$i<=$thismonth;$i++)
			{
				$j = "0".$i;
				$startdate1 = date('Y-'.$j.'-01');
				$startdate = date('Y-'.$j.'-01');
				if($thismonth == $i)
				{
					$enddate = date('Y-m-d');
				}
				else
				{
					$enddate = date('Y-m-t',strtotime(date('Y-'.$j.'-01')));
				}

				$sql = "SELECT sum(overall_total_amount) AS total FROM order_details WHERE booking_date BETWEEN '$startdate' AND '$enddate' AND product_id='3'";
				$result = $conn->query($sql);
				$row = $result->fetch_assoc();

				$monthname = date("F",strtotime($startdate1));
				$total = $row["total"];

				if($total == "")
				{
					$total = 0;
				}

				echo '["'.$monthname.'",'.$total.',"#707070"],';
			}
		?>
	]);

	var view = new google.visualization.DataView(data);
	var options = {
		title: "Total Sales",
		bar: {groupWidth: "10%"},
		legend: { position: "none" },
	};
	var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
	chart.draw(view, options);
}
</script>
<script type="text/javascript">
	google.charts.load("current", {packages:['corechart']});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
	var data = google.visualization.arrayToDataTable([
		["Month","Amount",{ role:"style"}],
		<?php
			$dayamount = $dayorder = 0;

			$sql = "SELECT * FROM order_details WHERE booking_date='$today' AND product_id='3'";
			$result = $conn->query($sql);
			while($row = $result->fetch_assoc())
			{
				$dayamount += $row["overall_total_amount"];
				$dayorder++;
			}
			echo '["Orders",'.$dayorder.',"#7DD481"],';
			echo '["Sales",'.$dayamount.',"#7DD481"],';
		?>
	]);

	var view = new google.visualization.DataView(data);
	var options = {
		bar: {groupWidth: "10%"},
		legend: { position: "none" },
		backgroundColor: '#fff',
		hAxis: 
		{
			textStyle:{color: '#000'}
		},
		vAxis: 
		{
			textStyle:{color: '#000'}
		},
	};
	var chart = new google.visualization.ColumnChart(document.getElementById("daychart"));
	chart.draw(view, options);
}
</script>
<script type="text/javascript">
	google.charts.load("current", {packages:['corechart']});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
	var data = google.visualization.arrayToDataTable([
		["Month","Amount",{ role:"style"}],
		<?php
			$weekamount = $weekorder = 0;

			$sql = "SELECT * FROM order_details WHERE booking_date BETWEEN '$sevendaysbefore' AND '$today' AND product_id='3'";
			$result = $conn->query($sql);
			while($row = $result->fetch_assoc())
			{
				$weekamount += $row["overall_total_amount"];
				$weekorder++;
			}
			echo '["Orders",'.$weekorder.',"#FFA3B1"],';
			echo '["Sales",'.$weekamount.',"#FFA3B1"],';
		?>
	]);

	var view = new google.visualization.DataView(data);
	var options = {
		bar: {groupWidth: "10%"},
		legend: { position: "none" },
		backgroundColor: '#fff',
		hAxis: 
		{
			textStyle:{color: '#000'}
		},
		vAxis: 
		{
			textStyle:{color: '#000'}
		},
	};
	var chart = new google.visualization.ColumnChart(document.getElementById("weekchart"));
	chart.draw(view, options);
}
</script>
</body>
</html>