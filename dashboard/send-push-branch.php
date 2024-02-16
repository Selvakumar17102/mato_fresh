<?php
	ini_set('display_errors','off');
    include("session.php");
	include("inc/dbconn.php");
	
    $user = $_SESSION["username"];

    $shead = "SELECT * FROM login WHERE username='$user'";
    $resulthead = $conn->query($shead);
	$rhead = $resulthead->fetch_assoc();
	
	$bid = $rhead["id"];
	
	$sno = $_REQUEST["id"];
	
	if($sno != "")
	{
	    $sql = "SELECT * FROM push_notification WHERE sno='$sno' ";
	    $result = $conn->query($sql);
	    $row = $result->fetch_assoc();
	    
	    $title = $row["title"];
        $image = $row["image"];
        $message = $row["message"];
        $branch = $row["branch"];
        
        header("Location: send-push-branch.php?msg=Notification has been Sent Successfully!");
        
        $sql = "SELECT * FROM order_details WHERE latitude = '$branch'";
        $result = $conn->query($sql);
    
        while($row = $result->fetch_assoc())
        {
            $fcmtoken = $row["fcm_token"];
            $url = "https://fcm.googleapis.com/fcm/send";
        	$token = $fcmtoken;
            $sql5 = "SELECT * FROM api_key WHERE id='1'";
			$result5 = $conn->query($sql5);
			$row5 = $result5->fetch_assoc();

			$serverKey = $row5["fcm_token"];
        	$title = $title;
            $body = $message;
            $linkUrl = $image;
        	$img = $image;
            $notification = array('title' =>$title ,'linkUrl' =>$linkUrl , 'body' => $body, 'image' => $img, 'sound' => 'default', 'badge' => '1');
        	$arrayToSend = array('to' => $token, 'data' => $notification,'priority'=>'high');
            $json = json_encode($arrayToSend);
        	
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key='. $serverKey;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
            $response = curl_exec($ch);
            if ($response === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
            }
            curl_close($ch);
        }
	}

	if(isset($_POST["add"]))
	{
        $title = $_POST["title"];
        $image = $_POST["image"];
        $message = $_POST["message"];
        header("Location: send-push-branch.php?msg=Notification has been Sent Successfully!");
        
    $sql = "SELECT * FROM order_details WHERE latitude = '$bid'";
    $result = $conn->query($sql);
    
    
    
    while($row = $result->fetch_assoc())
        {
      $fcmtoken = $row["fcm_token"];
    $url = "https://fcm.googleapis.com/fcm/send";
	$token = $fcmtoken;
    $sql5 = "SELECT * FROM api_key WHERE id='1'";
	$result5 = $conn->query($sql5);
	$row5 = $result5->fetch_assoc();

	$serverKey = $row5["fcm_token"];
	$title = $title;
    $body = $message;
    $linkUrl = $image;
	$img = $image;
    $notification = array('title' =>$title ,'linkUrl' =>$linkUrl , 'body' => $body, 'image' => $img, 'sound' => 'default', 'badge' => '1');
	$arrayToSend = array('to' => $token, 'data' => $notification,'priority'=>'high');
    $json = json_encode($arrayToSend);
	
    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Authorization: key='. $serverKey;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
    $response = curl_exec($ch);
    if ($response === FALSE) {
    die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
        }
    
    $sql1 = "INSERT INTO push_notification (title,image,message,branch) VALUES ('$title','$image','$message','$bid')";
    $result1 = $conn->query($sql1);
    
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
	<meta name="description" content="Send Push Notification | Mato Fresh" />
	
	<!-- OG -->
	<meta property="og:title" content="Send Push Notification | Mato Fresh" />
	<meta property="og:description" content="Send Push Notification | Mato Fresh" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Send Push Notification | Mato Fresh</title>
	
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
							<h3>Send Push Notification</h3>
						</div>
						<div class="widget-inner">
							<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
							<form class="edit-profile" method="post" enctype="multipart/form-data">
								<div class="">

									<div class="form-group row">
										<div class="col-sm-6">
											<input type="text" name="title" class="form-control" placeholder="Title" onkeyup="getuser(this.value)" required>
											<div style="color: red" id="user"></div>
										</div>

                                        <div class="col-sm-6">
											<input type="text" name="image" class="form-control" placeholder="Image Link" required>
											<div style="color: red" id="phone"></div>
										</div>

									</div>

                                    <div class="form-group row">
									
										<div class="col-sm-12">
											<textarea name="message" class="form-control" placeholder="Message" required style="min-height: 150px;"></textarea>
										</div>

                                     

									</div>

								

									<div class="form-group row">

										<div class="col-sm-11"></div>
										<div class="col-sm-1">
											<input type="submit" name="add" class="btn" value="Send" onclick="return validate()"/>
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
                                    <h3>All Push Notification</h3>
                                </div>
                            </div>
                        </div>
						<div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
                                            <th>Title</th>
                                            <th>Image</th>
                                            <th>Message</th>
                                            <th>Resend</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
									<tbody>

										<?php
											$sql = "SELECT * FROM push_notification WHERE branch = '$bid' ORDER BY sno DESC";
											$result = $conn->query($sql);
											$count = 1;
											while($row = $result->fetch_assoc())
											{
											?>
											<tr>
												<td><center><?php echo $count++ ?></center></td>
												<td><center><?php echo $row["title"] ?></center></td>
												<td><center><img style="height: 100px" src="<?php echo $row["image"] ?>"></center></td>
												<td><center><?php echo $row["message"] ?></center></td>
												<td><center><a onClick="return confirm('Sure to Send this Notification!');" href="send-push-branch.php?id=<?php echo $row["sno"] ?>"><i class="fa fa-refresh" aria-hidden="true" style="background: green;color: #fff;padding: 11px;"></i></a></center></td>
												<td><center><a onClick="return confirm('Sure to Delete this Notification!');" href="delete-push.php?id=<?php echo $row["sno"] ?>&branch=1"><img src="assets/images/icons/delete.svg" alt=""></a></center></td>
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


</body>
</html>