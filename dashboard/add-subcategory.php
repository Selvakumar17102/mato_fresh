<?php

	ini_set('display_errors','off');
    include("session.php");
    include("inc/dbconn.php");
    
	if(isset($_POST["add"]))
	{
        $name = $_POST["name"];
        $cid = $_POST["cid"];
        $img = $_POST["img"];

		$sql = "SELECT * FROM subcategory WHERE name='$name' AND cid='$cid'";
		$result = $conn->query($sql);
		if($result->num_rows > 0)
		{
			echo "<script>alert('Sub Category Already Exists!')</script>";
		}
		else
		{
			$sql2 = "SELECT * FROM subcategory WHERE cid='$cid' ORDER BY arrange ASC LIMIT 1";
			$result2 = $conn->query($sql2);
			$row2 = $result2->fetch_assoc();

			$arrrange = $row2["arrange"] + 1;
			$sql1 = "INSERT INTO subcategory (name,cid,image,arrange) VALUES ('$name','$cid','$img','$arrrange')";
			if($conn->query($sql1) === TRUE)
			{
				header("Location: add-subcategory.php?msg=Sub Category Added!");
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
	<meta name="description" content="New Sub Category | Mato Fresh" />
	
	<!-- OG -->
	<meta property="og:title" content="New Sub Category | Mato Fresh" />
	<meta property="og:description" content="New Sub Category | Mato Fresh" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>New Sub Category | Mato Fresh</title>
	
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

                <div class="col-sm-12">
                    <div class="widget-box">
                        <div class="card-header">
                            <h3>Select Category</h3>
                        </div>
                        <div class="widget-inner">
                            <p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
                            <form method="post" class="edit-profile">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <select name="cate" class="form-control" required>
                                            <option value selected disabled>Select Category</option>
                                            <?php
                                                $sql = "SELECT * FROM category ORDER BY name ASC";
                                                $result = $conn->query($sql);
                                                while($row = $result->fetch_assoc())
                                                {
                                            ?>
                                                    <option value="<?php echo $row["id"] ?>"><?php echo $row["name"] ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
									<div class="col-sm-11"></div>
									<div class="col-sm-1">
										<input type="submit" name="select" class="btn " value="Select">
									</div>
								</div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <?php
                if(isset($_POST["select"]))
                {
                    $cid = $_POST["cate"];

                    $sql = "SELECT * FROM category WHERE id='$cid'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
            ?>

			<div class="row m-b30">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 ">
					<div class="widget-box">
						<div class="card-header">
                            <div class="row">
                                <div class="col-sm-10">
                                    <h3>New Sub Category - <?php echo $row["name"] ?></h3>
                                </div>
								<div class="col-sm-2">
									<a href="arrange-subcategory.php?id=<?php echo $cid ?>" class="btn 2 float-right">Arrange Sub Category</a>
								</div>
                            </div>
						</div>
						<div class="widget-inner">
							<form class="edit-profile" method="post" enctype="multipart/form-data">
								<div class="">

									<div class="form-group row">
									
										<div class="col-sm-6">
											<input type="text" name="name" class="form-control" placeholder="Sub Category Name" required>
                                            <input type="hidden" name="cid" value="<?php echo $cid ?>">
										</div>

										<div class="col-sm-6">
											<input type="text" name="img" class="form-control" placeholder="Image" required>
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
                                    <h3>All Sub Categories - <?php echo $row["name"] ?></h3>
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
                                            <th>Action</th>
                                        </tr>
                                    </thead>
									<tbody>
									
                                        <?php
                                            $sql = "SELECT * FROM subcategory WHERE cid='$cid' ORDER BY arrange ASC";
                                            $result = $conn->query($sql);
                                            $count = 1;
                                            while($row = $result->fetch_assoc())
                                            {
                                        ?>
                                            <tr>
                                                <td><center><?php echo $count++ ?></center></td>
                                                <td><center><?php echo $row["name"] ?></center></td>
                                                <td><center><img src="<?php echo $row["image"] ?>" style="width: 150px; height: 100px"></center></td>
                                                <td><center>
                                                    <a href="edit-subcategory.php?id=<?php echo $row["id"] ?>"><img src="assets/images/icons/edit.svg"></a>
                                                    <a onClick="return confirm('Sure to Delete this Sub-Category!');" href="delete-subcategory.php?id=<?php echo $row["id"] ?>"><img src="assets/images/icons/delete.svg"></a>
                                                </center></td>
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

            <?php
                }
            ?>

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
	$(".custom-file-input").on("change", function() {
	var fileName = $(this).val().split("\\").pop();
	$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	});
</script>
</body>
</html>