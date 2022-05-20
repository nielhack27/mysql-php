<?php
    SESSION_START();
    function auth(){
        $hostname='localhost';
        $username='root';
        $password='';
        $database='';
        $con = new mysqli($hostname,$username,$password,$database);
        if($con->error) echo "<div style=position:absolute;z-index:3;>ERROR</div>";
        else return $con;
    }
?>