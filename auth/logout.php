<?php
    include "../config/db.php";
    unset($_SESSION['user_id']);
    echo header('location:./login.php');
?>