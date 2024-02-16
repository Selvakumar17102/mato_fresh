<?php
$status = $_REQUEST['success'];
$message = $_REQUEST['message'];
$InvoiceNo = $_REQUEST['InvoiceNo'];
$reference = $_REQUEST['reference'];
$status = $_REQUEST['success'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Payment Status</title>
<style>
.container {
    width: 100%;
    margin: 0 auto;
    text-align: center;
}
</style>
</head>
<body>
<div class="container">
<?php 
if($status != "False"){ ?>
<center><img src="http://lapcoffee.com/dashboard/assets/images/icons/success.png" style="height: 70px;"/> </center>
<h1 style="margin: 0;color: #41AD49;">Payment Successfull !</h1>
<h3>Thank you! Your payment has been received.</h3>
<p><b>Order ID:</b> <?php echo $reference; ?> | <b>Transcation ID:</b> <?php echo $InvoiceNo; ?></p>
<?php } else { ?>
<center><img src="http://lapcoffee.com/dashboard/assets/images/icons/fail.png" style="height: 70px;"/> </center>
<h1 style="margin: 0;color: #E44061;">Payment Failed !</h1>
<h3><?php echo $message; ?></h3>
<p><b>Order ID:</b> <?php echo $reference; ?> | <b>Transcation ID:</b> <?php echo $InvoiceNo; ?></p>
<?php } ?>
</div>
</body>
</html>