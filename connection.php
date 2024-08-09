<?php

$host ="localhost";
$username = "root";
$password = "";
$dbname = "blood_donation";

$conn = mysqli_connect($host,$username,$password,$dbname);

if(mysqli_connect_errno()){
    die("connection failed");
}

?>