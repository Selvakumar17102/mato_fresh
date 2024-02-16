<?php

	ini_set('display_errors','off');
    include("session.php");
	include("inc/dbconn.php");

    $user = $_SESSION["username"];
    
    $sql = "SELECT * FROM contacts WHERE id='1'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

	if(isset($_POST["add"]))
	{
		$con = $_POST["con"];
		$abo = $_POST["abo"];
        $pri = $_POST["pri"];
        
        $sql = "SELECT * FROM contacts";
        $result = $conn->query($sql);

        if($result->num_rows > 0)
        {
            $sql1 = "UPDATE contacts SET about='$abo',contact='$con',privacy='$pri' WHERE id='1'";
        }
        else
        {
            $sql1 = "INSERT INTO contacts (about,contact,privacy) VALUES ('$abo','$con','$pri')";
        }
        
        if($conn->query($sql1) === TRUE)
        {
            header("Location: contact.php?msg=Updated!");
        }
    }
    if(isset($_POST["clear"]))
    {
        $con = "";
		$pri = "";
		$abo = "";

        $sql1 = "UPDATE contacts SET about='$abo',contact='$con',privacy='$pri' WHERE id='1'";
        if($conn->query($sql1) === TRUE)
        {
            header("Location: contact.php?msg=Cleared!");
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
	<meta name="description" content="Contact | Mato Fresh" />
	
	<!-- OG -->
	<meta property="og:title" content="Contact | Mato Fresh" />
	<meta property="og:description" content="Contact | Mato Fresh" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Contact | Mato Fresh</title>
	
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
        .2
        {
            border-radius: 20px;
            background-color: #FFF;
            color: #000 !important;
            border: 1px solid #000;
        }
        .2:hover
        {
            background-color: #FFF;
            color: #F00 !important;
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
                            <div class="row">
                                <div class="col-sm-10">
                                    <h3>Contact</h3>
                                </div>
                            </div>
						</div>
						<div class="widget-inner">
							<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
							<form class="edit-profile" method="post" enctype="multipart/form-data">
								<div class="">

									<div class="form-group row">
									
										<div class="col-sm-2">
                                            <label class="col-form-label">Contact Us</label>
                                        </div>
                                        <div class="col-sm-10">
											<textarea style="height: 200px !important" name="con" id="content1" class="form-control"><?php echo $row["contact"] ?></textarea>
										</div>

									</div>

									<div class="form-group row">
									
										<div class="col-sm-2">
                                            <label class="col-form-label">About Us</label>
                                        </div>
                                        <div class="col-sm-10">
											<textarea style="height: 200px !important" name="abo" id="content2" class="form-control"><?php echo $row["about"] ?></textarea>
										</div>

									</div>

									<div class="form-group row">
									
										<div class="col-sm-2">
                                            <label class="col-form-label">Privacy Policy</label>
                                        </div>
                                        <div class="col-sm-10">
											<textarea style="height: 200px !important" name="pri" id="content3" class="form-control"><?php echo $row["privacy"] ?></textarea>
										</div>

									</div>

									<div class="form-group row">

										<div class="col-sm-11"></div>
										<div class="col-sm-1">
											<input type="submit" name="add" class="btn " value="Update">
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
<script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script>
<script type="text/javascript">
    bkLib.onDomLoaded(function() {
            new nicEditor({fullPanel : true,maxHeight : 300}).panelInstance('content1');
            new nicEditor({fullPanel : true,maxHeight : 300}).panelInstance('content2');
            new nicEditor({fullPanel : true,maxHeight : 300}).panelInstance('content3');
    });
</script>
</body>
</html>