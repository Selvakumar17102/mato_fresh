<?php

	ini_set('display_errors','off');
    include("session.php");
    include("inc/dbconn.php");
    
    $username = $_SESSION["username"];
    $cid = $_REQUEST["id"];
	
	if(isset($_POST["submit"]))
	{
		$count = count($_POST["ids"]);

		$results = array_unique($_POST["arrange"]);

		if(count($results) == count($_POST["arrange"]))
		{
			for($i=0;$i<$count;$i++)
			{
				$id = $_POST["ids"][$i];
				$arrange = $_POST["arrange"][$i];

				$sql = "UPDATE subcategory SET arrange='$arrange' WHERE id='$id'";
				if($conn->query($sql) === TRUE)
				{
					header("Location: add-subcategory.php?msg=Arrangement updated!");		
				}
			}
		}
		else
		{
			header("Location: arrange-subcategory.php?id=$cid&msg=Duplicate values detected!");
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
	<meta name="description" content="Arrange Category | Mato Fresh" />
	
	<!-- OG -->
	<meta property="og:title" content="Arrange Category | Mato Fresh" />
	<meta property="og:description" content="Arrange Category | Mato Fresh" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Arrange Category | Mato Fresh</title>
	
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
		.btt
        {
            border-radius: 20px;
            background-color: #36B37E;
            color: #fff;
        }
        .btt:hover
        {
            background-color: #00875A;
            color: #fff;
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

            <div class="row">
                <div class="col-sm-12">
                    <div class="widget-box">
                        <div class="card-header">
							<h3>Arrange Category</h3>
						</div>
                        <div class="widget-inner">
                            <p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
                            <form method="post">
                                <div class="row">
                                    <div class="col-sm-6"><center>Category Name</center></div>
                                    <div class="col-sm-6"><center>Order</center></div>
                                </div>
                            <?php
                                $sql = "SELECT * FROM subcategory WHERE cid='$cid' ORDER BY arrange,name ASC";
								$result = $conn->query($sql);
								while($row = $result->fetch_assoc())
								{
									$id = $row["id"];
                            ?>
                                <div class="row m-t10">
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" value="<?php echo $row["name"] ?>">
                                        <input type="hidden" name="ids[]" value="<?php echo $id ?>">
                                    </div>
                                    <div class="col-sm-6"><input type="number" name="arrange[]" min="1" class="form-control" value="<?php echo $row["arrange"] ?>"></div>
                                </div>
                            <?php
								}
							?>
								<div class="form-group row m-t10">
									<div class="col-sm-11"></div>
									<div class="col-sm-1">
										<input type="submit" name="submit" class="btn btt" value="Save">
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

</body>
</html>