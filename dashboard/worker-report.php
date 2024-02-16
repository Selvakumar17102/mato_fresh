<?php

    ini_set('display_errors','off');
	include("inc/dbconn.php");
    include("session.php");

	$id = $_REQUEST["id"];
	$ids = $_REQUEST["ids"];

	$fdate = $_REQUEST["fdate"];
	$tdate = $_REQUEST["tdate"];

	if($id == "")
	{
		$date = date('Y-m-d');
        $start = date('Y-m-d');
        $monthName = "Today";
	}
	else
	{
        $monthName = date('F', mktime(0, 0, 0, $id, 10))." Month";
		if($id < 10)
		{
			$id = "0".$id;
		}

		$start = date('Y-'.$id.'-01');
		$date = date("Y-m-t", strtotime($start));
	}

	if($fdate != "" && $tdate != "")
	{
        $monthName = date('d-m-Y',strtotime($fdate))." - ".date('d-m-Y',strtotime($tdate));
		$date = $tdate;
		$start = $fdate;
	}

	$sql1 = "SELECT * FROM worker WHERE lid='$ids'";
	$result1 = $conn->query($sql1);
	$row1 = $result1->fetch_assoc();

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
	<meta name="description" content="Delivery Partner Reports | Veggis" />
	
	<!-- OG -->
	<meta property="og:title" content="Delivery Partner Reports | Veggis" />
	<meta property="og:description" content="Delivery Partner Reports | Veggis" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Delivery Partner Reports | Veggis</title>
	
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
    
    <link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
	
	<!-- SHORTCODES ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/shortcodes/shortcodes.css">
	
	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
    <link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">

    <style>
        .hide1
        {
            display: none;
        }
		.dt-button {
	background: #8697BB !important;
	color: #fff !important;
		}
    </style>

    <script>
        function datefun()
		{
			$('[type="date"]').prop('max', function(){
				return new Date().toJSON().split('T')[0];
			});
		}
    </script>
    
</head>
<body onload="datefun()" class="ttr-opened-sidebar ttr-pinned-sidebar">
	
	<!-- header start -->
	<?php include_once("inc/header.php");?>
	<!-- header end -->
	<!-- Left sidebar menu start -->
	<?php include_once("inc/sidebar.php");?>
	

	<!--Main container start -->
	<main class="ttr-wrapper">
		<div class="container">
				
			<div class="row">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
						<div class="wc-title">
                            <div class="row">
								<div class="col-sm-12">
                                    <h4><center><?php echo $monthName ?> Reports</center></h4>
									<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3">
									<label class="col-form-label">Month Wise Search</label>
									<select style="height: 40px" id="date" class="form-control" onchange="boss(this.value)">
										<option value disabled Selected>Select Month</option>
										<option value="1">Jan</option>
										<option value="2">Feb</option>
										<option value="3">Mar</option>
										<option value="4">Apr</option>
										<option value="5">May</option>
										<option value="6">Jun</option>
										<option value="7">Jul</option>
										<option value="8">Aug</option>
										<option value="9">Sep</option>
										<option value="10">Oct</option>
										<option value="11">Nov</option>
										<option value="12">Dec</option>
									</select>
								
								</div>
								<div class="col-sm-9">
								<label class="col-form-label">Custom Search</label>
									<div class="col-sm-12">
										<div class="row">
										
											<div class="col-sm-5">
												<input type="date" id="fdate" class="form-control" value="<?php echo $fdate ?>">
											</div>
											<div class="col-sm-5">
												<input type="date" id="tdate" class="form-control" value="<?php echo $tdate ?>">
											</div>
											<div class="col-sm-2">
												<input type="button" class="btn" value="Submit" onclick="search()">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
                    </div>
                </div>
            </div>

            <div class="row">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
                        <div class="wc-title">
                            <div class="row">
								<div class="col-sm-6">
									<?php
										if($ids == "")
										{
									?>
										<h4>Delivery Partner Report</h4>
									<?php
										}
										else
										{
									?>
										<h4><?php echo $row1["name"] ?> Report</h4>
									<?php
										}
									?>
                                </div>
                            </div>
						</div>
						<div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
											<th>Order Id</th>
											<th>Total Amount</th>
											<th>Mode</th>
                                        </tr>
                                    </thead>
									<tbody>
                                        <?php
                                            if($ids == "")
											{
												$wid = $rhead["id"];
											}
											else
											{
												$wid = $ids;
											}

                                            $sql = "SELECT * FROM order_details WHERE longitude='$wid' AND product_id = '3' AND booking_date BETWEEN '$start' AND '$date'";
                                            $result = $conn->query($sql);
                                            $count = 1;
                                            while($row = $result->fetch_assoc())
                                            {
                                        ?>
                                            <tr>
                                                <td><center><?php echo $count++ ?></center></td>
                                                <td><center><?php echo $row["orderid"] ?></center></td>
                                                <td><center>₹ <?php echo number_format($row["overall_total_amount"]) ?></center></td>
												<td><center><?php echo $row["delivery_type"] ?></center></td>
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
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script>
// Start of jquery datatable
            $('#dataTableExample1').DataTable({
				"dom": 'Bfrtip',
        "buttons": [
            'excelHtml5',
            'pdfHtml5'
        ],
             
                "iDisplayLength": 15
            });
            
</script>
<script>
	function boss(val)
	{
		if(val != "")
		{
			location.replace("https://matofresh.in/dashboard/worker-report.php?ids=<?php echo $ids."&" ?>id="+val);
		}
	}
	function search()
	{
		var fdate = document.getElementById('fdate').value;
		var tdate=document.getElementById('tdate').value;

		if(fdate == "")
		{
			$("#fdate").css("border", "1px solid red");
		}
		else
		{
			if(tdate == "")
			{
				$("#tdate").css("border", "1px solid red");
			}
			else
			{
				location.replace("https://matofresh.in/dashboard/worker-report.php?ids=<?php echo $ids."&" ?>fdate="+fdate+"&tdate="+tdate);
			}
		}
	}
</script>
</body>
</html>