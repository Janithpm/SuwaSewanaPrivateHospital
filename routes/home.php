<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/session.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/titleBox.php');

$USER = getSessionData();

if ($USER['type'] == "MANG") {
    header("location:mang/mang.php");
} else if ($USER['type'] == "DOC") {
    header("location:doct/doc.php");
} else if ($USER['type'] == "NUR") {
    header("location:nur/nur.php");
} else if ($USER['type'] == "SUPMANG") {
    header("location:supmang/supmang.php");
} else {
    header("location:../index.php");
}
