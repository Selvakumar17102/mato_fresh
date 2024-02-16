 <?php

    include '../inc/dbconn.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $DefaultId = 0;
        $array = array();
        $ImageData = $_POST['image_data'];
        
        $ImageName = $_POST['image_tag'];

        $GetOldIdSQL ="SELECT id FROM ImageUpload ORDER BY id DESC LIMIT 1";
        $Query = mysqli_query($conn,$GetOldIdSQL);
        $row = mysqli_fetch_array($Query);

        $DefaultId = $row['id'];
    
        $ImagePath = "../Images/birthday/$DefaultId.png";
        $demopath = "Images/birthday/$DefaultId.png";
        
        $ServerURL = "https://bakerymaharaj.com/dashboard/$demopath";
        
        if(file_put_contents($ImagePath,base64_decode($ImageData)))
        {
            $InsertSQL = "INSERT INTO ImageUpload (image_data,image_tag) VALUES ('$ServerURL','$ImageName')";
            if($conn->query($InsertSQL) === TRUE)
            {
                echo $ServerURL.",".$ImageName;
            }
        }
        else
        {
            $sql = "INSERT INTO ImageUpload (image_tag) VALUES ('$ImageName')";
            if($conn->query($sql) === TRUE)
            {
                echo ",".$ImageName;
            }
        }
    }
    else
    {
        echo "Please Try Again";
    }

?>