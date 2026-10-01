<?php

$conn = mysqli_connect("localhost","root","");

if(!$conn) {
    echo "Connect Error" . mysqli_connect_error();
}

// to make a query

$sql = "CREATE DATABASE IF NOT EXISTS school_system";
$result = mysqli_query($conn,$sql);

mysqli_close($conn);