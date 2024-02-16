<?php
    include("../../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->cat_id)){
        $cat_id = $data->cat_id;
        $status = $data->status;

        $sql = "SELECT * FROM category WHERE id='$cat_id'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $sql = "UPDATE category SET status='$status' WHERE id='$cat_id'";
            if($conn->query($sql) === TRUE){
                $myObj = new \stdClass();
                $myObj->status = "success";
                $myObj->message = "Updated";
                $myJSON = json_encode($myObj);
                echo $myJSON;
            }
        } else{
            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Invalid category id";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
    else{
        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "unable to update. Data is incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>