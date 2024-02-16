<?php

	ini_set('display_errors','off');
    include("session.php");
    include("inc/dbconn.php");
    
    $sql1 = "SELECT * FROM banner ORDER BY id DESC LIMIT 1";
	$result1 = $conn->query($sql1);
	$row1 = $result1->fetch_assoc();

	$idmain = $row1["id"] + 1;

	if(isset($_POST["add"]))
	{
        $img = $_POST["img"];
        $cate = $_POST["cate"];
        $loca = $_POST["loca"];

        $sql1 = "INSERT INTO banner (image,cate,posit) VALUES ('$img','$cate','$loca')";
        if($conn->query($sql1) === TRUE)
        {
            header("Location: add-banner.php?msg=Banner Added!");
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
	<meta name="description" content="New Banner | Mato Fresh" />
	
	<!-- OG -->
	<meta property="og:title" content="New Banner | Mato Fresh" />
	<meta property="og:description" content="New Banner | Mato Fresh" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>New Banner | Mato Fresh</title>
	
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
        <?php  $hotelid = $rhead["id"]; ?>
	<!--Main container start -->
	<main class="ttr-wrapper">
		<div class="container-fluid">

			<div class="row m-b30">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 ">
					<div class="widget-box">
						<div class="card-header">
							<h3>New Banner</h3>
						</div>
						<div class="widget-inner">
							<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
							<form class="edit-profile" method="post" enctype="multipart/form-data">
								<div class="">
                                    <?php
                                        if($rhead["control"] == 0)
                                        {
                                    ?>

                                    <div class="form-group row">

                                        <div class="col-sm-12">
                                            <input type="text" name="img" class="form-control" placeholder="Image">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <div class="col-sm-6">
                                            <select name="cate" class="form-control" required>
                                                <option value disabled selected>Select Category</option>
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
                                        <div class="col-sm-6">
                                            <select name="loca" class="form-control">
                                                <option value disabled selected>Select Postiton</option>
                                                <option value="1">Top</option>
                                                <option value="2">Middle</option>
                                                <option value="3">Bottom</option>
                                            </select>
                                        </div>
                                    </div>

                                    <?php
                                        }
                                        else
                                        {
                                    ?>

                                        <div class="form-group row">

                                            <div class="col-sm-6">
                                                <div class="custom-file">
                                                    <input type="file" name="image" class="custom-file-input" id="customFile" required>
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-6">
                                                <select name="cate" class="form-control">
                                                    <option value selected disabled>Select Category</option>
                                                    <?php
                                                        $sql2 = "SELECT * FROM category WHERE hotel='$hotelid'";
                                                        $result2 = $conn->query($sql2);
                                                        while($row2 = $result2->fetch_assoc())
                                                        {
                                                    ?>
                                                        <option value="<?php echo $row2["id"] ?>"><?php echo $row2["name"] ?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                                <input type="hidden" name="hotel" value="<?php echo $rhead["id"] ?>">
                                            </div>

                                        </div>
                                    <?php
                                        }
                                    ?>
                                    <div class="form-group row">

                                        <div class="col-sm-11"></div>
                                        <div class="col-sm-1">
                                            <input type="submit" name="add" class="btn" value="Add" onclick="return validate()"/>
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
                                    <h3>All Banner</h3>
                                </div>
                            </div>
                        </div>
						<div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
                                            <th>Banner</th>
                                            <th>Category</th>
                                            <th>Position</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
									<tbody>

                                        <?php
                                            $sql = "SELECT * FROM banner";
                                            $result = $conn->query($sql);
                                            $count = 1;
                                            while($row = $result->fetch_assoc())
                                            {
                                                $hid = $row["cate"];
                                                $pos = "";

                                                if($row["posit"] == 1)
                                                {
                                                    $pos = "Top";
                                                }
                                                if($row["posit"] == 2)
                                                {
                                                    $pos = "Middle";
                                                }
                                                if($row["posit"] == 3)
                                                {
                                                    $pos = "Bottom";
                                                }

                                                $sql2 = "SELECT * FROM category WHERE id='$hid'";
                                                $result2 = $conn->query($sql2);
                                                $row2 = $result2->fetch_assoc();
                                        ?>
                                            <tr>
                                                <td><center><?php echo $count++ ?></center></td>
                                                <td><center><img src="<?php echo $row["image"] ?>" style="width: 200px"></center></td>
                                                <td><center><?php echo $row2["name"] ?></center></td>
                                                <td><center><?php echo $pos ?></center></td>
                                                <td><center><a onClick="return confirm('Sure to Delete this Banner!');" href="delete-banner.php?id=<?php echo $row["id"] ?>"><img src="assets/images/icons/delete.svg" alt=""></a></center></td>
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
	function get(val)
    {
        $.ajax({
            type: "POST",
            url: "assets/ajax/get-user.php",
            data:'hotel='+val,
            beforeSend: function()
            {
                $("#cate").addClass("loader");
            },
            success: function(data)
            {
                $("#cate").html(data);
                $("#cate").removeClass("loader");
            }
        });
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