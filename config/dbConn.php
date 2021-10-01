<?php

$hostName = "localhost";
$userName = "root";
$password = "";
$db = "ssph_db";

$conn = mysqli_connect($hostName, $userName, $password, $db);

if (mysqli_connect_errno()) {
    echo "Error : " . mysqli_connect_error();
}
