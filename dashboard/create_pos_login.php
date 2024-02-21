<?php
ini_set('display_errors','off');
include("session.php");
include("inc/dbconn.php");

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $date = date('d-m-Y');

    $insertSql = "INSERT INTO pos_login (store_id,username,password,created_date) VALUES('$id','$user','$pass','$date')";
    if($conn->query($insertSql)===TRUE){
        echo "login create successfully!";
    }
    // $updateSql = "UPDATE login SET pos_username='$user',pos_password='$pass',pos_create_date='$date' WHERE id='$id'";
    // if($conn->query($updateSql)===TRUE){
    //     echo "login create successfully!";
    // }
}
?>