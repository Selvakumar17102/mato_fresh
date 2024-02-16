<?php

	ini_set('display_errors','off');
    include("session.php");
    include("inc/dbconn.php");
    
    $username = $_SESSION["username"];

	if(isset($_POST["add"]))
	{
        $control = $_POST["control"];
        $name = $_POST["name"];
        $user = $_POST["username"];
        $phone = $_POST["phone"];
        $pass = $_POST["pass"];
        $repass = $_POST["repass"];
        $email = $_POST["email"];
        $addr = $_POST["addr"];
        $branch = $_POST["branch"];	

        $sql = "SELECT * FROM login WHERE phone='$phone' AND control='3'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            echo "<script>alert('Phone number already exists ')</script>";
        }
        else
        {
            if($repass == $pass)
            {
                $sql1 = "INSERT INTO login (username,password,phone,control) VALUES ('$user','$pass','$phone','3')";
                if($conn->query($sql1) === TRUE)
                {
					$sql1 = "SELECT * FROM login ORDER BY id DESC LIMIT 1";
					$result1 = $conn->query($sql1);
					$row1 = $result1->fetch_assoc();

					$idmain = $row1["id"];
					$resumename1=$_FILES["image"]["name"];

					if(!$resumename1 == "")
					{
						$resumetype = Pathinfo($resumename1,PATHINFO_EXTENSION);
						$resumename = "Images/Worker".$idmain.".".$resumetype;
						echo $targetresume = $resumename;
						$allowTypes = array('jpg','JPG','png','PNG','jpeg','JPEG','gif','GIF','pdf','PDF');
						if(in_array($resumetype, $allowTypes))
						{
							if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetresume))
							{
								$sql2 = "SELECT * FROM login WHERE username='$user'";
								$result2 = $conn->query($sql2);
								$row2 = $result2->fetch_assoc();

								$lid = $row2["id"];

								$sql3 = "INSERT INTO worker (lid,name,email,addr,ar_name,image,zone) VALUES ('$lid','$name','$email','$addr','$arname','$resumename','$branch')";
								if($conn->query($sql3) === TRUE)
								{
									header("Location: add-worker.php?msg=Delivery Partner Added!");
								}
							}
						}
					}
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
	<meta name="description" content="New Delivery Partner | Mato Fresh" />
	
	<!-- OG -->
	<meta property="og:title" content="New Delivery Partner | Mato Fresh" />
	<meta property="og:description" content="New Delivery Partner | Mato Fresh" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>New Delivery Partner | Mato Fresh</title>
	
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

			<?php /* ?> <div class="row m-b30">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 ">
					<div class="widget-box">
						<div class="card-header">
							<h3>New Delivery Partner</h3>
						</div>
						<div class="widget-inner">
							<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
							<form class="edit-profile" method="post" enctype="multipart/form-data">
								<div class="">

                                    <div class="form-group row">
                                        
                                        <div class="col-sm-6">
                                            <input type="text" name="name" class="form-control" placeholder="Delivery Partner Name - English" required>
                                        </div>

                                        <div class="col-sm-6">
                                            <input type="text" name="arname" class="form-control" placeholder="Delivery Partner Name - Arabic" required>
                                        </div>

                                    </div>

									<div class="form-group row">
									
										<div class="col-sm-6">
											<input type="text" name="username" class="form-control" placeholder="User Name" onkeyup="getuser(this.value)" required>
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

										<div class="col-sm-6">
                                            <input type="email" name="email" class="form-control" placeholder="Email Id" required>
                                        </div>
                                        <input type="hidden" name="control" value="<?php echo $rhead["control"] ?>">
                                        <input type="hidden" name="citymain" value="<?php echo $rhead["city"] ?>">

										<div class="col-sm-6">
											<div class="custom-file">
												<input type="file" name="image" class="custom-file-input" id="customFile" required>
												<label class="custom-file-label" for="customFile">Choose file</label>
											</div>
										</div>

                                    </div>

									<div class="form-group row">

										<div class="col-sm-12">
                                            <textarea name="addr" style="height: 100px !important" class="form-control" placeholder="Address" required></textarea>
                                        </div>

                                    </div>

									<?php
										if($rhead["control"] == 0)
										{
									?>

									<div class="form-group row">

										<div class="col-sm-3"></div>
										<div class="col-sm-6">
                                            <select name="branch" class="form-control" required>
												<option value selected disabled>Select Branch</option>
												<?php
													$sql4 = "SELECT * FROM hotel ORDER BY name ASC";
													$result4 = $conn->query($sql4);
													while($row4 = $result4->fetch_assoc())
													{
												?>
														<option value="<?php echo $row4["lid"] ?>"><?php echo $row4["name"] ?></option>
												<?php
													}
												?>
											</select>
                                        </div>

                                    </div>

									<?php
										}
										else
										{
									?>
											<input type="hidden" name="branch" value="<?php echo $rhead["id"] ?>">
									<?php
										}
									?>

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
			</div> <?php */ ?>

            <div class="row m-b30">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 ">
					<div class="widget-box">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h3>All Delivery Partners</h3>
                                </div>
                            </div>
                        </div>
						<div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
                                            <th>Name</th>
											<?php
												if($rhead["control"] == "0")
												{
											?>
												<th>Zone</th>
											<?php
												}
											?>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Date Of Birth</th>
                                            <th>Vehicle</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
									<tbody>

										<?php
											$hid = $rhead["id"];
											if($rhead["control"] == 0)
											{
												$sql = "SELECT * FROM login WHERE control='3'";
											}
											else
											{
												$sql = "SELECT * FROM login WHERE control='3'";
											}
                                            $result = $conn->query($sql);
                                            $count = 1;
                                            while($row = $result->fetch_assoc())
                                            {
                                                $lid = $row["id"];                                                
                                                $c = $row["city"];

                                                $sql1 = "SELECT * FROM worker WHERE lid='$lid'";
                                                $result1 = $conn->query($sql1);
												$row1 = $result1->fetch_assoc();
												$branch = $row1["zone"];

                                                $sql2 = "SELECT * FROM zone WHERE id='$branch'";
                                                $result2 = $conn->query($sql2);
                                                $row2 = $result2->fetch_assoc();
                                        ?>
                                            <tr>
                                                <td><center><?php echo $count++ ?></center></td>
                                                <td><center><?php echo $row1["name"] ?></center></td>
												<?php
													if($rhead["control"] == "0")
													{
												?>
													<td><center><?php echo $row2["name"] ?></center></td>
												<?php
													}
												?>
                                                <td><center><?php echo $row["phone"] ?></center></td>
                                                <td><center><?php echo $row1["email"] ?></center></td>
                                                <td><center><?php 
												if($row1["dob"] == ""){
													echo '-';
												} else {
												echo date('d/m/Y',strtotime($row1["dob"]));
												} ?></center></td>
                                                <td><center><?php echo $row1["v_name"]." - ".$row1["v_num"] ?></center></td>
                                                <td><center><?php echo $row1["addr"] ?></center></td>
                                                <td><center><a href="status-login.php?m=2&id=<?php echo $row["id"] ?>">
										<?php
												if($row["status"] == 0)
												{
										?>
												<button onClick="return confirm('Sure to Deactivate!');" class="btn" style="background-color:red;color:white !important">Deactivate</button>
										<?php
												}
												else
												{
										?>
												<button onClick="return confirm('Sure to Activate!');" class="btn">Activate</button>
										<?php
												}
										?>
												</a></center></td>
                                                <td>
													<table style="width:100px">
														<tr>
															<td style="border: none !important">
																<a href="edit-worker.php?id=<?php echo $row["id"] ?>"><img src="assets/images/icons/edit.svg" alt=""></a>
															</td>
															<td style="border: none !important">
																<a onClick="return confirm('Sure to Delete this Branch!');" href="delete-worker.php?id=<?php echo $row["id"] ?>"><img src="assets/images/icons/delete.svg" alt=""></a>
															</td>
														</tr>
													</table>
												</td>
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
<script>
	$(".custom-file-input").on("change", function() {
	var fileName = $(this).val().split("\\").pop();
	$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	});
</script>
</body>
</html>