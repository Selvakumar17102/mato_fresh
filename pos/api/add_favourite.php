<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // get database connection
    include_once '../inc/dbconn.php';

    // get posted data
    $data = json_decode(file_get_contents('php://input'));

    // make sure data is not empty
    if(!empty($data->mobile_number) && !empty($data->product_id))
    {

        $phone = $data->mobile_number;
        $proid = $data->product_id;

        $sql = "SELECT * FROM favs WHERE phone='$phone' AND pro_id='$proid'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $sql1 = "DELETE FROM favs WHERE phone='$phone' AND pro_id='$proid'";
            if($conn->query($sql1) === TRUE)
            {
                http_response_code(200);
                
                $myObj = new \stdClass();
                $myObj->status = "success";
                $myObj->message = "Successfully removed from your favorite list.";
                $myJSON = json_encode($myObj);
                echo $myJSON;
            }
            else
            {
                http_response_code(200);

                $myObj = new \stdClass();
                $myObj->status = "fail";
                $myObj->message = "Unable to add Favourites.";
                $myJSON = json_encode($myObj);
                echo $myJSON;
            }
        }
        else
        {
            $sql1 = "INSERT INTO favs (phone,pro_id) VALUES ('$phone','$proid')";
            if($conn->query($sql1) === TRUE)
            {
                http_response_code(200);
                
                $myObj = new \stdClass();
                $myObj->status = "success";
                $myObj->message = "Successfully added to your favorite list.";
                $myJSON = json_encode($myObj);
                echo $myJSON;
            }
            else
            {
                http_response_code(200);

                $myObj = new \stdClass();
                $myObj->status = "fail";
                $myObj->message = "Unable to add Favourites.";
                $myJSON = json_encode($myObj);
                echo $myJSON;
            }
        }
    }
    else
    {
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to add Favourites. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }

?>