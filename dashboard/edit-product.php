<?php

	ini_set('display_errors','off');
    include("session.php");
	include("inc/dbconn.php");

	$pid = $_REQUEST["id"];
	
    $sql2 = "SELECT * FROM product WHERE id='$pid'";
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();

	$id = $pid;
	$cate = $row2["cate"];

	if(isset($_POST["add"]))
	{
		$name = $_POST["name"];
		$img = $_POST["img"];
		$key = $_POST["key"];
		$cate = $_POST["cate"];
		$countweig = count($_POST["amo"]);

		
		    $sql1 = "UPDATE product SET name='$name',cate='$cate',keyw='$key',image='$img' WHERE id='$pid'";
			if($conn->query($sql1) === TRUE)
			{
				$sql2 = "DELETE FROM price WHERE pid='$pid'";
				if($conn->query($sql2) === TRUE)
				{
					for($j=0;$j<$countweig;$j++)
					{
						$demo = $_POST["demo"][$j];
						$amo = $_POST["amo"][$j];
						$weig = $_POST["weig"][$j];

						if($demo == "")
						{
							$demo = 0;
						}

						$sql3 = "INSERT INTO price (pid,weight,demo,amo) VALUES ('$pid','$weig','$demo','$amo')";
						if($conn->query($sql3) === TRUE)
						{
							header("Location: add-product.php?msg=Product Updated!");
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
	<meta name="description" content="Edit Product | Mato Fresh" />
	
	<!-- OG -->
	<meta property="og:title" content="Edit Product | Mato Fresh" />
	<meta property="og:description" content="Edit Product | Mato Fresh" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Edit Product | Mato Fresh</title>
	
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
                                    <h3>Edit Product</h3>
                                </div>
                            </div>
						</div>
						<div class="widget-inner">
							<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
							<form class="edit-profile" method="post" enctype="multipart/form-data">
								<div class="">

									<div class="form-group row">
									
										<div class="col-sm-6">
											<input type="text" name="name" class="form-control" placeholder="Product Name - English" onkeyup="getuser(this.value)" required value="<?php echo $row2["name"] ?>">
										</div>

										<div class="col-sm-6">
											<select name="cate" class="form-control" required onchange="get(this.value)">
												<?php
													$sql1 = "SELECT * FROM category ORDER BY name ASC";
													$result1 = $conn->query($sql1);
													while($row1 = $result1->fetch_assoc())
													{
                                                        $s = "";
                                                        if($row2["cate"] == $row1["id"])
                                                        {
                                                            $s = "Selected";
                                                        }
												?>
														<option <?php echo $s ?> value="<?php echo $row1["id"] ?>"><?php echo $row1["name"] ?></option>
												<?php
													}
												?>
											</select>
										</div>

										

									</div>

									<div class="form-group row">

										<div class="col-sm-6">
											<textarea name="key" style="height: 100px !important" class="form-control" placeholder="Search Keywords (Place commas between keywords)"><?php echo $row2["keyw"] ?></textarea>
										</div>
										
										<div class="col-sm-6">
											<input type="text" name="img" class="form-control" required value="<?php echo $row2["image"] ?>">
										</div>

									</div>

									<div class="form-group" id="duplicate">
										
										<?php

											$sql4 = "SELECT * FROM price WHERE pid='$pid'";
											$result4 = $conn->query($sql4);
											$j = 0;
											if($result4->num_rows > 0)
											{
												while($row4 = $result4->fetch_assoc())
												{
													if($j == 0)
													{
											?>
												<div class="row m-b20">
													<div class="col-sm-4">
														<input type="text" name="weig[]" class="form-control" Placeholder="Variation Weight" value="<?php echo $row4["weight"] ?>">
													</div>
													<div class="col-sm-4">
														<input type="number" min="1" name="demo[]" class="form-control" Placeholder="Demo Amount" value="<?php echo $row4["demo"] ?>">
													</div>
													<div class="col-sm-3">
														<input type="number" min="1" name="amo[]" class="form-control" Placeholder="Amount" Required value="<?php echo $row4["amo"] ?>">
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
												<div class="row m-b20" id="duplicate<?php echo $j ?>">
													<div class="col-sm-4">
														<input type="text" name="weig[]" class="form-control" Placeholder="Variation Weight"  value="<?php echo $row4["weight"] ?>">
													</div>
													<div class="col-sm-4">
														<input type="number" min="1" name="demo[]" class="form-control" Placeholder="Demo Amount" value="<?php echo $row4["demo"] ?>">
													</div>
													<div class="col-sm-3">
														<input type="number" min="1" name="amo[]" class="form-control" Placeholder="Amount" Required value="<?php echo $row4["amo"] ?>">
													</div>
													<div class="col-sm-1">
														<button type="button" name="remove" class="btn btn-danger btn_remove" id="<?php echo $j ?>">X</button>
													</div>
												</div>
											<?php
													}
													$j++;
												}
											}
											else
											{
										?>
											<div class="row m-b20">
												<div class="col-sm-6">
													<input type="text" name="weig[]" class="form-control" Placeholder="Variation Weight">
												</div>
												<div class="col-sm-4">
													<input type="number" min="1" name="demo[]" class="form-control" Placeholder="Demo Amount">
												</div>
												<div class="col-sm-5">
													<input type="number" min="1" name="amo[]" class="form-control" Placeholder="Amount" Required>
												</div>
												<div class="col-sm-1">
													<button type="button" name="add" id="add" class="btn btn-success">+</button>
												</div>
											</div>
										<?php
											}
										?>
										
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
	var i = <?php echo $j ?>;
	$('#add').click(function(){
			i++;
           $('#duplicate').append(
			   '<div class="form-group row" id="duplicate'+i+'"><div class="col-sm-4"><input type="text" name="weig[]" class="form-control" Placeholder="Variation Weight"></div><div class="col-sm-4"><input type="number" min="1" name="demo[]" class="form-control" Placeholder="Demo Amount"></div><div class="col-sm-3"><input type="number" min="1" name="amo[]" class="form-control" Placeholder="Amount" Required></div><div class="col-sm-1"><button type="button" name="remove" class="btn btn-danger btn_remove" id="'+i+'">X</button></div></div>');
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#duplicate'+button_id+'').remove();  
      });  
</script>
<script>
	$(".custom-file-input").on("change", function() {
	var fileName = $(this).val().split("\\").pop();
	$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	});
</script>
</body>
</html>