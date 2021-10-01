<?php

function getSessionData()
{
    $USER = array();
    session_start();
    if (!isset($_SESSION['employeeID']) || (trim($_SESSION['employeeID']) == ''))
        if (!isset($_SESSION['usr_name']) || (trim($_SESSION['usr_name']) == ''))
            if (!isset($_SESSION['type']) || (trim($_SESSION['type']) == '')) {
                header("location: ../index.php");
                exit();
            }
    $USER['employeeID'] = $_SESSION['employeeID'];
    $USER['usr_name'] = $_SESSION['usr_name'];
    $USER['type'] = $_SESSION['type'];

    return $USER;
}
