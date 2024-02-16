<?php

	ini_set('display_errors','off');
    include("session.php");
	include("inc/dbconn.php");

	$i = 0;

	$sql = "SELECT * FROM delivery";
	$result = $conn->query($sql);
	$count = $result->num_rows;

	if(isset($_POST["save"]))
	{
		$count = count($_POST["fc"]);

		$sql = "DELETE FROM delivery";
		if($conn->query($sql) === TRUE)
		{
			for($j=0;$j<$count;$j++)
			{
				$fc = $_POST["fc"][$j];
				$lc = $_POST["lc"][$j];
				$c = $_POST["c"][$j];

				$sql1 = "INSERT INTO delivery (fc,lc,charge) VALUES ('$fc','$lc','$c')";
				if($conn->query($sql1) === TRUE)
				{
					header("Location: package.php");
				}
			}
		}
	}

	if(isset($_POST["add"]))
	{
        $p = $_POST["package"];
        $m = $_POST["min"];
        $d = $_POST["dist"];
        $addcart = $_POST["addcart"];
        $in = $_POST["intime"];
        $out = $_POST["outtime"];

        $sql = "SELECT * FROM charges WHERE id='1'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $sql1 = "UPDATE charges SET addcart='$addcart',distance='$d',min='$m',intime='$in',outtime='$out',package='$p' WHERE id='1'";
            if($conn->query($sql1) === TRUE)
            {
                header("Location: package.php?msg=Charges Updated!");
            }
        }
        else
        {
            $sql1 = "INSERT INTO charges (addcart,package,intime,outtime,min,distance) VALUES ('$addcart','$p','$in','$out','$m','$d')";
            if($conn->query($sql1) === TRUE)
            {
                header("Location: package.php?msg=Charges Added!");
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
	<meta name="description" content="Packaging and Delivery Charge | Mato Fresh" />
	
	<!-- OG -->
	<meta property="og:title" content="Packaging and Delivery Charge | Mato Fresh" />
	<meta property="og:description" content="Packaging and Delivery Charge | Mato Fresh" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Packaging and Delivery Charge | Mato Fresh</title>
	
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
		.form-control
		{
			display: block;
			width: 100%;
			height: 34px;
			padding: 6px 12px;
			font-size: 14px;
			line-height: 1.42857143;
			color: #555;
			background-color: #fff;
			background-image: none;
			border: 1px solid #e1e6eb;
			border-radius: 4px;
			box-shadow: none;
		}
		.
        {
            border-radius: 20px;
            background-color: #36B37E;
            color: #fff;
        }
        .:hover
        {
            background-color: #00875A;
            color: #fff;
		}
		.th
		{
			color: #091E42 !important;
		}
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
				<div class="col-lg-12 ">
					<div class="widget-box">
						<div class="card-header">
							<h3>Delivery Charge</h3>
						</div>
						<div class="widget-inner">
							<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
							<form class="edit-profile" method="post" enctype="multipart/form-data">
								<?php
									if($count == 0)
									{
								?>
									<div class="form-group m-b30" id="duplicate">
										<div class="row m-b20">
											<div class="col-sm-4">
												<input type="number" name="fc[]" min="0" class="form-control" placeholder="Start Price" required>
											</div>
											<div class="col-sm-4">
												<input type="number" name="lc[]" min="1" class="form-control" placeholder="End Price" required>
											</div>
											<div class="col-sm-3">
												<input type="number" name="c[]" min="0" class="form-control" placeholder="Charge" required>
											</div>
											<div class="col-sm-1">
												<button type="button" name="add" id="add" class="btn btn-success">+</button>
											</div>
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
											<div class="col-sm-4">
												<input type="number" name="fc[]" min="0" class="form-control" placeholder="Start Price" value="<?php echo $row["fc"] ?>" required>
											</div>
											<div class="col-sm-4">
												<input type="number" name="lc[]" min="1" class="form-control" placeholder="End Price" value="<?php echo $row["lc"] ?>" required>
											</div>
											<div class="col-sm-3">
												<input type="number" name="c[]" min="0" class="form-control" placeholder="Charge" required value="<?php echo $row["charge"] ?>">
											</div>
											<div class="col-sm-1">
												<button type="button" name="add" id="add" class="btn btn-success">+</button>
											</div>
										</div>
								<?php
											}
											else
											{
								?>
										<div class="row m-b20" id="duplicate<?php echo $i ?>">
											<div class="col-sm-4">
												<input type="number" name="fc[]" min="0" class="form-control" placeholder="Start Price" value="<?php echo $row["fc"] ?>" required>
											</div>
											<div class="col-sm-4">
												<input type="number" name="lc[]" min="1" class="form-control" placeholder="End Price" value="<?php echo $row["lc"] ?>" required>
											</div>
											<div class="col-sm-3">
												<input type="number" name="c[]" min="0" class="form-control" placeholder="Charge" required value="<?php echo $row["charge"] ?>">
											</div>
											<div class="col-sm-1">
												<button type="button" name="remove" class="btn btn-danger btn_remove" id="<?php echo $i ?>">X</button>
											</div>
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
								<div class="form-group row">

									<div class="col-sm-11"></div>
									<div class="col-sm-1">
										<input type="submit" name="save" class="btn " value="Save">
									</div>

								</div>
							</form>
							
						</div>
					</div>
				</div>
			</div>

			<div class="row m-b30">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 ">
					<div class="widget-box">
						<div class="card-header">
							<h3>Packing Charge</h3>
						</div>
                        <?php
                            $sql = "SELECT * FROM charges WHERE id='1'";
                            $result = $conn->query($sql);
							$row = $result->fetch_assoc();
							
                            $sql1 = "SELECT * FROM api_key WHERE id='1'";
                            $result1 = $conn->query($sql1);
                            $row1 = $result1->fetch_assoc();
                        ?>
						<div class="widget-inner">
							<form class="edit-profile" method="post" enctype="multipart/form-data">
								<div class="">

                                    <div class="form-group row">

                                        <div class="col-sm-4">
                                            <label for="" class="col-form-label">Package Charge</label>
                                            <input type="number" name="package" class="form-control" placeholder="Package Charge" required value="<?php echo $row["package"] ?>">
                                        </div>

										<div class="col-sm-4">
                                            <label for="" class="col-form-label">Minimum Order</label>
                                            <input type="number" name="min" class="form-control" placeholder="Minimum Order" required value="<?php echo $row["min"] ?>">
                                        </div>

										<div class="col-sm-4">
                                            <label for="" class="col-form-label">Maximum Distance for Placing Order( KM )</label>
                                            <input type="number" name="dist" class="form-control" placeholder="Maximum Distance" required value="<?php echo $row["distance"] ?>">
                                        </div>

									</div>
									
                                    <div class="form-group row">

										<div class="col-sm-4">
                                            <label for="" class="col-form-label">Add to cart count</label>
                                            <input type="number" min="1" name="addcart" class="form-control" required value="<?php echo $row["addcart"] ?>">
                                        </div>
										<div class="col-sm-4">
                                            <label for="" class="col-form-label">Opening Time</label>
                                            <input type="time" name="intime" class="form-control" required value="<?php echo $row["intime"] ?>">
                                        </div>
										<div class="col-sm-4">
                                            <label for="" class="col-form-label">Closing Time</label>
                                            <input type="time" name="outtime" class="form-control" required value="<?php echo $row["outtime"] ?>">
                                        </div>

                                    </div>
                                    <div class="form-group row">

                                        <div class="col-sm-11"></div>
                                        <div class="col-sm-1">
                                            <input type="submit" name="add" class="btn " value="Save">
                                        </div>

                                    </div>
								</div>

							</form>
							
						</div>
					</div>
				</div>
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
			'<div class="row m-b20" id="duplicate'+i+'"><div class="col-sm-4"><input type="number" name="fc[]" min="0" class="form-control" placeholder="Start Price"></div><div class="col-sm-4"><input type="number" name="lc[]" min="1" class="form-control" placeholder="End Price"></div><div class="col-sm-3"><input type="number" name="c[]" min="0" class="form-control" placeholder="Charge" required></div><div class="col-sm-1"><button type="button" name="remove" class="btn btn-danger btn_remove" id="'+i+'">X</button></div></div>'
		);
	});

	$(document).on('click', '.btn_remove', function(){  
	var button_id = $(this).attr("id");   
		$('#duplicate'+button_id+'').remove();  
	});  
</script>
</body>
</html>