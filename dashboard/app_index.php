<?php
	session_start();
	if(!empty($_REQUEST['username']))
	{
		$u = $_REQUEST['username'];
		
		$_SESSION['username'] = $u;
		header("Location: dashboard.php");
	}
?>