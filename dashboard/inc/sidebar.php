<?php

	include("inc/dbconn.php");
	$user=$_SESSION["username"];

?>
<div class="ttr-sidebar">
		<div class="ttr-sidebar-wrapper content-scroll">
			<!-- side menu logo start -->
			<!-- <div class="ttr-sidebar-logo">
				<a href="#"><img alt="" src="assets/images/logo.png" width="122" height="27"></a>
				 <div class="ttr-sidebar-pin-button" title="Pin/Unpin Menu">
					<i class="material-icons ttr-fixed-icon">gps_fixed</i>
					<i class="material-icons ttr-not-fixed-icon">gps_not_fixed</i>
				</div>
				<div class="ttr-sidebar-toggle-button">
					<i class="ti-arrow-left"></i>
				</div>
			</div> -->
			<!-- side menu logo end -->
			<!-- sidebar menu start -->
			<nav style="margin-bottom:20px;margin-top:25px" class="ttr-sidebar-navi">
				<ul>

					<li>
						<a href="dashboard.php" class="ttr-material-button">
							<span class="ttr-icon"><img class="imgs" src="assets/images/icons/dashboard.svg"></span>
		                	<span class="ttr-label">Dashboard</span>
		                </a>
					</li>

					<?php
						if($rhead["control"] == 0)
						{
					?>
					<li>
						<a href="#" class="ttr-material-button">
							<span class="ttr-icon"><img class="imgs" src="assets/images/icons/order.svg"></span>
		                	<span class="ttr-label">Controls</span>
		                	<span class="ttr-arrow-icon"><i class="fa fa-angle-down"></i></span>
		                </a>
		                <ul>
							<li>
		                		<a href="add-zone.php" class="ttr-material-button"><span class="ttr-label">Zone</span></a>
		                	</li>
							<li>
		                		<a href="add-hotel.php" class="ttr-material-button"><span class="ttr-label">Store</span></a>
		                	</li>
		                	<li>
		                		<a href="add-worker.php" class="ttr-material-button"><span class="ttr-label">Delivery Partner</span></a>
		                	</li>
							<li>
		                		<a href="package.php" class="ttr-material-button"><span class="ttr-label">Delivery Charge</span></a>
		                	</li>
							<li>
		                		<a href="add-banner.php" class="ttr-material-button"><span class="ttr-label">Banner</span></a>
		                	</li>
							<li>
		                		<a href="product-offer.php" class="ttr-material-button"><span class="ttr-label">Product Offers</span></a>
		                	</li>
							<li>
		                		<a href="add-offer.php" class="ttr-material-button"><span class="ttr-label">Offers</span></a>
		                	</li>
							<li>
		                		<a href="time.php" class="ttr-material-button"><span class="ttr-label">Time Slot</span></a>
		                	</li>
							<li>
		                		<a href="payment.php" class="ttr-material-button"><span class="ttr-label">Payment Mode</span></a>
		                	</li>
		                </ul>
		            </li>
					<li>
						<a href="#" class="ttr-material-button">
							<span class="ttr-icon"><img class="imgs" src="assets/images/icons/product.png"></span>
		                	<span class="ttr-label">Products</span>
		                	<span class="ttr-arrow-icon"><i class="fa fa-angle-down"></i></span>
		                </a>
		                <ul>
		                	<li>
		                		<a href="add-category.php" class="ttr-material-button"><span class="ttr-label">Add Category</span></a>
		                	</li>
							<li>
		                		<a href="add-product.php" class="ttr-material-button"><span class="ttr-label">Add Products</span></a>
		                	</li>
		                </ul>
		            </li>
					<li>
						<a href="#" class="ttr-material-button">
							<span class="ttr-icon"><img class="imgs" src="assets/images/icons/pack.png"></span>
		                	<span class="ttr-label">Inventory</span>
							<span class="ttr-arrow-icon"><i class="fa fa-angle-down"></i></span>
		                </a>
						<ul>
							<li>
		                		<a href="goodoninventory.php" class="ttr-material-button"><span class="ttr-label">Goodon Inventory</span></a>
		                	</li>
							<li>
		                		<a href="inventory.php" class="ttr-material-button"><span class="ttr-label">Create Inventory</span></a>
		                	</li>
							<li>
		                		<a href="listinventory.php" class="ttr-material-button"><span class="ttr-label">List Inventory</span></a>
		                	</li>
		                </ul>
					</li>
					<!-- <li>
						<a href="#" class="ttr-material-button">
							<span class="ttr-icon"><img class="imgs" src="assets/images/icons/order.svg"></span>
		                	<span class="ttr-label">Subscription</span>
		                	<span class="ttr-arrow-icon"><i class="fa fa-angle-down"></i></span>
		                </a>
		                <ul>
							<li>
		                		<a href="createScheme.php" class="ttr-material-button"><span class="ttr-label">Create Scheme</span></a>
		                	</li>
							<li>
		                		<a href="listScheme.php" class="ttr-material-button"><span class="ttr-label">List Scheme</span></a>
		                	</li>
		                </ul>
		            </li> -->
					<li>
						<a href="#" class="ttr-material-button">
							<span class="ttr-icon"><img class="imgs" src="assets/images/icons/order.svg"></span>
		                	<span class="ttr-label">Orders</span>
		                	<span class="ttr-arrow-icon"><i class="fa fa-angle-down"></i></span>
		                </a>
		                <ul>
							<li>
		                		<a href="order.php" class="ttr-material-button"><span class="ttr-label">New Orders</span></a>
		                	</li>
		                	<li>
		                		<a href="orders.php" class="ttr-material-button"><span class="ttr-label">All Orders</span></a>
		                	</li>
							<li>
		                		<a href="cancelled-orders.php" class="ttr-material-button"><span class="ttr-label">Cancelled Orders</span></a>
		                	</li>
							<li>
		                		<a href="dispatched-orders.php" class="ttr-material-button"><span class="ttr-label">Dispatched Orders</span></a>
		                	</li>
							<li>
		                		<a href="closed-orders.php" class="ttr-material-button"><span class="ttr-label">Completed Orders</span></a>
		                	</li>
		                </ul>
		            </li>
					<li>
						<a href="all-users.php" class="ttr-material-button">
							<span class="ttr-icon"><img class="imgs" src="assets/images/icons/pack.png"></span>
		                	<span class="ttr-label">Users</span>
		                </a>
					</li>
					<li>
						<a href="send-push.php" class="ttr-material-button">
							<span class="ttr-icon"><img class="imgs" src="assets/images/icons/pack.png"></span>
		                	<span class="ttr-label">Push Notification</span>
		                </a>
					</li>
					<li>
						<a href="#" class="ttr-material-button">
							<span class="ttr-icon"><img class="imgs" src="assets/images/icons/reports.svg"></span>
		                	<span class="ttr-label">Reports</span>
		                	<span class="ttr-arrow-icon"><i class="fa fa-angle-down"></i></span>
		                </a>
		                <ul>
		                	<li>
		                		<a href="report-hotel.php" class="ttr-material-button"><span class="ttr-label">Store</span></a>
		                	</li>
		                	<li>
		                		<a href="report-worker.php" class="ttr-material-button"><span class="ttr-label">Delivery Partners</span></a>
		                	</li>
		                </ul>
		            </li>
					<?php
						}
						if($rhead["control"] == 2)
						{
					?>
					<li>
						<a href="singlestoreInventory.php" class="ttr-material-button">
							<span class="ttr-icon"><img class="imgs" src="assets/images/icons/reports.svg"></span>
		                	<span class="ttr-label">Store Inventory</span>
		                </a>
					</li>
					<li>
						<a href="add-worker.php" class="ttr-material-button">
							<span class="ttr-icon"><img class="imgs" src="assets/images/icons/delivery.svg"></span>
		                	<span class="ttr-label">Delivery Partner</span>
		                </a>
					</li>
					<li>
						<a href="#" class="ttr-material-button">
							<span class="ttr-icon"><img class="imgs" src="assets/images/icons/order.svg"></span>
		                	<span class="ttr-label">Orders</span>
		                	<span class="ttr-arrow-icon"><i class="fa fa-angle-down"></i></span>
		                </a>
		                <ul>
							<li>
		                		<a href="order.php" class="ttr-material-button"><span class="ttr-label">New Orders</span></a>
		                	</li>
		                	<li>
		                		<a href="orders.php" class="ttr-material-button"><span class="ttr-label">All Orders</span></a>
		                	</li>
							<li>
		                		<a href="cancelled-orders.php" class="ttr-material-button"><span class="ttr-label">Cancelled Orders</span></a>
		                	</li>
							<li>
		                		<a href="dispatched-orders.php" class="ttr-material-button"><span class="ttr-label">Dispatched Orders</span></a>
		                	</li>
							<li>
		                		<a href="closed-orders.php" class="ttr-material-button"><span class="ttr-label">Completed Orders</span></a>
		                	</li>
		                </ul>
		            </li>
					<li>
						<a href="hotel-report.php" class="ttr-material-button">
							<span class="ttr-icon"><img class="imgs" src="assets/images/icons/reports.svg"></span>
		                	<span class="ttr-label">Reports</span>
		                </a>
					</li>
					<?php
						}
					?>
					
					<li class="ttr-seperate"></li>

					<li>
						<a href="logout.php" class="ttr-material-button">
							<span class="ttr-icon"><img class="imgs" src="assets/images/icons/exit_to_app-24px.png"></span>
							<span class="ttr-label">Logout</span>
						</a>
					</li>
				</ul>
			</nav>
			
		</div>
			
	</div>