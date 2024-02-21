<?php
namespace Phppot;

use Phppot\CountryState;

include("../../inc/dbconn.php");
include("../../session.php");

$email = $_SESSION["username"];

$sql = "SELECT * FROM user WHERE email='$email'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$id = $row["id"];

if (!empty($_POST["client"])) 
{
    $client = $_POST["client"];

    if($row["con"] == 1)
    {
        $sql1 = "SELECT * FROM project WHERE client='$client' ORDER BY name ASC";
        $result1 = $conn->query($sql1);
        if($result1->num_rows > 0)
        {
        ?>
            <option value disabled selected>Select Project</option>
        <?php
            while($row1 = $result1->fetch_assoc())
            {
        ?>
            <option value="<?php echo $row1["id"] ?>"><?php echo $row1["name"] ?></option>
        <?php
            }
        }
        else
        {
        ?>
            <option value disabled selected>No Project for this Client</option>
        <?php
        }
    }
    else
    {
        $sql1 = "SELECT * FROM team WHERE tl Like '% $id %'";
        $result1 = $conn->query($sql1);
        $count = 0;
        while($row1 = $result1->fetch_assoc())
        {
            $teamid = $row1["id"];

            $sql2 = "SELECT * FROM projectteam WHERE team='$teamid'";
            $result2 = $conn->query($sql2);
            while($row2 = $result2->fetch_assoc())
            {
                $projectid = $row2["project"];

                $sql3 = "SELECT * FROM project WHERE id='$projectid'";
                $result3 = $conn->query($sql3);
                $row3 = $result3->fetch_assoc();

                if($row3["client"] == $client)
                {
                    if($count == 0)
                    {
                ?>
                        <option value disabled selected>Select Project</option>
                <?php
                    }
                    $count++;
            ?>
                    <option value="<?php echo $row3["id"] ?>"><?php echo $row3["name"] ?></option>
            <?php
                }
            }
        }
        if($count == 0)
        {
    ?>
            <option value disabled selected>No Projects For this Client</option>
    <?php
        }
    }
}
?>