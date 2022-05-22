<?php
    include "./config/db.php";
    $con=auth();
    $DL = $_GET['DL'];
    $request_id=$_GET['request_id'];
    $isApprove=$_GET['isApprove'];
    $id = $_SESSION['user_id'];
    $check_limit = "SELECT request_details.request_liters as RL,donations.liters as available_liter ,sum(request_liters) as total_liters FROM request_details
        NATURAL JOIN donations
        WHERE request_details.request_donations_id = donations.donation_id
        AND request_details.status = 'APPROVED'
        AND request_donations_id = (SELECT request_donations_id from request_details WHERE request_id='$request_id')
    ";
    $check_limit_data =$con->query($check_limit) or die($con->error);
    $check_limit_details = $check_limit_data->fetch_assoc();
    if(isset($request_id) && isset($id) && $isApprove=='True'){
        $AB = $check_limit_details['available_liter']-$check_limit_details['total_liters'];
        if($AB>=$DL){
            $sql = "UPDATE request_details SET status='APPROVED' WHERE request_id='$request_id'";
            $con->query($sql) or die($con->error);
            $_SESSION['donate'] = "<p class='text-center w-75 m-auto rounded text-success border border-success'>REQUEST APPROVE</p>";
        }else{
            $_SESSION['donate'] = "<p class='text-center w-75 m-auto rounded text-danger border border-danger'>AVAILABLE LITERS OF BLOOD :". $AB." </p>";
        }
        echo header('location:./dashboard.php');
    }else if(isset($request_id) && isset($id) && $isApprove=='False'){
        $sql = "UPDATE request_details SET status='CANCELLED' WHERE request_id='$request_id'";
        $con->query($sql) or die($con->error);
        $_SESSION['donate'] = "<p class='text-center w-75 m-auto rounded text-success border border-success'>REQUEST CANCELLED</p>";
        echo header('location:./dashboard.php');
    }else{
        echo header('location:./auth/login.php');
    }
?>