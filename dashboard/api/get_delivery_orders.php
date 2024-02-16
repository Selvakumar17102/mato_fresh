<?php
    include("../inc/dbconn.php");
    include("distance-calculator-n.php");

    $data = json_decode(file_get_contents('php://input'));
    $json = "";

    if(!empty($data->mobile_number))
    {
        $phone = $data->mobile_number;

        $tem = array();
        $av = 0;

        $sql = "SELECT * FROM order_details WHERE order_status='Accepted' AND (longitude='0' OR longitude IS NULL)";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc())
        {
            $hid = $row["latitude"];

            $sql1 = "SELECT * FROM hotel WHERE lid='$hid'";
            $result1 = $conn->query($sql1);
            $row1 = $result1->fetch_assoc();

            $lati1 = $row1["lati"];
            $longi1 = $row1["longi"];

            $nullarray = array();

            $sql2 = "SELECT * FROM worker WHERE status='Online' AND approved='true' AND lati!=''";
            $result2 = $conn->query($sql2);
            if($result2->num_rows > 0)
            {
                $i = 0;
                while($row2 = $result2->fetch_assoc())
                {
                    $id = $row2["lid"];

                    $lati2 = $row2["lati"];
                    $longi2 = $row2["longi"];

                    $nullarray[$id] = getDistance($lati1,$longi1,$lati2,$longi2);

                    $i++;
                }
            }

            $sql3 = "SELECT * FROM login WHERE phone='$phone'";
            $result3 = $conn->query($sql3);
            $row3 = $result3->fetch_assoc();

            $wid = $row3["id"];

            asort($nullarray);
            $i = $j = $k = 0;
            
            foreach($nullarray as $x => $x_value)
            {
                if($i < 5)
                {
                    if($x == $wid)
                    {
                        $j = 1;
                        $k = $x_value;
                    }
                    $i++;
                }
            }

            if($j == 1)
            {
                $tem["Veggis"][$av]["id"] = $row["sno"];
                $tem["Veggis"][$av]["orderid"] = $row["orderid"];
                $tem["Veggis"][$av]["distance"] = round($k,2).' KM';
                $tem["Veggis"][$av]["total_amount"] = $row["overall_total_amount"];
                $tem["Veggis"][$av]["mode_of_payment"] = $row["payment_status"];
                $tem["Veggis"][$av]["order_status"] = $row["order_status"];
                $tem["Veggis"][$av]["delivery_slot"] = $row["delivery_slot"];
                $tem["Veggis"][$av]["booking_date"] = date('d-m-Y',strtotime($row["booking_date"]));

                $av++;
            }
        }

        if($av == 0)
        {
            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to find order.";
            $json = json_encode($myObj);
        }
        else
        {
            $tem["status"] = "success";
            $tem["message"] = "Orders found";

            $json = json_encode($tem);
        }
    }
    else
    {
        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to order. Data is incomplete.";
        $json = json_encode($myObj);
    }

    echo $json;
?>