<?php
    include("inc/dbconn.php");
    
    $id = $_REQUEST['id'];
    $branch = $_REQUEST['branch'];
    
    $sql = "DELETE FROM push_notification WHERE sno = '$id'";
    if($conn->query($sql) === TRUE)
    {
        if($branch != '1'){
        header("Location: send-push.php?msg=Notification Deleted!");   
        } else {
        header("Location: send-push-branch.php?msg=Notification Deleted!");      
        }
    }
?>