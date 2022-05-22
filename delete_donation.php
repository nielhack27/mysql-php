<?php
    include "./config/db.php";
    $con=auth();
    remove_session('');
    $id = $_GET['id'];
    $sql = "DELETE FROM donations WHERE donation_id = '$id'";
    $data = $con->query($sql) or die($con->error);
    echo header("location:./dashboard.php");
?>