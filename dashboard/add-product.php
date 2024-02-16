<?php

	ini_set('display_errors','off');
    include("session.php");
	include("inc/dbconn.php");

	if(isset($_POST["add"]))
	{
		$name = $_POST["name"];
		$img = $_POST["img"];
		$key = $_POST["key"];
		$cate = $_POST["cate"];
		$type = $_POST["type"];
		$countweig = count($_POST["amo"]);

		$sql = "SELECT * FROM product WHERE name='$name'";
		$result = $conn->query($sql);
		if($result->num_rows > 0)
		{
			echo "<script>alert('Product Name Already Exists!')</script>";
		}
		else
		{
			$sql1 = "INSERT INTO product (name,image,cate,status,type,keyw) VALUES ('$name','$img','$cate','1','0','$key')";
			if($conn->query($sql1) === TRUE)
			{
				$sql2 = "SELECT * FROM product ORDER BY id DESC LIMIT 1";
				$result2 = $conn->query($sql2);
				$row2 = $result2->fetch_assoc();

				$ids = $row2["id"];

				for($j=0;$j<$countweig;$j++)
				{
					$demo = $_POST["demo"][$j];
					$amo = $_POST["amo"][$j];
					$weig = $_POST["weig"][$j];

					$sql3 = "INSERT INTO price (pid,weight,demo,amo) VALUES ('$ids','$weig','$demo','$amo')";
					if($conn->query($sql3) === TRUE)
					{
						header("Location: add-product.php?msg=Product Added!");
					}
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
	<meta name="description" content="New Product | Mato Fresh" />
	
	<!-- OG -->
	<meta property="og:title" content="New Product | Mato Fresh" />
	<meta property="og:description" content="New Product | Mato Fresh" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>New Product | Mato Fresh</title>
	
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
                                    <h3>New Product</h3>
                                </div>
                                <div class="col-sm-2">
                                    <a href="add-category.php" class="btn 2 float-right">Add Category</a>
                                </div>
                            </div>
						</div>
						<div class="widget-inner">
							<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
							<form class="edit-profile" method="post" enctype="multipart/form-data">
								<div class="">

									<div class="form-group row">
									
										<div class="col-sm-6">
											<input type="text" name="name" class="form-control" placeholder="Product Name" onkeyup="getuser(this.value)" required>
										</div>

									

										<div class="col-sm-6">
											<select name="cate" class="form-control" required onchange="get(this.value)">
												<option value selected disabled>Select Category</option>
												<?php
													$sql1 = "SELECT * FROM category ORDER BY name ASC";
													$result1 = $conn->query($sql1);
													while($row1 = $result1->fetch_assoc())
													{
												?>
														<option value="<?php echo $row1["id"] ?>"><?php echo $row1["name"] ?></option>
												<?php
													}
												?>
											</select>
										</div>


									</div>

									<div class="form-group row">

										<div class="col-sm-6">
											<textarea name="key" style="height: 100px !important" class="form-control" placeholder="Search Keywords (Place commas between keywords)"></textarea>
										</div>
										<div class="col-sm-6">
											<input type="text" name="img" class="form-control" Placeholder="Image" Required>
										</div>

									</div>

									<div class="form-group" id="duplicate">
										<div class="row m-b20">

											<div class="col-sm-4">
												<input type="text" name="weig[]" class="form-control" Placeholder="Variation Weight" Required>
											</div>

											<div class="col-sm-4">
												<input type="number" min="1" name="demo[]" class="form-control" Placeholder="Demo Amount">
											</div>
											<div class="col-sm-3">
												<input type="number" min="1" name="amo[]" class="form-control" Placeholder="Amount" Required>
											</div>
											<div class="col-sm-1">
												<button type="button" name="add" id="add" class="btn btn-success">+</button>
											</div>
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
                                    <h3>All Products</h3>
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
                                            <th>Image</th>
                                            <th>Category</th>
                                            <th>KeyWords</th>
                                            <th>Weight</th>
                                            <th>Amount</th>
                                            <th>Recommend</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
									<tbody>

										<?php
											$sql = "SELECT * FROM product ORDER BY name ASC";
											$result = $conn->query($sql);
											$count = 1;
											while($row = $result->fetch_assoc())
											{
												$pid = $row["id"];
												$cate = $row["cate"];
												$scate = $row["sub_cate"];

												$weig = $demos = $amos = "";

												$sql1 = "SELECT * FROM category WHERE id='$cate'";
												$result1 = $conn->query($sql1);
												$row1 = $result1->fetch_assoc();

												$sql3 = "SELECT * FROM price WHERE pid='$pid'";
												$result3 = $conn->query($sql3);
												while($row3 = $result3->fetch_assoc())
												{
													$weig .= $row3["weight"]."<br>";
													$demos .= $row3["demo"]."<br>";
													$amos .= "₹ ".number_format($row3["amo"])."<br>";
												}
										?>
											<tr>
												<td><center><?php echo $count++ ?></center></td>
												<td><center><?php echo $row["name"] ?></center></td>
												<td><center><img src="<?php echo $row["image"] ?>" style="height: 100px; width: 150px"></center></td>
												<td><center><?php echo $row1["name"] ?></center></td>
												<td><center><?php echo $row["keyw"] ?></center></td>
												<td><center><?php echo $weig ?></center></td>
												<td><center><?php echo $amos ?></center></td>
												<td>
													<center>
														<?php
															if($row["recom"] == 1)
															{
														?>
																<a onClick="return confirm('Sure to Unrecommend this Product!');" href="status-city.php?id=<?php echo $row["id"] ?>"><img src="assets/images/on.png" alt=""></a>
														<?php
															}
															else
															{
														?>
																<a onClick="return confirm('Sure to Recommend this Product!');" href="status-city.php?id=<?php echo $row["id"] ?>"><img src="assets/images/off.png" alt=""></a>
														<?php
															}
														?>
													</center>
												</td>
												<td>
													<center>
														<?php
															if($row["status"] == 1)
															{
														?>
																<a onClick="return confirm('Sure to Inactive this Product!');" href="status.php?id=<?php echo $row["id"] ?>"><img src="assets/images/on.png" alt=""></a>
														<?php
															}
															else
															{
														?>
																<a onClick="return confirm('Sure to Active this Product!');" href="status.php?id=<?php echo $row["id"] ?>"><img src="assets/images/off.png" alt=""></a>
														<?php
															}
														?>
													</center>
												</td>
												<td>
													<center>
														<a href="edit-product.php?id=<?php echo $row["id"] ?>"><img src="assets/images/icons/edit.svg"></a>
														<a onClick="return confirm('Sure to Delete this Product!');" href="delete-product.php?id=<?php echo $row["id"] ?>"><img src="assets/images/icons/delete.svg"></a>
													</center>
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
	var i = 0;
	$('#add').click(function(){
			i++;
           $('#duplicate').append(
			   '<div class="form-group row" id="duplicate'+i+'"><div class="col-sm-4"><input type="text" name="weig[]" class="form-control" Placeholder="Variation Weight" Required></div><div class="col-sm-4"><input type="number" min="1" name="demo[]" class="form-control" Placeholder="Demo Amount"></div><div class="col-sm-3"><input type="number" min="1" name="amo[]" class="form-control" Placeholder="Amount" Required></div><div class="col-sm-1"><button type="button" name="remove" class="btn btn-danger btn_remove" id="'+i+'">X</button></div></div>');
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#duplicate'+button_id+'').remove();  
      });  
</script>
</body>
</html>