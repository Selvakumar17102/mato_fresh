<?php
	ini_set('display_errors','off');
	session_start();
	include("inc/dbconn.php");
	
	if(isset($_POST["login"]))
	{
		$user = $_POST["username"];
		$pass = $_POST["password"];
		$sql = "SELECT * FROM login WHERE BINARY username = '$user'";
		$result = $conn->query($sql);
		if($result->num_rows > 0) 
		{
			$row = $result->fetch_assoc();

			if($row["password"] === $pass)
			{
				$_SESSION["username"] = $user;
				header("Location: dashboard.php");
			}
			else
			{
				header("Location: index.php?msg=Invalid Password!");
			}
		} 
		else 
		{
			header("Location: index.php?msg=Invalid Username!");
		}
	}
	
	if(isset($_SESSION["username"]))
	{
	    header("Location: dashboard.php");
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
		<meta name="description" content="Login Panel | Mato Fresh" />
		
		<!-- OG -->
		<meta property="og:title" content="Login Panel | Mato Fresh" />
		<meta property="og:description" content="Login Panel | Mato Fresh" />
		<meta property="og:image" content="" />
		<meta name="format-detection" content="telephone=no">
		
		<!-- FAVICONS ICON ============================================= -->
		<link rel="icon" href="assets/images/favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
		
		<!-- PAGE TITLE HERE ============================================= -->
		<title>Login Panel | Mato Fresh</title>
		
		<!-- MOBILE SPECIFIC ============================================= -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
		
		<!-- All PLUGINS CSS ============================================= -->
		<link rel="stylesheet" type="text/css" href="assets/css/assets.css">
		
		<!-- TYPOGRAPHY ============================================= -->
		<link rel="stylesheet" type="text/css" href="assets/css/typography.css">
		
		<!-- SHORTCODES ============================================= -->
		<link rel="stylesheet" type="text/css" href="assets/css/shortcodes/shortcodes.css">
		
		<!-- DataTable ============================================= -->
		
		<!-- STYLESHEETS ============================================= -->
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
		<link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">

		<style>
			.account-head:after
			{
				background-color: transparent !important;
				background-image: url("assets/images/bg2.png")!important;
				background-position:center; 
				background-repeat: no-repeat;
				background-size:cover;
			}
			#logintext
			{
				background: var(--unnamed-color-ffffff) 0% 0% no-repeat padding-box;
				background: #FFFFFF 0% 0% no-repeat padding-box;
				border: 1px solid #AFAFAF;
				border-radius: 4px;
				opacity: 1;
			}
		</style>
		
	</head>
	<body id="bg">
		<div class="page-wraper">
			<div class="account-form">
				<div class="account-head">
					<a><img style="height: 200px" src="assets/images/mainlogo.png"></a>
				</div>
				
				<div class="account-form-inner">
					<div class="account-container">
						<div class="heading-bx left">
							
							<h3><b>Login</b></h3>
							<!-- <p style="text-align: center;"><a href="register.php">Click here</a> to Register</p> -->
							<p style="text-align: center;color: red;"><?php echo $_REQUEST['msg']; ?></p>
						</div>	
						<form class="contact-bx" name="login" method="post" action="">
							<div class="row placeani">
								<div class="col-lg-12">
									<div class="form-group">
										<div class="input-group">
											<input name="username" type="text" required="" class="form-control" placeholder="Username" autocomlpete="off">
										</div>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<div class="input-group">
											<input name="password" type="password" class="form-control" required="" placeholder="Password">
										</div>
									</div>
								</div>
								<div class="col-lg-12 m-b30">
									<input style="background-color:#F36A10;color:#FFFFFF !important;font-size: 14px;padding: 10px 40px;width: 100%" type="submit" name="login" value="Login" class="btn button-md" />
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	<!-- External JavaScripts -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/functions.js"></script>
	</body>
</html>
