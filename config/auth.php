<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');

if (isset($_POST['login'])) {

    $usr_name = mysqli_real_escape_string($conn, $_POST['usr_name']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

    $sq = mysqli_query($conn, "SELECT * FROM login_credentials WHERE usr_name='$usr_name' AND pwd='$pwd'");
    $row = mysqli_fetch_array($sq);
    if (mysqli_num_rows($sq) > 0) {
        $_SESSION['employeeID'] = $row['employeeID'];
        $_SESSION['usr_name'] = $row['usr_name'];
        $_SESSION['type'] = $row['type'];
        header('Location:../routes/home.php');
    } else {
        header('Location:../index.php?error=true');
    }
}
