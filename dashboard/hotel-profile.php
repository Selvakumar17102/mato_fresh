<?php

	ini_set('display_errors','off');
    include("session.php");
	include("inc/dbconn.php");
	
	$id = $_REQUEST["id"];

	if($id == "")
	{
		$username = $_SESSION["username"];

		$sql = "SELECT * FROM login WHERE username='$username'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();

		$hotelid = $row["id"];
	}
	else
	{
		$hotelid = $id;

		$sql = "SELECT * FROM login WHERE id='$hotelid'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
	}

    $sql1 = "SELECT * FROM hotel WHERE lid='$hotelid'";
    $result1 = $conn->query($sql1);
    $row1 = $result1->fetch_assoc();

	if(isset($_POST["add"]))
	{
        $name = $_POST["name"];
        $cname = $_POST["cname"];
        $phone = $_POST["phone"];
        $pass = $_POST["pass"];
        $repass = $_POST["repass"];
        $email = $_POST["email"];
        $addr = $_POST["addr"];
        $city = $_POST["city"];
        $lati = $_POST["lati"];
        $longi = $_POST["longi"];
        $zone = $_POST["zone"];
		$in_time = $_POST["in_time"];
        $out_time = $_POST["out_time"];
        
		if($repass == $pass)
		{
			$sql = "UPDATE login SET phone='$phone',password='$pass' WHERE id='$hotelid'";
			if($conn->query($sql) === TRUE)
			{
				$sql1 = "UPDATE hotel SET lati='$lati',longi='$longi',name='$name',cname='$cname',email='$email',addr='$addr',zone='$zone',intime='$in_time',outtime='$out_time' WHERE lid='$hotelid'";
				if($conn->query($sql1) === TRUE)
				{
					if($id == "")
					{
						header("Location: hotel-profile.php?msg=Profile Updated!");
					}
					else
					{
						header("Location: add-hotel.php?msg=Profile Updated!");
					}
				}
				else{
					header("Location: hotel-profile.php?msg=Failed!");
				}
			}
		}
		else
		{
			echo "<script>alert('Password Missmatch')</script>";
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
	<meta name="description" content="New Branch | Mato Fresh" />
	
	<!-- OG -->
	<meta property="og:title" content="New Branch | Mato Fresh" />
	<meta property="og:description" content="New Branch | Mato Fresh" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>New Branch | Mato Fresh</title>
	
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
            color: #fff !important;
        }
        .:hover
        {
            background-color: #00875A;
            color: #fff !important;
		}
		.th
		{
			color: #091E42 !important;
		}
		.hide
		{
			display: none;
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
							<h3>Edit Profile</h3>
						</div>
						<div class="widget-inner">
							<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
							<form class="edit-profile" method="post" enctype="multipart/form-data">
								<div class="">

                                    <div class="form-group row">
                                        
                                        <div class="col-sm-6">
                                            <input type="text" name="name" class="form-control" placeholder="Branch Name - English" required value="<?php echo $row1["name"] ?>">
                                        </div>

										<div class="col-sm-6">
											<select name="zone" class="form-control" required>
											<option value="" selected value disabled>Select Zone</option>
												<?php
													$sql2 = "SELECT * FROM zone ORDER BY name ASC";
													$result2 = $conn->query($sql2);
													while($row2 = $result2->fetch_assoc())
													{
                                                        $s = "";
                                                        if($row1["zone"] == $row2["id"])
                                                        {
                                                            $s = "Selected";
                                                        }
												?>
														<option <?php echo $s ?> value="<?php echo $row2["id"] ?>"><?php echo $row2["name"] ?></option>
												<?php
													}
												?>
											</select>
										</div>

                                    </div>

                                    <div class="form-group row">
									
										<div class="col-sm-6">
                                            <input type="text" name="cname" class="form-control" placeholder="Owner Name" required value="<?php echo $row1["cname"] ?>">
                                        </div>

										<div class="col-sm-6">
                                            <input type="email" name="email" class="form-control" placeholder="Email Id" required value="<?php echo $row1["email"] ?>">
                                        </div>

									</div>

									<div class="form-group row">
									
										<div class="col-sm-6">
											<input type="text" name="username" class="form-control" placeholder="User Name" onkeyup="getuser(this.value)" value="<?php echo $row["username"] ?>" readonly>
										</div>

                                        <div class="col-sm-6">
											<input type="text" name="phone" class="form-control" placeholder="Phone Number" onkeypress="return IsAlphaNumeric(event);" ondrop="return false;" onpaste="return false;" required value="<?php echo $row["phone"] ?>">
										</div>

									</div>

                                    <div class="form-group row">
									
										<div class="col-sm-6">
											<input type="password" name="pass" class="form-control" placeholder="Password" required value="<?php echo $row["password"] ?>">
										</div>

                                        <div class="col-sm-6">
											<input type="password" name="repass" class="form-control" placeholder="Retype Password" required value="<?php echo $row["password"] ?>">
										</div>

									</div>


									<div class="form-group row">
									
										<div class="col-sm-6">
                                            <input type="text" name="lati" class="form-control" placeholder="Latitude" required value="<?php echo $row1["lati"] ?>">
                                        </div>

                                        <div class="col-sm-6">
											<input type="text" name="longi" class="form-control" placeholder="Longitude" required value="<?php echo $row1["longi"] ?>">
										</div>

									</div>

									<div class="form-group row">

										<div class="col-sm-6">
                                            <input type="time" name="in_time" class="form-control" value="<?php echo $row1['intime'];?>" required>
                                        </div>

										<div class="col-sm-6">
											<input type="time" name="out_time" class="form-control" value="<?php echo $row1['outtime'];?>" required>
										</div>

									</div>

                                    <div class="form-group row">

                                        <div class="col-sm-12">
                                            <textarea name="addr" style="height: 100px !important" class="form-control" placeholder="Address" required><?php echo $row1["addr"] ?></textarea>
                                        </div>

                                    </div>

									<div class="form-group row">

										<div class="col-sm-11"></div>
										<div class="col-sm-1">
											<input style="color: #fff !important;" type="submit" name="add" class="btn" value="Save">
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
<script src="assets/vendors/datatables/dataTables.bootstrap4.min.js"></script>
<script src="assets/vendors/datatables/dataTables.min.js"></script>
<script src="assets/js/admin.js"></script>
<script>
// Start of jquery datatable
            $('#dataTableExample1').DataTable({
                "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "iDisplayLength": 10
            });
</script>
<script>
    function IsAlphaNumeric(e) 
	{
		var specialKeys = new Array();
		specialKeys.push(8);  //Backspace
		specialKeys.push(9);  //Tab
		specialKeys.push(36); //Home
		specialKeys.push(35); //End
		specialKeys.push(37); //Left
		specialKeys.push(39); //Right
		specialKeys.push(46); //Delete

		var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
		var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode == 32 || keyCode == 43) || (specialKeys.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));
		return ret;
    }
</script>
<script>
	$(".custom-file-input").on("change", function() {
	var fileName = $(this).val().split("\\").pop();
	$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	});
</script>
</body>
</html>