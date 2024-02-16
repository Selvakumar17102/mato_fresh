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
	<meta name="description" content="Processing Orders | Mato Fresh" />
	
	<!-- OG -->
	<meta property="og:title" content="Processing Orders | Mato Fresh" />
	<meta property="og:description" content="Processing Orders | Mato Fresh />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Processing Orders | Mato Fresh</title>
	
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
	
	<!-- DataTable ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	
	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
	<link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">
	
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
			<div class="row">
				
				
			
						
						<!-- Data tables -->
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
                                <div class="widget-box">
                                    <div class="widget-inner">
                                        <div class="table-responsive">
                                            <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr>
														<th>S.NO</th>
														<th>Order ID</th>
														<?php
															if($rhead["control"] == 0)
															{
														?>
														<th>Branch Name</th>
														<?php
															}								
														?>
														<th>User Name</th>
                                                        <th>Mobile No</th>
														<th>Email</th>
														<th>Address</th> 
                                                        <th>Booking Date / Time</th>
                                                        <th>Grand Total (Rs)</th>
														<th>Delivery Type</th>
                                                        <th>Order Status</th>
														<th>Payment Status</th>
														<?php
															if($rhead["control"] != 0)
															{
														?>
														<th>Action</th>
														<?php
															}								
														?>
                                                    </tr>
                                                </thead>
                                                <tbody>
												
						<?php 
							$hotelid = $rhead["id"];
							if($rhead["control"] == 0)
							{
								$sql = "SELECT * FROM order_details where order_status = 'Processing' ORDER BY sno DESC";
							}
							else
							{
								$sql = "SELECT * FROM order_details where order_status = 'Processing' AND latitude='$hotelid' ORDER BY sno DESC";
							}
							$retval = mysqli_query($conn,$sql);
							$count = 0;
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
							$hid = $row['latitude'];

							$sql1 = "SELECT * FROM hotel WHERE lid='$hid'";
							$result1 = $conn->query($sql1);
							$row1 = $result1->fetch_assoc();

							$sql2 = "SELECT * FROM login WHERE id='$hid'";
							$result2 = $conn->query($sql2);
							$row2 = $result2->fetch_assoc();

							$city = $row2["city"];

							$sql5 = "SELECT * FROM city WHERE id='$city'";
							$result5 = $conn->query($sql5);
							$row5 = $result5->fetch_assoc();

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
														<?php
															if($rhead["control"] == 0)
															{
														?>
															<td><?php echo $row1["name"] ?></td>
														<?php
															}
														?>
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
															if($rhead["control"] != 0)
															{
														?>
														<td>
															<table>
																<tr>
																	<td><a href="view-order.php?id=<?php echo $sno; ?>" title="View Order"><i class="fa fa-eye"></i></a></td>
																	<td><a href="delete-order.php?id=<?php echo $sno; ?>" onClick="return confirm('Sure to Delete this Order !');" title="Delete Order"><i class="fa fa-trash"></i></a></td>
																	<td><a href="billing.php?id=<?php echo $sno; ?>" target="_blank;" title="Print Invoice"><i class="fa fa-print"></i></a></td>
																	<td><a href="send-invoice.php?id=<?php echo $sno; ?>" onClick="return confirm('Sure to Send Invoice to Customer!');" title="Send Invoice to Customer"><i class="fa fa-envelope"></i></a></td>
																</tr>
															</table>
														</td>
														<?php
															}
														?>
                                                    </tr>
                        <?php } ?>                            
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ./Data table -->
						
					
				
			</div>
		</div>
	</main>
	<div class="ttr-overlay"></div>

<!-- External JavaScripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/vendors/bootstrap/js/popper.min.js"></script>
<script src="assets/vendors/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendors/bootstrap-select/bootstrap-select.min.js"></script>
<script src="assets/vendors/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
<script src="assets/vendors/magnific-popup/magnific-popup.js"></script>
<script src="assets/vendors/counter/waypoints-min.js"></script>
<script src="assets/vendors/counter/counterup.min.js"></script>
<script src="assets/vendors/imagesloaded/imagesloaded.js"></script>
<script src="assets/vendors/datatables/dataTables.bootstrap4.min.js"></script>
<script src="assets/vendors/datatables/dataTables.min.js"></script>
<script src="assets/vendors/masonry/masonry.js"></script>
<script src="assets/vendors/masonry/filter.js"></script>
<script src="assets/vendors/owl-carousel/owl.carousel.js"></script>
<script src='assets/vendors/scroll/scrollbar.min.js'></script>
<script src="assets/js/functions.js"></script>
<script src="assets/vendors/chart/chart.min.js"></script>
<script src="assets/js/admin.js"></script>
<script src='assets/vendors/calendar/moment.min.js'></script>
<script src='assets/vendors/calendar/fullcalendar.js'></script>
<script>
// Start of jquery datatable
            $('#dataTableExample1').DataTable({
                "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "lengthMenu": [
                    [6, 25, 50, -1],
                    [6, 25, 50, "All"]
                ],
                "iDisplayLength": 6
            });
</script>
</body>
</html>