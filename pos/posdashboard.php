<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="POS - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>POS | Mato Fresh</title>
		
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
						<div class="col-lg-8 col-sm-12 tabs_wrapper" >
							<div class="page-header ">
								<div class="page-title">
									<h4>Categories</h4>
									<h6>Manage your purchases</h6>
								</div>
							</div>
							<ul class=" tabs owl-carousel owl-theme owl-product  border-0 " >
								<li class="active" id="all">
									<div class="product-details">
										<img src="asset/img/product/product62.png" alt="img">
										<h6>All</h6>
									</div>
								</li>
								<?php
								$catSql = "SELECT * FROM `category` WHERE status='0'";
								$catResult = $conn->query($catSql);
								while($catRow = $catResult->fetch_assoc()){
								?>
								<li id="headphone<?php echo $catRow['id']?>">
									<div class="product-details">
										<img src="<?php echo $catRow['image']?>" alt="img">
										<h6><?php echo $catRow['name']?></h6>
									</div>
								</li>
								<?php
								}
								?>
							</ul>
							<div class="tabs_container" >
								<div  class="tab_content active" data-tab="all">
									<div class="row ">
										<?php
										$proSql = "SELECT *,b.id as proid FROM `store_inventory` a LEFT OUTER JOIN product b ON a.product_id=b.id LEFT OUTER JOIN price c ON a.product_id=c.pid WHERE a.store_id = '$store_id'";
										$proResult = $conn->query($proSql);
										while($proRow = $proResult->fetch_assoc()){
											$proid =$proRow['proid'];
										?>
											<div class="col-lg-3 col-sm-6 d-flex">
												<a onclick="add('<?php echo $proid;?>')">
												<div class="productset flex-fill">
													<div class="productsetimg">
														<img src="<?php echo $proRow['image'];?>" alt="img">
														<h6>available: <?php echo $proRow['store_quantity'].' kg'?></h6>
														<!-- <div class="check-product">
															<i class="fa fa-check"></i>
														</div> -->
													</div>
													<div class="productsetcontent">
														<h4><?php echo $proRow['name']?></h4>
														<h5 style="color:blue"><?php echo $proRow['weight']?></h5>
														<h6 style="color:green">₹ <?php echo $proRow['amo']?>.00</h6>
													</div>
												</div>
												</a>
											</div>
										<?php
										}
										?>
										
									</div>
								</div>
								<?php
								$catSql1 = "SELECT * FROM `category` WHERE status='0'";
								$catResult1 = $conn->query($catSql1);
								while($catRow1 = $catResult1->fetch_assoc()){
									$getid=$catRow1['id'];
								?>
								<div class="tab_content" data-tab="headphone<?php echo $catRow1['id']?>">
									<div class="row ">
										<?php
										$singleproSql = "SELECT *,b.image as productimage,b.name as productname FROM `store_inventory` a LEFT OUTER JOIN product b ON a.product_id=b.id LEFT OUTER JOIN category c ON b.cate=c.id LEFT OUTER JOIN price d ON b.id=d.pid WHERE a.store_id='$store_id' AND c.id='$getid'";
										$singleproResult = $conn->query($singleproSql);
										while($singleproRow = $singleproResult->fetch_assoc()){
										?>
										<div class="col-lg-3 col-sm-6 d-flex">
											<div class="productset flex-fill">
												<div class="productsetimg">
													<img src="<?php echo $singleproRow['productimage']?>" alt="img">
													<h6>available: <?php echo $singleproRow['store_quantity'].' kg'?></h6>
													<div class="check-product">
														<i class="fa fa-check"></i>
													</div>
												</div>
												<div class="productsetcontent">
													<h4><?php echo $singleproRow['productname']?></h4>
													<h4 style="color:blue"><?php echo $singleproRow['weight']?></h4>
													<h6 style="color:green">₹ <?php echo $singleproRow['amo']?>.00</h6>
												</div>
											</div>
										</div>
										<?php
										}
										?>
										<!-- <div class="col-lg-3 col-sm-6 d-flex ">
											<div class="productset flex-fill">
												<div class="productsetimg">
													<img src="asset/img/product/product45.jpg" alt="img">
													<h6>Qty: 5.00</h6>
													<div class="check-product">
														<i class="fa fa-check"></i>
													</div>
												</div>
												<div class="productsetcontent">
													<h5>Headphones</h5>
													<h4>Earphones</h4>
													<h6>150.00</h6>
												</div>
											</div>
										</div>
										<div class="col-lg-3 col-sm-6 d-flex ">
											<div class="productset flex-fill">
												<div class="productsetimg">
													<img src="asset/img/product/product36.jpg" alt="img">
													<h6>Qty: 5.00</h6>
													<div class="check-product">
														<i class="fa fa-check"></i>
													</div>
												</div>
												<div class="productsetcontent">
													<h5>Headphones</h5>
													<h4>Earphones</h4>
													<h6>150.00</h6>
												</div>
											</div>
										</div> -->
									</div>
								</div>
								<?php
								}
								?>
								<!-- <div class="tab_content" data-tab="Accessories">
									<div class="row">
										<div class="col-lg-3 col-sm-6 d-flex ">
											<div class="productset flex-fill">
												<div class="productsetimg">
													<img src="asset/img/product/product32.jpg" alt="img">
													<h6>Qty: 1.00</h6>
													<div class="check-product">
														<i class="fa fa-check"></i>
													</div>
												</div>
												<div class="productsetcontent">
													<h5>Accessories</h5>
													<h4>Sunglasses</h4>
													<h6>15.00</h6>
												</div>
											</div>
										</div>
										<div class="col-lg-3 col-sm-6 d-flex ">
											<div class="productset flex-fill">
												<div class="productsetimg">
													<img src="asset/img/product/product46.jpg" alt="img">
													<h6>Qty: 1.00</h6>
													<div class="check-product">
														<i class="fa fa-check"></i>
													</div>
												</div>
												<div class="productsetcontent">
													<h5>Accessories</h5>
													<h4>Pendrive</h4>
													<h6>150.00</h6>
												</div>
											</div>
										</div>
										<div class="col-lg-3 col-sm-6 d-flex ">
											<div class="productset flex-fill">
												<div class="productsetimg">
													<img src="asset/img/product/product55.jpg" alt="img">
													<h6>Qty: 1.00</h6>
													<div class="check-product">
														<i class="fa fa-check"></i>
													</div>
												</div>
												<div class="productsetcontent">
													<h5>Accessories</h5>
													<h4>Mouse</h4>
													<h6>150.00</h6>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab_content" data-tab="Shoes">
									<div class="row">
										<div class="col-lg-3 col-sm-6 d-flex ">
											<div class="productset flex-fill">
												<div class="productsetimg">
													<img src="asset/img/product/product60.jpg" alt="img">
													<h6>Qty: 1.00</h6>
													<div class="check-product">
														<i class="fa fa-check"></i>
													</div>
												</div>
												<div class="productsetcontent">
													<h5>Shoes</h5>
													<h4>Red nike</h4>
													<h6>1500.00</h6>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab_content" data-tab="computer">
									<div class="row">
										
										<div class="col-lg-3 col-sm-6 d-flex ">
											<div class="productset flex-fill">
												<div class="productsetimg">
													<img src="asset/img/product/product56.jpg" alt="img">
													<h6>Qty: 1.00</h6>
													<div class="check-product">
														<i class="fa fa-check"></i>
													</div>
												</div>
												<div class="productsetcontent">
													<h5>Computers</h5>
													<h4>Desktop</h4>
													<h6>1500.00</h6>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab_content" data-tab="Snacks">
									<div class="row">
										<div class="col-lg-3 col-sm-6 d-flex ">
											<div class="productset flex-fill">
												<div class="productsetimg">
													<img src="asset/img/product/product47.jpg" alt="img">
													<h6>Qty: 1.00</h6>
													<div class="check-product">
														<i class="fa fa-check"></i>
													</div>
												</div>
												<div class="productsetcontent">
													<h5>Snacks</h5>
													<h4>Duck Salad</h4>
													<h6>1500.00</h6>
												</div>
											</div>
										</div>
										<div class="col-lg-3 col-sm-6 d-flex ">
											<div class="productset flex-fill">
												<div class="productsetimg">
													<img src="asset/img/product/product48.png" alt="img">
													<h6>Qty: 1.00</h6>
													<div class="check-product">
														<i class="fa fa-check"></i>
													</div>
												</div>
												<div class="productsetcontent">
													<h5>Snacks</h5>
													<h4>Breakfast board</h4>
													<h6>1500.00</h6>
												</div>
											</div>
										</div>
										<div class="col-lg-3 col-sm-6 d-flex ">
											<div class="productset flex-fill">
												<div class="productsetimg">
													<img src="asset/img/product/product57.jpg" alt="img">
													<h6>Qty: 1.00</h6>
													<div class="check-product">
														<i class="fa fa-check"></i>
													</div>
												</div>
												<div class="productsetcontent">
													<h5>Snacks</h5>
													<h4>California roll</h4>
													<h6>1500.00</h6>
												</div>
											</div>
										</div>
										<div class="col-lg-3 col-sm-6 d-flex ">
											<div class="productset flex-fill">
												<div class="productsetimg">
													<img src="asset/img/product/product58.jpg" alt="img">
													<h6>Qty: 1.00</h6>
													<div class="check-product">
														<i class="fa fa-check"></i>
													</div>
												</div>
												<div class="productsetcontent">
													<h5>Snacks</h5>
													<h4>Sashimi</h4>
													<h6>1500.00</h6>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab_content" data-tab="watch">
									<div class="row">
										<div class="col-lg-3 col-sm-6 d-flex ">
											<div class="productset flex-fill">
												<div class="productsetimg">
													<img src="asset/img/product/product49.jpg" alt="img">
													<h6>Qty: 1.00</h6>
													<div class="check-product">
														<i class="fa fa-check"></i>
													</div>
												</div>
												<div class="productsetcontent">
													<h4>Watch</h4>
													<h5>Watch</h5>
													<h6>1500.00</h6>
												</div>
											</div>
										</div>
										<div class="col-lg-3 col-sm-6 d-flex ">
											<div class="productset flex-fill">
												<div class="productsetimg">
													<img src="asset/img/product/product51.jpg" alt="img">
													<h6>Qty: 1.00</h6>
												</div>
												<div class="productsetcontent">
													<h4>Watch</h4>
													<h5>Watch</h5>
													<h6>1500.00</h6>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab_content" data-tab="cycle">
									<div class="row">
										<div class="col-lg-3 col-sm-6 d-flex ">
											<div class="productset flex-fill">
												<div class="productsetimg">
													<img src="asset/img/product/product52.jpg" alt="img">
													<h6>Qty: 1.00</h6>
													<div class="check-product">
														<i class="fa fa-check"></i>
													</div>
												</div>
												<div class="productsetcontent">
													<h4>Cycle</h4>
													<h5>Cycle</h5>
													<h6>1500.00</h6>
												</div>
											</div>
										</div>
										<div class="col-lg-3 col-sm-6 d-flex ">
											<div class="productset flex-fill">
												<div class="productsetimg">
													<img src="asset/img/product/product53.jpg" alt="img">
													<h6>Qty: 1.00</h6>
													<div class="check-product">
														<i class="fa fa-check"></i>
													</div>
												</div>
												<div class="productsetcontent">
													<h4>Cycle</h4>
													<h5>Cycle</h5>
													<h6>1500.00</h6>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div  class="tab_content" data-tab="fruits1">
									<div class="row ">
										
										<div class="col-lg-3 col-sm-6 d-flex ">
											<div class="productset flex-fill">
												<div class="productsetimg">
													<img src="asset/img/product/product29.jpg" alt="img">
													<h6>Qty: 5.00</h6>
													<div class="check-product">
														<i class="fa fa-check"></i>
													</div>
												</div>
												<div class="productsetcontent">
													<h5>Fruits</h5>
													<h4>Orange</h4>
													<h6>150.00</h6>
												</div>
											</div>
										</div>
										<div class="col-lg-3 col-sm-6 d-flex ">
											<div class="productset flex-fill">
												<div class="productsetimg">
													<img src="asset/img/product/product31.jpg" alt="img">
													<h6>Qty: 1.00</h6>
													<div class="check-product">
														<i class="fa fa-check"></i>
													</div>
												</div>
												<div class="productsetcontent">
													<h5>Fruits</h5>
													<h4>Strawberry</h4>
													<h6>15.00</h6>
												</div>
											</div>
										</div>
										
										<div class="col-lg-3 col-sm-6 d-flex ">
											<div class="productset flex-fill">
												<div class="productsetimg">
													<img src="asset/img/product/product35.jpg" alt="img">
													<h6>Qty: 5.00</h6>
													<div class="check-product">
														<i class="fa fa-check"></i>
													</div>
												</div>
												<div class="productsetcontent">
													<h5>Fruits</h5>
													<h4>Banana</h4>
													<h6>150.00</h6>
												</div>
											</div>
										</div>
									
										<div class="col-lg-3 col-sm-6 d-flex ">
											<div class="productset flex-fill">
												<div class="productsetimg">
													<img src="asset/img/product/product37.jpg" alt="img">
													<h6>Qty: 5.00</h6>
													<div class="check-product">
														<i class="fa fa-check"></i>
													</div>
												</div>
												<div class="productsetcontent">
													<h5>Fruits</h5>
													<h4>Limon</h4>
													<h6>1500.00</h6>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab_content" data-tab="headphone1">
									<div class="row ">
										<div class="col-lg-3 col-sm-6 d-flex ">
											<div class="productset flex-fill">
												<div class="productsetimg">
													<img src="asset/img/product/product44.jpg" alt="img">
													<h6>Qty: 5.00</h6>
													<div class="check-product">
														<i class="fa fa-check"></i>
													</div>
												</div>
												<div class="productsetcontent">
													<h5>Headphones</h5>
													<h4>Earphones</h4>
													<h6>150.00</h6>
												</div>
											</div>
										</div>
										<div class="col-lg-3 col-sm-6 d-flex ">
											<div class="productset flex-fill">
												<div class="productsetimg">
													<img src="asset/img/product/product45.jpg" alt="img">
													<h6>Qty: 5.00</h6>
													<div class="check-product">
														<i class="fa fa-check"></i>
													</div>
												</div>
												<div class="productsetcontent">
													<h5>Headphones</h5>
													<h4>Earphones</h4>
													<h6>150.00</h6>
												</div>
											</div>
										</div>
										<div class="col-lg-3 col-sm-6 d-flex ">
											<div class="productset flex-fill">
												<div class="productsetimg">
													<img src="asset/img/product/product36.jpg" alt="img">
													<h6>Qty: 5.00</h6>
													<div class="check-product">
														<i class="fa fa-check"></i>
													</div>
												</div>
												<div class="productsetcontent">
													<h5>Headphones</h5>
													<h4>Earphones</h4>
													<h6>150.00</h6>
												</div>
											</div>
										</div>
									</div>
								</div> -->
							</div>
						</div>
						<div class="col-lg-4 col-sm-12 ">
							<!-- <div class="order-list">
								<div class="orderid">
									<h4>Order List</h4>
									<h5>Transaction id : #65565</h5>
								</div>
								<div class="actionproducts">
									<ul>
										<li>
											<a href="javascript:void(0);" class="deletebg confirm-text"><img src="asset/img/icons/delete-2.svg" alt="img"></a>
										</li>
										<li>
											<a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" class="dropset" >
												<img src="asset/img/icons/ellipise1.svg" alt="img">
											</a>
											<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" data-popper-placement="bottom-end">
												<li>
													<a href="#" class="dropdown-item">Action</a>
												</li>
												<li>
													<a href="#" class="dropdown-item">Another Action</a>
												</li>
												<li>
													<a href="#" class="dropdown-item">Something Elses</a>
												</li>
											</ul>
										</li>
									</ul>
								</div>
							</div> -->
							<div class="card card-order">
								<!-- <div class="card-body">
									<div class="row">
										<div class="col-12">
											<a href="javascript:void(0);" class="btn btn-adds" data-bs-toggle="modal" data-bs-target="#create"><i class="fa fa-plus me-2"></i>Add Customer</a>
										</div>
										<div class="col-lg-12">
											<div class="select-split ">
												<div class="select-group w-100">
													<select class="select">
														<option>Walk-in Customer</option>
														<option>Chris Moris</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-12">
											<div class="select-split">
												<div class="select-group w-100">
													<select class="select">
														<option>Product </option>
														<option>Barcode</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-12">
											<div class="text-end">
												<a class="btn btn-scanner-set"><img src="asset/img/icons/scanner1.svg" alt="img" class="me-2">Scan bardcode</a>
											</div>
										</div>
									</div>
								</div> -->
								<div class="split-card">
								</div>
								<div class="card-body pt-0">
									<div class="totalitem">
										<h4>Total items : <b id="totalitem"></b></h4>
										<a onclick="clearCart()">Clear all</a>
									</div>
									<div class="product-table">
										<div id="cartProducts"></div>
										<!-- <ul class="product-lists">
											<li>
												<div class="productimg">
													<div class="productimgs">
														<img src="asset/img/product/product30.jpg" alt="img">
													</div>
													<div class="productcontet">
														<h4>Pineapple 
														<a href="javascript:void(0);" class="ms-2" data-bs-toggle="modal" data-bs-target="#edit"><img src="asset/img/icons/edit-5.svg" alt="img"></a>
														</h4>
														<div class="productlinkset">
															<h5>PT001</h5>
														</div>
														<div class="increment-decrement">
															<div class="input-groups">
																<input type="button" value="-"  class="button-minus dec button">
																<input type="text" name="child"  value="0" class="quantity-field">
																<input type="button" value="+"  class="button-plus inc button ">
															</div>
														</div>
													</div>
												</div>
											</li>
											<li>3000.00	</li>
											<li><a class="confirm-text" href="javascript:void(0);"><img src="asset/img/icons/delete-2.svg" alt="img"></a></li>
										</ul> -->
										<!-- <ul class="product-lists">
											<li>
												<div class="productimg">
													<div class="productimgs">
														<img src="asset/img/product/product34.jpg" alt="img">
													</div>
													<div class="productcontet">
														<h4>Green Nike 
														<a href="javascript:void(0);" class="ms-2" data-bs-toggle="modal" data-bs-target="#edit"><img src="asset/img/icons/edit-5.svg" alt="img"></a>
														</h4>
														<div class="productlinkset">
															<h5>PT001</h5>
														</div> 
														<div class="increment-decrement">
															<div class="input-groups">
																<input type="button" value="-"  class="button-minus dec button">
																<input type="text" name="child"  value="0" class="quantity-field">
																<input type="button" value="+"  class="button-plus inc button ">
															</div>
														</div>
													</div>
												</div>
											</li>
											<li>3000.00	</li>
											<li><a class="confirm-text" href="javascript:void(0);"><img src="asset/img/icons/delete-2.svg" alt="img"></a></li>
										</ul>
										<ul class="product-lists">
											<li>
												<div class="productimg">
													<div class="productimgs">
														<img src="asset/img/product/product35.jpg" alt="img">
													</div>
													<div class="productcontet">
														<h4>Banana
														<a href="javascript:void(0);" class="ms-2" data-bs-toggle="modal" data-bs-target="#edit"><img src="asset/img/icons/edit-5.svg" alt="img"></a>
														</h4>
														<div class="productlinkset">
															<h5>PT001</h5>
														</div>
														<div class="increment-decrement">
															<div class="input-groups">
																<input type="button" value="-"  class="button-minus dec button">
																<input type="text" name="child"  value="0" class="quantity-field">
																<input type="button" value="+"  class="button-plus inc button ">
															</div>
														</div>
													</div>
												</div>
											</li>
											<li>3000.00	</li>
											<li><a class="confirm-text" href="javascript:void(0);"><img src="asset/img/icons/delete-2.svg" alt="img"></a></li>
										</ul>
										<ul class="product-lists">
											<li>
												<div class="productimg">
													<div class="productimgs">
														<img src="asset/img/product/product31.jpg" alt="img">
													</div>
													<div class="productcontet">
														<h4>Strawberry
														<a href="javascript:void(0);" class="ms-2" data-bs-toggle="modal" data-bs-target="#edit"><img src="asset/img/icons/edit-5.svg" alt="img"></a>
														</h4>
														<div class="productlinkset">
															<h5>PT001</h5>
														</div>
														<div class="increment-decrement">
															<div class="input-groups">
																<input type="button" value="-"  class="button-minus dec button">
																<input type="text" name="child"  value="0" class="quantity-field">
																<input type="button" value="+"  class="button-plus inc button ">
															</div>
														</div>
													</div>
												</div>
											</li>
											<li>3000.00	</li>
											<li><a class="confirm-text" href="javascript:void(0);"><img src="asset/img/icons/delete-2.svg" alt="img"></a></li>
										</ul> -->
									</div>
								</div>
								<div class="split-card">
								</div>
								<div class="card-body pt-0 pb-2">
									<div class="setvalue">
										<ul>
											<li>
												<h5>Subtotal</h5>
												<h6 id="subTotal"></h6>
											</li>
											<li>
												<h5>Tax </h5>
												<h6 id="gstTotal"></h6>
											</li>
											<li class="total-value">
												<h5>Total  </h5>
												<h6 id="grandTotal"></h6>
											</li>
										</ul>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-lg-12 col-sm-12 col-12">
												<div class="form-group">
													<label>Customer Name</label>
													<input type="text" placeholder = "Enter customer name">
													<label>Customer Email</label>
													<input type="text" placeholder = "Enter customer email">
													<label>Customer Phone</label>
													<input type="text" placeholder = "Enter customer phone number">
												</div>
											</div>
											<!-- <div class="col-lg-12 col-sm-12 col-12">
												<div class="form-group">
													<label>Email</label>
													<input type="text">
												</div>
											</div> -->
											<!-- <div class="col-lg-12 col-sm-12 col-12">
												<div class="form-group">
													<label>Phone</label>
													<input type="text">
												</div>
											</div> -->
										<!-- <div class="col-12">
											<a href="javascript:void(0);" class="btn btn-adds" data-bs-toggle="modal" data-bs-target="#create"><i class="fa fa-plus me-2"></i>Add Customer</a>
										</div> -->
										<div class="col-lg-12">
											<div class="select-split ">
												<div class="select-group w-100">
													<select class="select">
														<option>Walk-in Customer</option>
														<option>Chris Moris</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-12">
											<div class="select-split">
												<div class="select-group w-100">
													<select class="select">
														<option>Product </option>
														<option>Barcode</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-12">
											<div class="text-end">
												<a class="btn btn-scanner-set"><img src="asset/img/icons/scanner1.svg" alt="img" class="me-2">Scan bardcode</a>
											</div>
										</div>
									</div>
								</div>
									<div class="setvaluecash">
										<ul>
											<li>
												<a href="javascript:void(0);" class="paymentmethod">
													<img src="asset/img/icons/cash.svg" alt="img" class="me-2">
													Cash
												</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="paymentmethod">
													<img src="asset/img/icons/debitcard.svg" alt="img" class="me-2">
													Debit
												</a>
											</li>
											<li>
												<a href="javascript:void(0);" class="paymentmethod">
													<img src="asset/img/icons/scan.svg" alt="img" class="me-2">
													Scan
												</a>
											</li>
										</ul>
									</div>		
									<div class="btn-totallabel">
										<h5>Checkout</h5>
										<h6>60.00$</h6>
									</div>							
									<div class="btn-pos">
										<ul>
											<li>
												<a class="btn"><img src="asset/img/icons/pause1.svg" alt="img" class="me-1">Hold</a>
											</li>
											<li>
												<a class="btn"><img src="asset/img/icons/edit-6.svg" alt="img" class="me-1">Quotation</a>
											</li>
											<li>
												<a class="btn"><img src="asset/img/icons/trash12.svg" alt="img" class="me-1">Void</a>
											</li>
											<li>
												<a class="btn"><img src="asset/img/icons/wallet1.svg" alt="img" class="me-1">Payment</a>
											</li>
											<li>
												<a class="btn"  data-bs-toggle="modal" data-bs-target="#recents"><img src="asset/img/icons/transcation.svg" alt="img" class="me-1"> Transaction</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="calculator" tabindex="-1"   aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						 <h5 class="modal-title" >Define Quantity</h5>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="calculator-set">
							<div class="calculatortotal">
								<h4>0</h4>
							</div>
							<ul>
								<li>
									<a href="javascript:void(0);">1</a>
								</li>
								<li>
									<a href="javascript:void(0);">2</a>
								</li>
								<li>
									<a href="javascript:void(0);">3</a>
								</li>
								<li>
									<a href="javascript:void(0);">4</a>
								</li>
								<li>
									<a href="javascript:void(0);">5</a>
								</li>
								<li>
									<a href="javascript:void(0);">6</a>
								</li>
								<li>
									<a href="javascript:void(0);">7</a>
								</li>
								<li>
									<a href="javascript:void(0);">8</a>
								</li>
								<li>
									<a href="javascript:void(0);">9</a>
								</li>
								<li>
									<a href="javascript:void(0);" class="btn btn-closes"><img src="asset/img/icons/close-circle.svg" alt="img"></a>
								</li>
								<li>
									<a href="javascript:void(0);">0</a>
								</li>
								<li>
									<a href="javascript:void(0);" class="btn btn-reverse"><img src="asset/img/icons/reverse.svg" alt="img"></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="holdsales" tabindex="-1"    aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						 <h5 class="modal-title" >Hold order</h5>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="hold-order">
							<h2>4500.00</h2>
						</div>
						<div class="form-group">
							<label>Order Reference</label>
							<input type="text">
						</div>
						<div class="para-set">
							<p>The current order will be set on hold. You can retreive this order from the pending order button. Providing a reference to it might help you to identify the order more quickly.</p>
						</div>
						<div class="col-lg-12">
							<a class="btn btn-submit me-2">Submit</a>
							<a class="btn btn-cancel" data-bs-dismiss="modal">Cancel</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="edit" tabindex="-1"    aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						 <h5 class="modal-title" >Edit Order</h5>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-6 col-sm-12 col-12">
								<div class="form-group">
									<label>Product Price</label>
									<input type="text" value="20">
								</div>
							</div>
							<div class="col-lg-6 col-sm-12 col-12">
								<div class="form-group">
									<label>Product Price</label>
									<select class="select">
										<option>Exclusive</option>
										<option>Inclusive</option>
									</select>
								</div>
							</div>
							<div class="col-lg-6 col-sm-12 col-12">
								<div class="form-group">
									<label> Tax</label>
									<div class="input-group">
										<input type="text">
										<a class="scanner-set input-group-text">
											%
										</a>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-sm-12 col-12">
								<div class="form-group">
									<label>Discount Type</label>
									<select class="select">
										<option>Fixed</option>
										<option>Percentage</option>
									</select>
								</div>
							</div>
							<div class="col-lg-6 col-sm-12 col-12">
								<div class="form-group">
									<label>Discount</label>
									<input type="text" value="20">
								</div>
							</div>
							<div class="col-lg-6 col-sm-12 col-12">
								<div class="form-group">
									<label>Sales Unit</label>
									<select class="select">
										<option>Kilogram</option>
										<option>Grams</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<a class="btn btn-submit me-2">Submit</a>
							<a class="btn btn-cancel" data-bs-dismiss="modal">Cancel</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="create" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						 <h5 class="modal-title" >Create</h5>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-6 col-sm-12 col-12">
								<div class="form-group">
									<label>Customer Name</label>
									<input type="text">
								</div>
							</div>
							<div class="col-lg-6 col-sm-12 col-12">
								<div class="form-group">
									<label>Email</label>
									<input type="text">
								</div>
							</div>
							<div class="col-lg-6 col-sm-12 col-12">
								<div class="form-group">
									<label>Phone</label>
									<input type="text">
								</div>
							</div>
							<div class="col-lg-6 col-sm-12 col-12">
								<div class="form-group">
									<label>Country</label>
									<input type="text">
								</div>
							</div>
							<div class="col-lg-6 col-sm-12 col-12">
								<div class="form-group">
									<label>City</label>
									<input type="text" >
								</div>
							</div>
							<div class="col-lg-6 col-sm-12 col-12">
								<div class="form-group">
									<label>Address</label>
									<input type="text" >
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<a class="btn btn-submit me-2">Submit</a>
							<a class="btn btn-cancel" data-bs-dismiss="modal">Cancel</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="delete" tabindex="-1"    aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						 <h5 class="modal-title" >Order Deletion</h5>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="delete-order">
							<img src="asset/img/icons/close-circle1.svg" alt="img">
						</div>
						<div class="para-set text-center">
							<p>The current order will be deleted as no payment has been <br> made so far.</p>
						</div>
						<div class="col-lg-12 text-center">
							<a class="btn btn-danger me-2">Yes</a>
							<a class="btn btn-cancel" data-bs-dismiss="modal">No</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="recents" tabindex="-1"    aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						 <h5 class="modal-title" >Recent Transactions</h5>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="tabs-sets">
							<ul class="nav nav-tabs" id="myTabs" role="tablist">
								<li class="nav-item" role="presentation">
								  <button class="nav-link active" id="purchase-tab" data-bs-toggle="tab" data-bs-target="#purchase" type="button"   aria-controls="purchase" aria-selected="true" role="tab">Purchase</button>
								</li>
								<li class="nav-item" role="presentation">
								  <button class="nav-link" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment" type="button"   aria-controls="payment" aria-selected="false" role="tab">Payment</button>
								</li>
								<li class="nav-item" role="presentation">
								  <button class="nav-link" id="return-tab" data-bs-toggle="tab" data-bs-target="#return" type="button"   aria-controls="return" aria-selected="false" role="tab">Return</button>
								</li>
							  </ul>
							  <div class="tab-content" >
								<div class="tab-pane fade show active" id="purchase" role="tabpanel" aria-labelledby="purchase-tab">
									<div class="table-top">
										<div class="search-set">
											<div class="search-input">
												<a class="btn btn-searchset"><img src="asset/img/icons/search-white.svg" alt="img"></a>
											</div>
										</div>
										<div class="wordset">
											<ul>
												<li>
													<a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img src="asset/img/icons/pdf.svg" alt="img"></a>
												</li>
												<li>
													<a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img src="asset/img/icons/excel.svg" alt="img"></a>
												</li>
												<li>
													<a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img src="asset/img/icons/printer.svg" alt="img"></a>
												</li>
											</ul>
										</div>
									</div>
									<div class="table-responsive">
										<table class="table datanew">
											<thead>
												<tr>
													<th>Date</th>
													<th>Reference</th>
													<th>Customer</th>
													<th>Amount	</th>
													<th class="text-end">Action</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>2022-03-07	</td>
													<td>INV/SL0101</td>
													<td>Walk-in Customer</td>
													<td>$ 1500.00</td>
													<td>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/eye.svg" alt="img">
														</a>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/edit.svg" alt="img">
														</a>
														<a class="me-3 confirm-text" href="javascript:void(0);">
															<img src="asset/img/icons/delete.svg" alt="img">
														</a>
													</td>
												</tr>
												<tr>
													<td>2022-03-07	</td>
													<td>INV/SL0101</td>
													<td>Walk-in Customer</td>
													<td>$ 1500.00</td>
													<td>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/eye.svg" alt="img">
														</a>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/edit.svg" alt="img">
														</a>
														<a class="me-3 confirm-text" href="javascript:void(0);">
															<img src="asset/img/icons/delete.svg" alt="img">
														</a>
													</td>
												</tr>
												<tr>
													<td>2022-03-07	</td>
													<td>INV/SL0101</td>
													<td>Walk-in Customer</td>
													<td>$ 1500.00</td>
													<td>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/eye.svg" alt="img">
														</a>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/edit.svg" alt="img">
														</a>
														<a class="me-3 confirm-text" href="javascript:void(0);">
															<img src="asset/img/icons/delete.svg" alt="img">
														</a>
													</td>
												</tr>
												<tr>
													<td>2022-03-07	</td>
													<td>INV/SL0101</td>
													<td>Walk-in Customer</td>
													<td>$ 1500.00</td>
													<td>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/eye.svg" alt="img">
														</a>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/edit.svg" alt="img">
														</a>
														<a class="me-3 confirm-text" href="javascript:void(0);">
															<img src="asset/img/icons/delete.svg" alt="img">
														</a>
													</td>
												</tr>
												<tr>
													<td>2022-03-07	</td>
													<td>INV/SL0101</td>
													<td>Walk-in Customer</td>
													<td>$ 1500.00</td>
													<td>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/eye.svg" alt="img">
														</a>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/edit.svg" alt="img">
														</a>
														<a class="me-3 confirm-text" href="javascript:void(0);">
															<img src="asset/img/icons/delete.svg" alt="img">
														</a>
													</td>
												</tr>
												<tr>
													<td>2022-03-07	</td>
													<td>INV/SL0101</td>
													<td>Walk-in Customer</td>
													<td>$ 1500.00</td>
													<td>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/eye.svg" alt="img">
														</a>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/edit.svg" alt="img">
														</a>
														<a class="me-3 confirm-text" href="javascript:void(0);">
															<img src="asset/img/icons/delete.svg" alt="img">
														</a>
													</td>
												</tr>
												<tr>
													<td>2022-03-07	</td>
													<td>INV/SL0101</td>
													<td>Walk-in Customer</td>
													<td>$ 1500.00</td>
													<td>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/eye.svg" alt="img">
														</a>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/edit.svg" alt="img">
														</a>
														<a class="me-3 confirm-text" href="javascript:void(0);">
															<img src="asset/img/icons/delete.svg" alt="img">
														</a>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane fade" id="payment" role="tabpanel" >
									<div class="table-top">
										<div class="search-set">
											<div class="search-input">
												<a class="btn btn-searchset"><img src="asset/img/icons/search-white.svg" alt="img"></a>
											</div>
										</div>
										<div class="wordset">
											<ul>
												<li>
													<a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img src="asset/img/icons/pdf.svg" alt="img"></a>
												</li>
												<li>
													<a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img src="asset/img/icons/excel.svg" alt="img"></a>
												</li>
												<li>
													<a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img src="asset/img/icons/printer.svg" alt="img"></a>
												</li>
											</ul>
										</div>
									</div>
									<div class="table-responsive">
										<table class="table datanew">
											<thead>
												<tr>
													<th>Date</th>
													<th>Reference</th>
													<th>Customer</th>
													<th>Amount	</th>
													<th class="text-end">Action</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>2022-03-07	</td>
													<td>0101</td>
													<td>Walk-in Customer</td>
													<td>$ 1500.00</td>
													<td>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/eye.svg" alt="img">
														</a>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/edit.svg" alt="img">
														</a>
														<a class="me-3 confirm-text" href="javascript:void(0);">
															<img src="asset/img/icons/delete.svg" alt="img">
														</a>
													</td>
												</tr>
												<tr>
													<td>2022-03-07	</td>
													<td>0102</td>
													<td>Walk-in Customer</td>
													<td>$ 1500.00</td>
													<td>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/eye.svg" alt="img">
														</a>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/edit.svg" alt="img">
														</a>
														<a class="me-3 confirm-text" href="javascript:void(0);">
															<img src="asset/img/icons/delete.svg" alt="img">
														</a>
													</td>
												</tr>
												<tr>
													<td>2022-03-07	</td>
													<td>0103</td>
													<td>Walk-in Customer</td>
													<td>$ 1500.00</td>
													<td>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/eye.svg" alt="img">
														</a>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/edit.svg" alt="img">
														</a>
														<a class="me-3 confirm-text" href="javascript:void(0);">
															<img src="asset/img/icons/delete.svg" alt="img">
														</a>
													</td>
												</tr>
												<tr>
													<td>2022-03-07	</td>
													<td>0104</td>
													<td>Walk-in Customer</td>
													<td>$ 1500.00</td>
													<td>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/eye.svg" alt="img">
														</a>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/edit.svg" alt="img">
														</a>
														<a class="me-3 confirm-text" href="javascript:void(0);">
															<img src="asset/img/icons/delete.svg" alt="img">
														</a>
													</td>
												</tr>
												<tr>
													<td>2022-03-07	</td>
													<td>0105</td>
													<td>Walk-in Customer</td>
													<td>$ 1500.00</td>
													<td>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/eye.svg" alt="img">
														</a>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/edit.svg" alt="img">
														</a>
														<a class="me-3 confirm-text" href="javascript:void(0);">
															<img src="asset/img/icons/delete.svg" alt="img">
														</a>
													</td>
												</tr>
												<tr>
													<td>2022-03-07	</td>
													<td>0106</td>
													<td>Walk-in Customer</td>
													<td>$ 1500.00</td>
													<td>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/eye.svg" alt="img">
														</a>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/edit.svg" alt="img">
														</a>
														<a class="me-3 confirm-text" href="javascript:void(0);">
															<img src="asset/img/icons/delete.svg" alt="img">
														</a>
													</td>
												</tr>
												<tr>
													<td>2022-03-07	</td>
													<td>0107</td>
													<td>Walk-in Customer</td>
													<td>$ 1500.00</td>
													<td>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/eye.svg" alt="img">
														</a>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/edit.svg" alt="img">
														</a>
														<a class="me-3 confirm-text" href="javascript:void(0);">
															<img src="asset/img/icons/delete.svg" alt="img">
														</a>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane fade" id="return" role="tabpanel" >
									<div class="table-top">
										<div class="search-set">
											<div class="search-input">
												<a class="btn btn-searchset"><img src="asset/img/icons/search-white.svg" alt="img"></a>
											</div>
										</div>
										<div class="wordset">
											<ul>
												<li>
													<a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img src="asset/img/icons/pdf.svg" alt="img"></a>
												</li>
												<li>
													<a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img src="asset/img/icons/excel.svg" alt="img"></a>
												</li>
												<li>
													<a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img src="asset/img/icons/printer.svg" alt="img"></a>
												</li>
											</ul>
										</div>
									</div>
									<div class="table-responsive">
										<table class="table datanew">
											<thead>
												<tr>
													<th>Date</th>
													<th>Reference</th>
													<th>Customer</th>
													<th>Amount	</th>
													<th class="text-end">Action</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>2022-03-07	</td>
													<td>0101</td>
													<td>Walk-in Customer</td>
													<td>$ 1500.00</td>
													<td>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/eye.svg" alt="img">
														</a>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/edit.svg" alt="img">
														</a>
														<a class="me-3 confirm-text" href="javascript:void(0);">
															<img src="asset/img/icons/delete.svg" alt="img">
														</a>
													</td>
												</tr>
												<tr>
													<td>2022-03-07	</td>
													<td>0102</td>
													<td>Walk-in Customer</td>
													<td>$ 1500.00</td>
													<td>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/eye.svg" alt="img">
														</a>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/edit.svg" alt="img">
														</a>
														<a class="me-3 confirm-text" href="javascript:void(0);">
															<img src="asset/img/icons/delete.svg" alt="img">
														</a>
													</td>
												</tr>
												<tr>
													<td>2022-03-07	</td>
													<td>0103</td>
													<td>Walk-in Customer</td>
													<td>$ 1500.00</td>
													<td>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/eye.svg" alt="img">
														</a>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/edit.svg" alt="img">
														</a>
														<a class="me-3 confirm-text" href="javascript:void(0);">
															<img src="asset/img/icons/delete.svg" alt="img">
														</a>
													</td>
												</tr>
												<tr>
													<td>2022-03-07	</td>
													<td>0104</td>
													<td>Walk-in Customer</td>
													<td>$ 1500.00</td>
													<td>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/eye.svg" alt="img">
														</a>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/edit.svg" alt="img">
														</a>
														<a class="me-3 confirm-text" href="javascript:void(0);">
															<img src="asset/img/icons/delete.svg" alt="img">
														</a>
													</td>
												</tr>
												<tr>
													<td>2022-03-07	</td>
													<td>0105</td>
													<td>Walk-in Customer</td>
													<td>$ 1500.00</td>
													<td>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/eye.svg" alt="img">
														</a>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/edit.svg" alt="img">
														</a>
														<a class="me-3 confirm-text" href="javascript:void(0);">
															<img src="asset/img/icons/delete.svg" alt="img">
														</a>
													</td>
												</tr>
												<tr>
													<td>2022-03-07	</td>
													<td>0106</td>
													<td>Walk-in Customer</td>
													<td>$ 1500.00</td>
													<td>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/eye.svg" alt="img">
														</a>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/edit.svg" alt="img">
														</a>
														<a class="me-3 confirm-text" href="javascript:void(0);">
															<img src="asset/img/icons/delete.svg" alt="img">
														</a>
													</td>
												</tr>
												<tr>
													<td>2022-03-07	</td>
													<td>0107</td>
													<td>Walk-in Customer</td>
													<td>$ 1500.00</td>
													<td>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/eye.svg" alt="img">
														</a>
														<a class="me-3" href="javascript:void(0);">
															<img src="asset/img/icons/edit.svg" alt="img">
														</a>
														<a class="me-3 confirm-text" href="javascript:void(0);">
															<img src="asset/img/icons/delete.svg" alt="img">
														</a>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
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
		<script src="asset/js/pos.js"></script>
		
    </body>
</html>