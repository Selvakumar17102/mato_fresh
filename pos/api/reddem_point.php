<?php
    include("../inc/dbconn.php");

    //$sql = "select products.sno, status, product_name,   CONCAT(NULLIF(grosswt, ''), Wastage (%) : ',wastage,', Net Weight : ', netwt,', No. Of Pieces : ',pieces ) as clean ,demoamt,category.category_name as main_category, sub_category.category_name as sub_category, price, img_url from products inner join category on products.category = category.sno inner join sub_category on products.sub_category = sub_category.sno";

    //$sql = "select products.sno, status, product_name,   CONCAT_WS(',', CONCAT(NULLIF(grosswt, ''),', Wastage (%) : ',wastage, ',Net Weight : ',netwt, ',No. Of Pieces : ',pieces)) as clean ,demoamt,category.category_name as main_category, sub_category.category_name as sub_category, price, img_url from products inner join category on products.category = category.sno inner join sub_category on products.sub_category = sub_category.sno";

    $data = json_decode(file_get_contents('php://input'));

    $phone = $data->mobile_number;
    $point = $data->point;
    $status = $data->status;

    $sql = "SELECT * FROM users WHERE phone='$phone'";
    $result = $conn->query($sql);
    if($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            $po = $row["reddem"];

            if($status == "plus")
            {
                $po += $point;
            }
            if($status == "minus")
            {
                $po -= $point;
            }
            $sql1 = "UPDATE users SET reddem='$po' WHERE phone='$phone'";
            if($conn->query($sql1) === TRUE)
            {
                $tem["Veggis"]["status"] = "Success";
                $tem["Veggis"]["message"] = "Successfully reddem your points";

                $json = json_encode($tem);
            }
            else
            {
                $tem["Veggis"]["status"] = "Failed";
                $tem["Veggis"]["message"] = "Failed reddem your points";

                $json = json_encode($tem);
            }
        }

        echo $json;
        $conn->close();
    }
    else
    {
        $tem["Veggis"]["status"] = "Failed";
        $tem["Veggis"]["message"] = "Mobile number not available";

        $json = json_encode($tem);

        echo $json;
        $conn->close();
    }
?>