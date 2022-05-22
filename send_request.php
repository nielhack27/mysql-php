<?php
    include "./config/db.php";
    $con=auth();
    $donate_id = $_GET['donate_id'];
    $req_id = $_GET['req_id'];
    if(isset($req_id) && isset($donate_id)){
        $attempt_sql = "SELECT request_id FROM request_details WHERE request_user_id='$req_id' AND request_donations_id='$donate_id'";
        $attempt_data = $con->query($attempt_sql) or die($con->error);
        $attempt_details = $attempt_data->fetch_assoc();
        if(!isset($attempt_details['request_id'])){
            $sql = "INSERT INTO request_details VALUES('','$req_id','$donate_id','1','PENDING')";
            $data=$con->query($sql) or die($con->error);
            $_SESSION['notification'] = "<p id='notification' class='text-success border border-success rounded'>REQUEST SENT</p>";
        }else{
            $_SESSION['notification'] = "<p id='notification' class='text-danger border border-danger rounded'>REQUEST DENIED, ALREADY SENT A REQUEST !</p>";
        }
        echo header("location:./");
    }else{
        $_SESSION['notification'] = "<p id='notification' class='text-danger border border-danger rounded'>REQUEST DENIED</p>";
    }
?>

<a href="./send_request.php?donate_id=<?php echo $donation_details['donation_id']; ?>&req_id=<?php echo  $id; ?>">