<?php
    include("../../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->user_id))
    {
        $user_id = $data->user_id;
        $status = $data->status;

        $sql = "SELECT * FROM hotel WHERE lid='$user_id'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();

            $lid = $row['lid'];

            $sql1 = "SELECT * FROM order_details WHERE latitude='$lid'";
            $result1 = $conn->query($sql1);
            $overall_order = $result1->num_rows;

            $sql2 = "SELECT * FROM product";
            $result2 = $conn->query($sql2);
            $overall_product = $result2->num_rows;

            $sql3 = "SELECT * FROM order_details WHERE latitude='$lid' AND product_id < 3 AND order_status='Accepted'";
            $result3 = $conn->query($sql3);
            $overall_received = $result3->num_rows;

            $myObj = new \stdClass();
            $output_array['status'] = "success";
            $output_array['message'] = "Branch Found";
            $output_array['GTS']['userid'] = $row['lid'];
            $output_array['GTS']['name'] = $row['name'];
            $output_array['GTS']['email_id'] = $row['email'];
            $output_array['GTS']['licence_number'] = $row['licence_number'];
            $output_array['GTS']['service'] = $row['service'];
            $output_array['GTS']['merchant_name'] = $row['name'];
            $output_array['GTS']['merchant_address'] = $row['addr'];
            $output_array['GTS']['merchant_status'] = $row['res_status'];
            $output_array['GTS']['intime'] = $row['intime'];
            $output_array['GTS']['outtime'] = $row['outtime'];
            $output_array['GTS']['prep_time'] = $row['time'];
            $output_array['GTS']['image'] = $row['image'];
            $output_array['GTS']['Restaurant_rating'] = "";
            $output_array['GTS']['overall_order'] = $overall_order;
            $output_array['GTS']['overall_product'] = $overall_product;
            $output_array['GTS']['overall_received'] = $overall_received;
            $myJSON = json_encode($output_array);
            echo $myJSON;   
            
        }
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "User unable to login, Please check your mobile number and password.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "User unable to login. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>