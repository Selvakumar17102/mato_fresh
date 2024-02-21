<?php
date_default_timezone_set("Asia/Calcutta");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="POS - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>POS PAYMENT | Mato Fresh</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="asset/css/bootstrap.min.css">
		
		<!-- animation CSS -->
        <link rel="stylesheet" href="asset/css/animate.css">

		<!-- Owl Carousel CSS -->
		<link rel="stylesheet" href="asset/plugins/owlcarousel/owl.carousel.min.css">
		<link rel="stylesheet" href="asset/plugins/owlcarousel/owl.theme.default.min.css">

		<!-- Select2 CSS -->
		<link rel="stylesheet" href="asset/plugins/select2/css/select2.min.css">

		<!-- Datetimepicker CSS -->
		<link rel="stylesheet" href="asset/css/bootstrap-datetimepicker.min.css">

		
        <!-- Fontawesome CSS -->
		<link rel="stylesheet" href="asset/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="asset/plugins/fontawesome/css/all.min.css">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="asset/css/style.css">
		
    </head>
    <body>

		<!-- <div id="global-loader" >
			<div class="whirly-loader"> </div>
		</div> -->
		
		<div class="main-wrappers">
			<?php include_once("inc/header.php");?>
			<div class="page-wrapper ms-0">
				<div class="content">
					<div class="row">
						
						<div class="col-lg-4 col-sm-12 ">
							<div class="card card-order">
								<div class="split-card"></div>
								<div class="card-body pt-0">
									<div class="product-table1">
                                        <h3>Order Details</h3><hr>
                                        <p>Cashier : <span class="text-black"><?php echo "store1" ?></span></p>
                                        <p>
                                            <span class="text-black">Date : <?php echo date('d-m-Y') ?></span>
                                            <span class="text-black float-right">Time : <?php echo date('h:i a') ?></span>
                                        </p>
                                        <p>
                                            <span class="text-black" id="userName"></span>
                                            <span class="text-black" id="userEmail"></span>
                                            <span class="text-black float-right" id="userPhone"></span>
                                        </p>
                                        <hr style="border-color: #161616">
                                        <h6 class="text-black">Items</h6>
										<div id="finalcartProducts"></div>
                                        <hr style="border-color: #161616">
                                        <p>
                                            <span class="text-black">Product Total :</span>
                                            <span class="float-right text-black" id="subTotal"></span>
                                        </p>
                                        <p>
                                            <span class="text-black">GST :</span>
                                            <span class="float-right text-black" id="gstCharge"></span>
                                        </p>
                                        <p>
                                            <span class="text-black">Grant Total :</span>
                                            <span class="text-black float-right">₹ <span id="overallTotal" class="text-black"></span></span>
                                        </p>
                                        <hr style="border-color: #161616">
                                        <p>
                                            <span class="text-black">Mode of payment :</span>
                                            <span class="float-right text-black" id="paymentMode"></span>
                                        </p>
                                        <p>
                                            <span class="text-black">Order Type :</span>
                                            <span class="float-right text-black" id="orderType"></span>
                                        </p>
									</div>
								</div>
								<div class="split-card"></div>
							</div>
						</div>
                        <div class="col-lg-8 col-sm-12 ">
                            <div class="card card-order">
								<div class="split-card"></div>
								<div class="card-body pt-0">
									<div class="product-table1">
                                        <h3>Complete Payment</h3><hr>
                                        <p>Received Amount : </p>
                                        <input id="inputTag" name="value" class="form-control" required>
                                        <p class="text-black mt-3 mb-1 hide" id="balanceToggle">Balance to pay : ₹ <span id="bal">0</span></p>
									</div>
								</div>
								<div class="split-card"></div>
							</div>
                        </div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- jQuery -->
        <script src="asset/js/jquery-3.6.0.min.js"></script>

        <!-- Feather Icon JS -->
		<script src="asset/js/feather.min.js"></script>

		<!-- Slimscroll JS -->
		<script src="asset/js/jquery.slimscroll.min.js"></script>

		<!-- Bootstrap Core JS -->
        <script src="asset/js/bootstrap.bundle.min.js"></script>

		<!-- Datatable JS -->
		<script src="asset/js/jquery.dataTables.min.js"></script>
		<script src="asset/js/dataTables.bootstrap4.min.js"></script>

		<!-- Select2 JS -->
		<script src="asset/plugins/select2/js/select2.min.js"></script>

		<!-- Owl JS -->
		<script src="asset/plugins/owlcarousel/owl.carousel.min.js"></script>

		<!-- Sweetalert 2 -->
		<script src="asset/plugins/sweetalert/sweetalert2.all.min.js"></script>
		<script src="asset/plugins/sweetalert/sweetalerts.min.js"></script>

		<!-- Custom JS -->
		<script src="asset/js/script.js"></script>
		<!-- <script src="asset/js/pos.js"></script> -->
        <script src="asset/js/posPay.js"></script>
		
    </body>
</html>