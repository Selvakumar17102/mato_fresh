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
            $sql1 = "SELECT * FROM order_details WHERE order_status='Placed' AND (payment_status='Cash' || payment_status='Success') AND product_id='0' AND noti='0'";
        }
        else
        {
            if($row["control"] == 1)
            {
                $sql1 = "SELECT * FROM order_details WHERE order_status='Placed' AND (payment_status='Cash' || payment_status='Success') AND product_id='0' AND city='$city' AND noti='0'";
            }
            else
            {
                $sql1 = "SELECT * FROM order_details WHERE order_status='Placed' AND (payment_status='Cash' || payment_status='Success') AND product_id='0' AND latitude='$id' AND noti='0'";
            }
        }
        $result1 = $conn->query($sql1);
        if($result1->num_rows > 0)
        {
            if($row["control"] == 0)
            {
                $sql2 = "UPDATE order_details SET noti='1' WHERE order_status='Placed' AND (payment_status='Cash' || payment_status='Success') AND product_id='0' AND noti='0'";
            }
            else
            {
                if($row["control"] == 1)
                {
                    $sql2 = "UPDATE order_details SET noti='1' WHERE order_status='Placed' AND (payment_status='Cash' || payment_status='Success') AND product_id='0' AND city='$city' AND noti='0'";
                }
                else
                {
                    $sql2 = "UPDATE order_details SET noti='1' WHERE order_status='Placed' AND (payment_status='Cash' || payment_status='Success') AND product_id='0' AND latitude='$id' AND noti='0'";
                }
            }
            if($conn->query($sql2) === TRUE)
            {
                echo "1";
            }
        }
    }
?>