<?php
    include '../inc/dbconn.php';
    $data = json_decode(file_get_contents('php://input'));

    $conn = new mysqli($host, $username, $password, $db_name);

    
    if(!empty($_POST['mobile_number']))
    {
        $phone =  $_POST['mobile_number'];
        $DefaultId = 0;
        $array = array();
        $ImageData = $_POST['image_data'];
        
        $GetOldIdSQL ="SELECT id FROM login WHERE phone='$phone'";
        
        $Query = mysqli_query($conn,$GetOldIdSQL);
        
        while($row = mysqli_fetch_array($Query))
        {
            $DefaultId = $row['id'];
        }
    
        $ImagePath = "../Images/deliveryboy$DefaultId.png";
        $demopath = "Images/deliveryboy$DefaultId.png";
        
        $ServerURL = "https://sasaam.in/dashboard/$demopath";

        if(file_put_contents($ImagePath,base64_decode($ImageData)))
        {
            $sql = "UPDATE worker SET image='$ServerURL' WHERE lid='$DefaultId'";
            if($conn->query($sql) === TRUE)
            {
                echo $ServerURL;
            }
            else
            {
                echo "db";
            }
        }
        else
        {
            echo "Upload Failed.";
        }
    }
    else
    {
        echo "Data Incomplete.";
    }
?>