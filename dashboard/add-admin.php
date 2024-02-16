<?php

	ini_set('display_errors','off');
    include("session.php");
	include("inc/dbconn.php");

	if(isset($_POST["add"]))
	{
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $pass = $_POST["pass"];
        $re = $_POST["repass"];
        $city = $_POST["city"];

		$sql = "SELECT * FROM login WHERE username='$name' OR phone='$phone'";
		$result = $conn->query($sql);
		if($result->num_rows > 0)
		{
			echo "<script>alert('Invalid Entry')</script>";
		}
		else
		{
			if($pass == $re)
			{
				$sql1 = "INSERT INTO login (username,password,phone,city,control) VALUES ('$name','$pass','$phone','$city','1')";
				if($conn->query($sql1) === TRUE)
				{
					header("Location: add-admin.php?msg=Admin added!");
				}
			}
			else
			{
				echo "<script>alert('Password Missmatch')</script>";
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
	<meta name="description" content="New Admin | Mato Fresh" />
	
	<!-- OG -->
	<meta property="og:title" content="New Admin | Mato Fresh" />
	<meta property="og:description" content="New Admin | Mato Fresh" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>New Admin | Mato Fresh</title>
	
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
							<h3>New Admin</h3>
						</div>
						<div class="widget-inner">
							<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
							<form class="edit-profile" method="post" enctype="multipart/form-data">
								<div class="">

									<div class="form-group row">
									
										<div class="col-sm-6">
											<input type="text" name="name" class="form-control" placeholder="User Name" onkeyup="getuser(this.value)" required>
											<div style="color: red" id="user"></div>
										</div>

                                        <div class="col-sm-6">
											<input type="text" name="phone" class="form-control" placeholder="Phone Number" onkeypress="return IsAlphaNumeric(event);" ondrop="return false;" onpaste="return false;" onkeyup="getphone(this.value)" required>
											<div style="color: red" id="phone"></div>
										</div>

									</div>

                                    <div class="form-group row">
									
										<div class="col-sm-6">
											<input type="password" name="pass" class="form-control" placeholder="Password" required>
										</div>

                                        <div class="col-sm-6">
											<input type="password" name="repass" class="form-control" placeholder="Retype Password" required>
										</div>

									</div>

									<div class="form-group row">
									
										<div class="col-sm-12">
											<select name="city" class="form-control" id="city1">
												<option value disabled selected>Select City</option>
												<?php
													$sql = "SELECT * FROM city ORDER BY name ASC";
													$result = $conn->query($sql);
													while($row = $result->fetch_assoc())
													{
														$id = $row["id"];

														$sql1 = "SELECT * FROM login WHERE city='$id'";
														$result1 = $conn->query($sql1);
														if($result1->num_rows == 0)
														{
												?>
														<option value="<?php echo $row["id"] ?>"><?php echo $row["name"] ?></option>
												<?php
														}
													}
												?>
											</select>
											<label id="city2" style="color: red;padding: 10px" class="hide">* Select City</label>
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
                                    <h3>All Admin</h3>
                                </div>
                            </div>
                        </div>
						<div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
                                            <th>Username</th>
                                            <th>Phone</th>
                                            <th>City</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
									<tbody>

										<?php
											$sql = "SELECT * FROM login WHERE id!='1' AND control='1' ORDER BY username ASC";
											$result = $conn->query($sql);
											$count = 1;
											while($row = $result->fetch_assoc())
											{
												$city = $row["city"];

												$sql1 = "SELECT * FROM city WHERE id='$city'";
												$result1 = $conn->query($sql1);
												$row1 = $result1->fetch_assoc();
										?>
											<tr>
												<td><center><?php echo $count++ ?></center></td>
												<td><center><?php echo $row["username"] ?></center></td>
												<td><center><?php echo $row["phone"] ?></center></td>
												<td><center><?php echo $row1["name"] ?></center></td>
												<td><center><a href="status-login.php?m=3&id=<?php echo $row["id"] ?>">
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
												<td><center><a href="edit-admin.php?id=<?php echo $row["id"] ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></center></td>
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
            data:'uname='+val,
            beforeSend: function()
            {
                $("#user").addClass("loader");
            },
            success: function(data)
            {
                $("#user").html(data);
                $("#user").removeClass("loader");
            }
        });
	}
	function getphone(val)
	{
		$.ajax({
            type: "POST",
            url: "assets/ajax/get-user.php",
            data:'phone='+val,
            beforeSend: function()
            {
                $("#phone").addClass("loader");
            },
            success: function(data)
            {
                $("#phone").html(data);
                $("#phone").removeClass("loader");
            }
        });
	}
	function validate()
	{
		var city1 = document.getElementById("city1").value;
		var city2 = document.getElementById("city2");

		if(city1 == "")
		{
			city2.style.display = "block";
			return false;
		}
		else
		{
			city2.style.display = "none";
			return true;
		}
	}
</script>
</body>
</html>