<?php
namespace Phppot;

use Phppot\CountryState;

include("../../inc/dbconn.php");

if (!empty($_POST["uname"])) 
{
    $name = $_POST["uname"];

	$sql = "SELECT * FROM login WHERE username='$name'";
	$result = $conn->query($sql);
	if($result->num_rows > 0)
	{
?>
		<label id="ulabel">* Username Exists</label>
<?php
	}
}
if (!empty($_POST["phone"])) 
{
    $phone = $_POST["phone"];

	$sql = "SELECT * FROM login WHERE phone='$phone'";
	$result = $conn->query($sql);
	if($result->num_rows > 0)
	{
?>
		<label id="plabel">* Phone Number Exists</label>
<?php
	}
}
if (!empty($_POST["city"])) 
{
    $city = $_POST["city"];

	$sql = "SELECT * FROM city WHERE name='$city'";
	$result = $conn->query($sql);
	if($result->num_rows > 0)
	{
?>
		<label id="plabel">* City Exists</label>
<?php
	}
}
if(!empty($_POST["citymain"]))
{
	$city = $_POST["citymain"];

	$sql = "SELECT * FROM login WHERE city='$city' AND control='2'";
	$result = $conn->query($sql);
	?>
		<option value selected disabled>Select Branch</option>
	<?php
	while($row = $result->fetch_assoc())
	{
		$hid = $row["id"];

		$sql1 = "SELECT * FROM hotel WHERE lid='$hid'";
		$result1 = $conn->query($sql1);
		$row1 = $result1->fetch_assoc();
	?>
		<option value="<?php echo $hid ?>"><?php echo $row1["name"] ?></option>
	<?php
	}
}
if (!empty($_POST["cate"])) 
{
    $cate = $_POST["cate"];

	$sql = "SELECT * FROM subcategory WHERE cid='$cate' ORDER BY name ASC";
	$result = $conn->query($sql);
	if($result->num_rows > 0)
	{
	?>
		<option value selected disabled>Select Sub Category</option>
	<?php
	}
	else
	{
	?>
		<option value selected disabled>No Sub Category Available</option>
	<?php
	}
	while($row = $result->fetch_assoc())
	{
?>
		<option value="<?php echo $row["id"] ?>"><?php echo $row["name"] ?></option>
<?php
	}
}
if (!empty($_POST["hotel"])) 
{
    $hotel = $_POST["hotel"];

	$sql = "SELECT * FROM category WHERE hotel='$hotel' ORDER BY name ASC";
	$result = $conn->query($sql);
	if($result->num_rows > 0)
	{
	?>
		<option value selected disabled>Select Category</option>
	<?php
	}
	else
	{
	?>
		<option value selected disabled>No Category Available</option>
	<?php
	}
	while($row = $result->fetch_assoc())
	{
?>
		<option value="<?php echo $row["id"] ?>"><?php echo $row["name"] ?></option>
<?php
	}
}
?>