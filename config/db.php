<?php
    include $_SERVER['DOCUMENT_ROOT']."/joniel_php/mysql-php/config/remove_session.php";
    SESSION_START();
    function auth(){
        $hostname='localhost';
        $username='root';
        $password='';
        $database='blood_finder';
        $con = new mysqli($hostname,$username,$password,$database);
        if($con->error) echo "<div style=position:absolute;z-index:3;>ERROR</div>";
        else return $con;
    }
?>