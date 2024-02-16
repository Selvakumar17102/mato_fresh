<?php
ini_set('display_errors','off');
include("session.php");
include("inc/dbconn.php");
$id = $_REQUEST['id'];
$sql = "SELECT * FROM order_details WHERE sno = '$id'";
$retval = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($retval))
 {
	$orderid = $row['orderid'];
	$username = $row['username'];
	$address = $row['address'];
	$booking_date = $row['booking_date'];
	$booking_time = $row['booking_time'];
	$delivery_charge = number_format($row['delivery_charge'],2);
	$packing_charge = number_format($row['packing_charge'],2);
	$delivery_type = $row['delivery_type'];
	$delivery_date = $row['delivery_date'];
	$delivery_time = $row['delivery_time'];
	$email = $row['email'];
	$landmark = $row['landmark'];
	$mobile_number = $row['mobile_number'];
	$overall_total_amount = number_format($row['overall_total_amount'],2);
	$recipe_total_amount = number_format($row['recipe_total_amount'],2);
	$order_status = $row['order_status'];
	$payment_status = $row['payment_status'];
 }
 if(isset($_POST['status_update']))
{
$orderid		= $_POST['orderid'];
$order_status 	= $_POST['order_status'];
$query = "UPDATE order_details SET order_status = '$order_status' WHERE orderid = '$orderid'";
mysqli_query($conn,$query);
header("Location: view-order.php?id=$id&msg=Status Updated!");
}
 if(isset($_POST['update']))
{
$orderid		= $_POST['orderid'];
$deliverydate 	= $_POST['deliverydate'];
$deliverytime 	= $_POST['deliverytime'];

	$query = "UPDATE order_details SET delivery_date = '$deliverydate', delivery_time = '$deliverytime' WHERE orderid = '$orderid'";
mysqli_query($conn,$query);
header("Location: view-order.php?id=$id&msg=Delivey Date and Time Updated!");
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
	<meta name="description" content="Edit Order | Mato Fresh" />
	
	<!-- OG -->
	<meta property="og:title" content="Edit Order | Mato Fresh" />
	<meta property="og:description" content="Edit Order | Mato Fresh" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Edit Order | Mato Fresh</title>
	
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
	.bootstrap-select.btn-group .dropdown-toggle .filter-option {color: blue;}
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
			<div class="row">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
						<div class="wc-title">
						<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
						<div class="row">						
						<div class="col-sm-6">
							<h4>Order ID : <span style="color: #411890; font-weight: 400;"><?php echo $orderid; ?></span></h4>
						</div>
						<div class="col-sm-6">
						
						<form method="post" action="">
						
									<div class="form-group row" style="margin-bottom: 0;">
										<label class="col-sm-3 col-form-label">Order Status</label>
										<div class="col-sm-4">
											<select class="form-control" name="order_status">											
												<option value="<?php echo $order_status; ?>"><?php echo $order_status; ?></option>
												<option value="">-</option>
												<option value="Received">Received</option>
												<option value="Processing">Processing</option>
												<option value="Closed">Closed</option>
												<option value="Cancelled">Cancel</option>
											</select>
										</div>
										<div class="col-sm-3">
											<input class="form-control" name="orderid" type="hidden" value="<?php echo $orderid; ?>">
											<input name="status_update" class="form-control btn" type="submit" value="Update" />
										</div>		
									</div>
						
						</form>
						
						</div>
						</div>
						</div>
						<div class="widget-inner">
							<form class="edit-profile m-b30" method="post" action="">
								<div class="m-b30">
									<div class="form-group row">
										<div class="col-sm-10  ml-auto">
											<h3>1. Customer Details</h3>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Customer Name</label>
										<div class="col-sm-4">
											<input class="form-control" type="text" disabled value="<?php echo $username; ?>">
											<input class="form-control" name="orderid" type="hidden" value="<?php echo $orderid; ?>">
										</div>
									
										<label class="col-sm-2 col-form-label">Mobile No</label>
										<div class="col-sm-4">
											<input class="form-control" type="text" disabled value="<?php echo $mobile_number; ?>">
										</div>
									</div>
									<div class="form-group row">										

										<label class="col-sm-2 col-form-label">Email</label>
										<div class="col-sm-4">
											<input class="form-control" type="text" disabled value="<?php echo $email; ?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Address</label>
										<div class="col-sm-4">
											<textarea class="form-control" style="max-height: 80px;" disabled ><?php echo $address; ?></textarea>
										</div>
										
										<label class="col-sm-2 col-form-label">Landmark</label>
										<div class="col-sm-4">
											<input class="form-control" type="text" disabled value="<?php echo $landmark; ?>">
										</div>
									</div>
									
									<div class="seperator"></div>
									
									<div class="form-group row">
										<div class="col-sm-10 ml-auto">
											<h3>2. Order Details</h3>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Booking Date / Time</label>
										<div class="col-sm-4">
											<input class="form-control" type="text" disabled value="<?php echo $booking_date . ' ' . $booking_time; ?>" style="background: yellow;">
										</div>
										
										<label class="col-sm-2 col-form-label">Delivery Date & Time</label>
										<div class="col-sm-2">
											<input class="form-control" type="date" data-date="" data-date-format="DD MMMM YYYY" name="deliverydate" value="<?php echo $delivery_date; ?>" style="background: yellow;">
										</div>
										<div class="col-sm-2">
											<input class="form-control" type="text" name="deliverytime" placeholder="Ex: 08:00 AM" value="<?php echo $delivery_time; ?>" style="background: yellow;">
										</div>
									</div>
									
									<div class="form-group row">										
										<label class="col-sm-2 col-form-label">Payment Status</label>
										<div class="col-sm-4">
											<input class="form-control" type="text" value="<?php echo $payment_status; ?>" disabled style="background: green;color: #fff;">
										</div>
										
										<label class="col-sm-2 col-form-label">Delivery Type</label>
										<div class="col-sm-4">
											<input class="form-control" type="text" disabled value="<?php echo $delivery_type; ?>">
										</div>
									</div>
									
									<div class="form-group row">									
										<label class="col-sm-2 col-form-label">Delivery Charge</label>
										<div class="col-sm-4">
											<input class="form-control" type="text" disabled value="Rs <?php echo $delivery_charge; ?>">
										</div>
										<label class="col-sm-2 col-form-label">Packing Charge</label>
										<div class="col-sm-4">
											<input class="form-control" type="text" disabled value="Rs <?php echo $packing_charge; ?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Sub Total</label>
										<div class="col-sm-4">
											<input class="form-control" type="text" disabled value="Rs <?php echo $recipe_total_amount; ?>">
										</div>

										<label class="col-sm-2 col-form-label">Grand Total</label>
										<div class="col-sm-4">
											<input class="form-control" type="text" disabled value="Rs <?php echo number_format($overall_total_amount) ?>" style="background:#42188D;color: #fff;">
										</div>
									</div>
									<div class="form-group row">
										
										
										
									</div>

									<div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>

									<div class="form-group row">
										<div class="col-sm-10 ml-auto">
											<h3 class="m-form__section">3. Product Details</h3>
										</div>
									</div>
<?php $sql = "SELECT * FROM recipe_details WHERE orderid = '$orderid'";
$retval = mysqli_query($conn,$sql);
$count = 0;
while($row = mysqli_fetch_array($retval))
 {
	$orderid = $row['orderid'];
	$recipe_image = $row['recipe_image'];
	$recipe_name = $row['recipe_name'];
	$recipe_price = $row['recipe_price'];
	$no_quantity = $row['no_quantity'];
	$total = $no_quantity * $recipe_price;
	$total1 = number_format($total,2);
?>
									<div class="form-group row">
										<div class="col-sm-1" style="text-align: center;">
										<label class="col-form-label"><?php echo ++$count; ?></label>
										</div>
										<div class="col-sm-1">
											<img src="<?php echo $recipe_image; ?>" />
										</div>
										<div class="col-sm-2">
											<input class="form-control" type="text" disabled value="<?php echo $recipe_name; ?>">
										</div>

										<label class="col-sm-1 col-form-label">Quantity</label>
										<div class="col-sm-1">
											<input class="form-control" type="text" disabled value="<?php echo $no_quantity; ?>">
										</div>

										<label class="col-sm-1 col-form-label">Price</label>
										<div class="col-sm-2">
											<input class="form-control" type="text" disabled value="Rs <?php echo $recipe_price; ?>">
										</div>
										
										<label class="col-sm-1 col-form-label">Total</label>
										<div class="col-sm-2">
											<input class="form-control" type="text" disabled value="Rs <?php echo $total1; ?>">
										</div>
									</div>
 <?php } ?>									
								</div>
								<div class="" >
									<div class="">
										<div class="row" style="border-top: 1px solid rgba(0,0,0,0.05);padding: 20px;">
											<div class="col-sm-11">
											</div>
											<div class="col-sm-1">
												<input type="submit" name="update" class="btn" value="Save" />
											</div>
										</div>
									</div>
								</div>
							</form>
							
						</div>
					</div>
				</div>
				<!-- Your Profile Views Chart END-->
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
<script src="assets/vendors/masonry/masonry.js"></script>
<script src="assets/vendors/masonry/filter.js"></script>
<script src="assets/vendors/owl-carousel/owl.carousel.js"></script>
<script src='assets/vendors/scroll/scrollbar.min.js'></script>
<script src="assets/js/functions.js"></script>
<script src="assets/vendors/chart/chart.min.js"></script>
<script src="assets/js/admin.js"></script>
</body>
</html>