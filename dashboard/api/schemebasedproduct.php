<?php
    include("../inc/dbconn.php");

    $data = json_decode(file_get_contents('php://input'));

    if(!empty($data->schemeid)){
        $id = $data->schemeid;

        $json = "";

        $sql = "SELECT * FROM `subscription` WHERE id= '$id'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            
            $row = $result->fetch_assoc();

            $explodeproduct = explode(",",$row["productId"]);
            $explodevariation = explode(",",$row["variation"]);

            foreach ($explodeproduct as $key => $value) {
                
                $sql6 = "SELECT * FROM product WHERE id='$value'";
                $result6 = $conn->query($sql6);
                if($result6->num_rows > 0){
                    $row6 = $result6->fetch_assoc();
                    

                    $tem["product"][$key]["id"] = $row6["id"];
                    $tem["product"][$key]["productname"] = $row6["name"];
                    $tem["product"][$key]["productvariation"] = $explodevariation[$key];
                }
            }
            
            $json = json_encode($tem);
                
            if($json == ""){
                http_response_code(200);

                $myObj = new \stdClass();
                $myObj->status = "fail";
                $myObj->message = "No Products Available.";
                $json = json_encode($myObj);
            }else{
                $tem["status"] = "success";
                $tem["message"] = "Products Found";
                $json = json_encode($tem);
            }
            echo $json;
        }else{
            http_response_code(200);

            $myObj = new \stdClass();
            $myObj->status = "fail";
            $myObj->message = "Unable to Find Products.";
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }else{
        http_response_code(200);

        $myObj = new \stdClass();
        $myObj->status = "fail";
        $myObj->message = "Unable to Find Scheme.Data is Incomplete.";
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
?>