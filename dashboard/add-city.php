<?php

	ini_set('display_errors','off');
    include("session.php");
	include("inc/dbconn.php");

	if(isset($_POST["add"]))
	{
        $name = $_POST["name"];
        $arname = $_POST["arname"];

		$sql = "SELECT * FROM city WHERE name='$name'";
		$result = $conn->query($sql);
		if($result->num_rows > 0)
		{
			echo "<script>alert('Invalid Entry')</script>";
		}
		else
		{
            $sql1 = "INSERT INTO city (name,ar_name) VALUES ('$name','$arname')";
            if($conn->query($sql1) === TRUE)
            {
                header("Location: add-city.php?msg=City Added!");
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
	<meta name="description" content="New City | Mato Fresh" />
	
	<!-- OG -->
	<meta property="og:title" content="New City | Mato Fresh" />
	<meta property="og:description" content="New City | Mato Fresh" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>New City | Mato Fresh</title>
	
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
							<h3>New City</h3>
						</div>
						<div class="widget-inner">
							<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
							<form class="edit-profile" method="post" enctype="multipart/form-data">
								<div class="">

									<div class="form-group row">
									
										<div class="col-sm-6">
											<input type="text" name="name" class="form-control" placeholder="City Name - English" onkeyup="getuser(this.value)" required>
											<div style="color: red" id="city"></div>
										</div>

										<div class="col-sm-6">
											<input type="text" name="arname" class="form-control" placeholder="City Name - Arabic" required>
										</div>

									</div>

									<div class="form-group row">

										<div class="col-sm-11"></div>
										<div class="col-sm-1">
											<input type="submit" name="add" class="btn " value="Add" onclick="return validate()"/>
										</div>
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
                            <div class="row">
                                <div class="col-sm-12">
                                    <h3>All City</h3>
                                </div>
                            </div>
                        </div>
						<div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
                                            <th>City Name - English</th>
                                            <th>City Name - Arabic</th>
                                            <th>Stauts</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
									<tbody>

                                        <?php
                                            $sql = "SELECT * FROM city ORDER BY name ASC";
                                            $result = $conn->query($sql);
                                            $count = 1;
                                            while($row = $result->fetch_assoc())
                                            {
                                        ?>
                                            <tr>
                                                <td><center><?php echo $count++ ?></center></td>
                                                <td><center><?php echo $row["name"] ?></center></td>
                                                <td><center><?php echo $row["ar_name"] ?></center></td>
												<td><center><a href="status-city.php?id=<?php echo $row["id"] ?>">
										<?php
												if($row["status"] == 0)
												{
										?>
												<button class="btn" style="background-color:red;color:white !important">Deactivate</button>
										<?php
												}
												else
												{
										?>
												<button class="btn">Activate</button>
										<?php
												}
										?>
												</a></center></td>
                                                <td><center><a href="edit-city.php?id=<?php echo $row["id"] ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></center></td>
                                            </tr>
                                        <?php
                                            }
                                        ?>
									
									</tbody>
                                </table>
                            </div>
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
	function getuser(val)
    {
        $.ajax({
            type: "POST",
            url: "assets/ajax/get-user.php",
            data:'city='+val,
            beforeSend: function()
            {
                $("#city").addClass("loader");
            },
            success: function(data)
            {
                $("#city").html(data);
                $("#city").removeClass("loader");
            }
        });
	}
</script>
</body>
</html>