<?php
    include("../../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->user_id)){
        $user_id = $data->user_id;
        $time = $data->prep_time;

        $sql = "SELECT * FROM login WHERE id='$user_id' AND control='2'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $sql = "UPDATE hotel SET time='$time' WHERE lid='$user_id'";
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
            $myObj->message = "Invalid user";
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