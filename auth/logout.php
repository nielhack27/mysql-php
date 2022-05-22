<?php
    include "../config/db.php";
    session_unset();
    remove_session('');
    echo header('location:./login.php');
?>