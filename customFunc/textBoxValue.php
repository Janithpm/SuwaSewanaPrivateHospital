<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');

function textboxValue($value)
{
    $textbox = mysqli_real_escape_string($GLOBALS['conn'], trim($_POST[$value]));
    if (empty($textbox)) {
        return false;
    } else {
        return $textbox;
    }
}
