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
	$booking_date = date('d/m/Y', strtotime($row['booking_date']));
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
	$coupon = $row['coupon'];
	$redeem_point = $row['redeem_point'];
	
	$amount = "";
	
	if($coupon != 0)
	{
		$amount = $coupon;
	}
	else
	{
		if($redeem_point != 0)
		{
			$amount = $redeem_point;
		}
		else
		{
			$amount = 0;
		}
	}
 }
 if(isset($_POST['status_update']))
{
$orderid		= $_POST['orderid'];
$order_status 	= $_POST['order_status'];
$query = "UPDATE order_details SET order_status = '$order_status' WHERE orderid = '$orderid'";
mysqli_query($conn,$query);
header("Location: view-order.php?id=$id&msg=Status Updated!");
}
 if(isset($_POST['delete']))
{
$orderid		= $_POST['orderid'];
$query1 = "DELETE from order_details WHERE orderid = '$orderid'";
mysqli_query($conn,$query1);
$query2 = "DELETE from recipe_details WHERE orderid = '$orderid'";
mysqli_query($conn,$query2);
header("Location: dashboard.php?msg=Order Deleted!");
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
	<meta name="description" content="View Order | Mato Fresh" />
	
	<!-- OG -->
	<meta property="og:title" content="View Order | Mato Fresh" />
	<meta property="og:description" content="View Order | Mato Fresh" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>View Order | Mato Fresh</title>
	
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
	.btn {width: 100%;}
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
						<div class="col-sm-8">
							<h4>Order ID : <span style="color: #411890; font-weight: 400;"><?php echo $orderid; ?></span></h4>
						</div>
						<?php
								if($rhead["control"] == 2 || $rhead["control"] == 0)
								{
							?>
						<div class="col-sm-2"><a href="send-invoice.php?id=<?php echo $id; ?>" class="btn">Send Invoice</a></div>
						<div class="col-sm-2"><a href="billing.php?id=<?php echo $id; ?>" class="btn" target="_blank;">Billing</a></div>
								<?php } ?>
						</div>
						</div>
						<?php
							$sql1 = "SELECT * FROM user_address WHERE id='$address'";
							$result1 = $conn->query($sql1);
							$row1 = $result1->fetch_assoc();
							
							$mobile_number = $row1["phone"];

							$sql2 = "SELECT * FROM users WHERE phone='$mobile_number'";
							$result2 = $conn->query($sql2);
							$row2 = $result2->fetch_assoc();

							$username = $row2["name"];
							$email = $row2["email"];
							$address = $row1["addr"];
							$landmark = $row1["land"];
						?>
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

										<label class="col-sm-2 col-form-label">Landmark</label>
										<div class="col-sm-4">
											<input class="form-control" type="text" disabled value="<?php echo $landmark; ?>">
										</div>

									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Address</label>
										<div class="col-sm-10">
											<textarea class="form-control" style="max-height: 80px;" disabled ><?php echo $address; ?></textarea>
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
										<label class="col-sm-2 col-form-label">Delivery Type</label>
										<div class="col-sm-4">
											<input class="form-control" type="text" disabled value="<?php echo $delivery_type; ?>">
										</div>
									</div>
									<div class="form-group row">										
										<label class="col-sm-2 col-form-label">Payment Status</label>
										<div class="col-sm-4">
											<input class="form-control" type="text" value="<?php echo $payment_status; ?>" disabled style="background: green;color: #fff;">
										</div>
										<label class="col-sm-2 col-form-label">Delivery Charge</label>
										<div class="col-sm-4">
											<input class="form-control" type="text" disabled value="<?php echo $delivery_charge; ?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-1 col-form-label">Sub Total</label>
										<div class="col-sm-3">
											<input class="form-control" type="text" disabled value="<?php echo $recipe_total_amount; ?>">
										</div>
										<label class="col-sm-1 col-form-label">Discount</label>
										<div class="col-sm-3">
											<input class="form-control" type="text" disabled value="<?php echo $amount ?>">
										</div>
										<label class="col-sm-1 col-form-label">Grand Total</label>
										<div class="col-sm-3">
											<input class="form-control" type="text" disabled value="<?php echo $overall_total_amount ?>" style="background:#42188D;color: #fff;">
										</div>
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
	$recipe_description = $row['description'];
	$recipe_price = number_format($row['recipe_price'],2);
	$no_quantity = $row['no_quantity'];
	$total = $no_quantity * $recipe_price;
	$total1 = number_format($total,2);
?>
									<div class="form-group row">
										<div class="col-sm-1" style="text-align: center;">
										<label class="col-form-label"><?php echo ++$count; ?></label>
										</div>
										
										<div class="col-sm-3">
											<input class="form-control" type="text" disabled value="<?php echo $recipe_name; ?>">
										</div>

										<label class="col-sm-1 col-form-label">Quantity</label>
										<div class="col-sm-1">
											<input class="form-control" type="text" disabled value="<?php echo $no_quantity; ?>">
										</div>

										<label class="col-sm-1 col-form-label">Price</label>
										<div class="col-sm-2">
											<input class="form-control" type="text" disabled value="<?php echo $recipe_price; ?>">
										</div>
										
										<label class="col-sm-1 col-form-label">Total</label>
										<div class="col-sm-2">
											<input class="form-control" type="text" disabled value="<?php echo $total1; ?>">
										</div>
									</div>
 <?php } ?>									
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