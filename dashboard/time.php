<?php

	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	
	$i = 0;

	$sql = "SELECT * FROM timeslot";
	$result = $conn->query($sql);
	$count = $result->num_rows;

	if(isset($_POST["save"]))
	{
		$count = count($_POST["time"]);

		$sql = "DELETE FROM timeslot";
		if($conn->query($sql) === TRUE)
		{
			for($j=0;$j<$count;$j++)
			{
				$time = $_POST["time"][$j];
				$time2 = $_POST["time2"][$j];

				$sql1 = "INSERT INTO timeslot (time,time2) VALUES ('$time','$time2')";
				if($conn->query($sql1) === TRUE)
				{
					header("Location: time.php?msg=TimeSlot Updated");
				}
			}
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
	<meta name="description" content="Time Slot | Mato Fresh" />
	
	<!-- OG -->
	<meta property="og:title" content="Time Slot | Mato Fresh" />
	<meta property="og:description" content="Time Slot | Mato Fresh" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Time Slot | Mato Fresh</title>
	
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
						<div class="card-header">
							<h3>Time Slot</h3>
						</div>
						<div class="widget-inner">
							<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
							<form method="post">
								<div class="row">
									<div class="col-sm-1"></div>
									<div class="col-sm-4">
										<label for="">Intime</label>
									</div>
									<div class="col-sm-4">
										<label for="">Outtime</label>
									</div>
									<div class="col-sm-2"></div>
									<div class="col-sm-1"></div>
								</div>
								<?php
									if($count == 0)
									{
								?>
									<div class="form-group m-b30" id="duplicate">
										<div class="row m-b20">
											<div class="col-sm-1"></div>
											<div class="col-sm-4">
												<input type="time" name="time[]" class="form-control">
											</div>
											<div class="col-sm-4">
												<input type="time" name="time2[]" class="form-control">
											</div>
											<div class="col-sm-2">
												<button type="button" name="add" id="add" class="btn btn-success">+</button>
											</div>
											<div class="col-sm-1"></div>
										</div>
									</div>
								<?php
									}
									else
									{
								?>
									<div class="form-group m-b30" id="duplicate">
								<?php
										while($row = $result->fetch_assoc())
										{
											if($i == 0)
											{
								?>
										<div class="row m-b20">
											<div class="col-sm-1"></div>
											<div class="col-sm-4">
												<input type="time" name="time[]" class="form-control" placeholder="Time Slot" value="<?php echo $row["time"] ?>">
											</div>
											<div class="col-sm-4">
												<input type="time" name="time2[]" class="form-control" placeholder="Time Slot" value="<?php echo $row["time2"] ?>">
											</div>
											<div class="col-sm-2">
												<button type="button" name="add" id="add" class="btn btn-success">+</button>
											</div>
											<div class="col-sm-1"></div>
										</div>
								<?php
											}
											else
											{
								?>
										<div class="row m-b20" id="duplicate<?php echo $i ?>">
											<div class="col-sm-1"></div>
											<div class="col-sm-4">
												<input type="time" name="time[]" class="form-control" placeholder="Time Slot" value="<?php echo $row["time"] ?>">
											</div>
											<div class="col-sm-4">
												<input type="time" name="time2[]" class="form-control" placeholder="Time Slot" value="<?php echo $row["time2"] ?>">
											</div>
											<div class="col-sm-2">
												<button type="button" name="remove" class="btn btn-danger btn_remove" id="<?php echo $i ?>">X</button>
											</div>
											<div class="col-sm-1"></div>
										</div>
								<?php
											}
											$i++;
										}
								?>
									</div>
								<?php
									}
								?>
								<div class="row">
									<div class="col-sm-11"></div>
									<div class="col-sm-1">
										<input type="submit" value="Save" name="save" class="btn">
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
<script src="assets/js/admin.js"></script>
<script>
	var i = <?php echo $i ?>;

	$('#add').click(function()
	{
		i++;
		$('#duplicate').append(
			'<div class="row m-b20" id="duplicate'+i+'"><div class="col-sm-1"></div><div class="col-sm-4"><input type="time" name="time[]" class="form-control"></div><div class="col-sm-4"><input type="time" name="time2[]" class="form-control"></div><div class="col-sm-2"><button type="button" name="remove" class="btn btn-danger btn_remove" id="'+i+'">X</button></div><div class="col-sm-1"></div></div>'
		);
	});

	$(document).on('click', '.btn_remove', function(){  
	var button_id = $(this).attr("id");   
		$('#duplicate'+button_id+'').remove();  
	});  
</script>
</body>
</html>