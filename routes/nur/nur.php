<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/session.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/titleBox.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/inputElement.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/buttonElement.php');

$USER = getSessionData();


if (isset($_POST['PatientPanel'])) {
    header('Location: patient/patient.php');
}
if (isset($_POST['ReportPanel'])) {
    header('Location: report/report.php');
}







?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUBA SEWANA PRIVATE HOSPITAL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous" defer></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous" defer></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #ebebeb;
        }
    </style>
</head>

<body>
    <main>
        <div class="container">
            <?php titleBox("DASHBOARD : NURSE", $USER['usr_name'], "Hello, Welcome Back", $USER['employeeID'], "dark", "../../config/logout.php", "mang.php", false); ?>
            <form method="post" action="">
                <div class="row" style="margin:15px 0;">
                    <div class="col-md-6" style="height: 250px;">
                        <div class="d-flex flex-column justify-content-center align-items-center bg-light m-10 h-100 rounded shadow">
                            <h3 class="h3">Patient Management</h3>
                            <h5 class="h5">View / Add / Update Patient Details</h5>
                            <button name="PatientPanel" class="btn btn-primary" style="margin: 10px 30px;">Open Panel</button>
                        </div>
                    </div>
                    <div class="col-md-6" style="height: 250px;">
                        <div class="d-flex flex-column justify-content-center align-items-center bg-light m-10 h-100 rounded shadow">
                            <h3 class="h3">Report Management</h3>
                            <h5 class="h5">View / Add / Update / Report Details</h5>
                            <button name="ReportPanel" class="btn btn-primary" style="margin: 10px 30px;">Open Panel</button>
                        </div>
                    </div>
                </div>

                <div style="width:100%; height:50px;"></div>
            </form>
        </div>

        </div>
    </main>
</body>

</html>