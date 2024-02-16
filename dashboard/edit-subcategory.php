<?php

	ini_set('display_errors','off');
    include("session.php");
    include("inc/dbconn.php");
    
    $id = $_REQUEST["id"];
    $user = $_SESSION["username"];

    $sq = "SELECT * FROM login WHERE username='$user'";
    $resul = $conn->query($sq);
    $ro = $resul->fetch_assoc();

    $hotel = $ro["id"];

    $sql = "SELECT * FROM subcategory WHERE id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

	if(isset($_POST["add"]))
	{
        $name = $_POST["sub"];
        $cid = $_POST["cate"];
        $img = $_POST["img"];

		$sql = "SELECT * FROM subcategory WHERE name='$name' AND cid='$cid' AND id!='$id'";
		$result = $conn->query($sql);
		if($result->num_rows > 0)
		{
			echo "<script>alert('Sub Category Already Exists!')</script>";
		}
		else
		{
            $sql1 = "UPDATE subcategory SET name='$name',image='$img',cid='$cid' WHERE id='$id'";
            if($conn->query($sql1) === TRUE)
            {
				header("Location: add-subcategory.php?msg=Sub Category Updated!");
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
	<meta name="description" content="Edit Sub Category | Mato Fresh" />
	
	<!-- OG -->
	<meta property="og:title" content="Edit Sub Category | Mato Fresh" />
	<meta property="og:description" content="Edit Sub Category | Mato Fresh" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Edit Sub Category | Mato Fresh</title>
	
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
                            <h3>Edit Sub Category</h3>
                        </div>
                        <div class="widget-inner">
                            <p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
                            <form method="post" class="edit-profile" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <select name="cate" class="form-control" required>
                                            <option value selected disabled>Select Category</option>
                                            <?php
                                                $sql1 = "SELECT * FROM category ORDER BY name ASC";
                                                $result1 = $conn->query($sql1);
                                                while($row1 = $result1->fetch_assoc())
                                                {
                                                    $s = "";
                                                    if($row["cid"] == $row1["id"])
                                                    {
                                                        $s = "SELECTED";
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
                                        <input type="text" name="sub" class="form-control" required value="<?php echo $row["name"] ?>">
                                    </div>

									<div class="col-sm-6">
                                        <input type="text" name="img" class="form-control" required value="<?php echo $row["image"] ?>">
                                    </div>

                                </div>

                                <div class="form-group row">
									<div class="col-sm-11"></div>
									<div class="col-sm-1">
										<input type="submit" name="add" class="btn " value="Save">
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
	$(".custom-file-input").on("change", function() {
	var fileName = $(this).val().split("\\").pop();
	$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	});
</script>
</body>
</html>