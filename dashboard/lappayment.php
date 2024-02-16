<!DOCTYPE html>
<html>
<head>
<title>Checkout Page</title>
</head>
<body>
    <?php
    $amount = $_REQUEST['Amount'];
    $description = $_REQUEST['Description'];
    $reference = $_REQUEST['Reference'];
    $mobile = $_REQUEST['Mobile'];
    $name = $_REQUEST['Name'];
    $email = $_REQUEST['Email'];
    ?>
<div id="mybutton"></div>
<!--<script type="text/javascript" src="//sandbox.noqoodypay.com/api/api/webpayment/getwebjsapi/Q1b27j3L"></script>-->
<script type="text/javascript" src="//www.noqoodypay.com/api/api/NoqoodyPayWeb/GetWebJsApi/3Ds38t9F5"></script>
<script type="text/javascript">
var d = new Date();
 var n = d.getTime();
 var dx=Math.floor((Math.random() * 1000) + 1);
 var TransactionAmount= "<?php echo $amount;?>"; //Your Billing Amount
 var MobileAmount = "<?php echo $amount;?>"; //Your Billing Amount
 var Description= "<?php echo $amount;?>"; //Your Product detail
 var TransactionReference= "<?php echo $reference;?>";
 var CustomerMobile= "<?php echo $mobile;?>";
 var CustomerEmail= "<?php echo $email;?>";
 var CustomerName= "<?php echo $name;?>";
 var Gender= "NA";
 var QID= "NA";
 qpay.SetPayButton('mybutton');// Pass the element ID of the Button to place your widget on your checkout page.
 qpay.Init(TransactionAmount,Description,TransactionReference,MobileAmount,CustomerMobile,CustomerEmail,CustomerName,Gender,QID);
</script>
</body>
</html>