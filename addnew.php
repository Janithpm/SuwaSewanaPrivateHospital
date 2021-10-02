<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');


if (isset($_POST['submit-login-cred'])) {
    $employeeID = textBoxValue('employeeID');
    $usr_name = textBoxValue('usr_name');
    $pwd = $_POST['pwd'];
    $type = textBoxValue('type');
    $pwd_hash = password_hash($pwd, PASSWORD_DEFAULT);
    $sq = "INSERT INTO login_credentials VALUES ($employeeID, '$usr_name', '$pwd_hash', '$type')";

    if (mysqli_query($conn, $sq)) {
        echo "done";
    } else {
        echo $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add new</title>
</head>

<body>
    <form method="post">
        <input type="text" name="employeeID" placeholder="ID">
        <input type="text" name="usr_name" placeholder="user name">
        <input type="text" name="pwd" placeholder="password">
        <input type="text" name="type" placeholder="type">
        <button name="submit-login-cred" type="submit">submit</button>
    </form>
</body>

</html>