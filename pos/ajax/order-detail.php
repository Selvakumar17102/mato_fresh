<?php
    include("../inc/dbconn.php");

    if(!empty($_POST["id"]))
    {
        $id = $_POST["id"];

        $sql = "SELECT * FROM login WHERE id='$id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $city = $row["city"];

        if($row["control"] == 0)
        {
            $sql1 = "SELECT * FROM order_details WHERE order_status='Placed' AND (payment_status='Cash' || payment_status='Success') AND product_id='0'";
        }
        else
        {
            if($row["control"] == 1)
            {
                $sql1 = "SELECT * FROM order_details WHERE order_status='Placed' AND (payment_status='Cash' || payment_status='Success') AND product_id='0' AND city='$city'";
            }
            else
            {
                $sql1 = "SELECT * FROM order_details WHERE order_status='Placed' AND (payment_status='Cash' || payment_status='Success') AND product_id='0' AND latitude='$id'";
            }
        }
        $result1 = $conn->query($sql1);
        if($result1->num_rows > 0)
        {
    ?>
            <ul>
    <?php
            while($row1 = $result1->fetch_assoc())
            {
    ?>
                <li>
                    <span class="notification-icon dashbg-gray">
                        <i class="fa fa-check"></i>
                    </span>
                    <span class="notification-text">
                        New order <span><?php echo $row1["orderid"] ?></span> has been arrived.
                    </span>
                    <span class="notification-time">
                        <span><?php echo date('h:i A',strtotime($row1["booking_time"])) ?></span>
                    </span>
                </li>
    <?php
            }
    ?>
            </ul>
    <?php
        }
        else
        {
    ?>
            <label class="col-form-label">No new orders.</label>
    <?php
        }
    }
?>