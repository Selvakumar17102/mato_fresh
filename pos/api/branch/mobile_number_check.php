<?php
    include("../../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->mobile_number)){
        $mobile_number = $data->mobile_number;

        $sql = "SELECT * FROM login WHERE phone='$mobile_number' AND control='2'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();

            $myObj = new \stdClass();
            $myObj->user_id = $row['id'];
            $myObj->status = "success";
            $myObj->message = "Updated";
            $myJSON = json_encode($myObj);
            echo $myJSON;   
        } else{
            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "unable to update.";
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