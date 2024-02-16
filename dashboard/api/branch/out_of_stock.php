<?php
    include("../../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->product_id) && !empty($data->status))
    {
        $product_id = $data->product_id;
        $status  = $data->status;
    
        $sql = "SELECT * FROM product WHERE id='$product_id'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $id = $row['id'];

            $sql1 = "UPDATE product SET status='$status' WHERE id='$product_id'";
            if($conn->query($sql1) === TRUE)
            {
                $myObj = new \stdClass();
                $output_array['user_id'] = $row['id'];
                $output_array['status'] = "success";
                $output_array['message'] = "Status updated";
                $myJSON = json_encode($output_array);
                echo $myJSON;   
            }
        }
        else
        {
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "unable to find a product";
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