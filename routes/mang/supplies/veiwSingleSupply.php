<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/session.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/titleBox.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/inputElement.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/buttonElement.php');

$USER = getSessionData();

if (isset($_GET['btn-select'])) {
    $values = explode(" ", $_GET['btn-select']);
    $drugCode = $values[0];
    $regNo = $values[1];
    $supply_date = $values[2];
    $sq = "SELECT * FROM supply WHERE drugCode = $drugCode AND regNo = $regNo AND supply_date = '$supply_date'";
    $result = mysqli_query($conn, $sq);
    if (!$result) echo "error" . $conn->error;
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $drugCode = $row['drugCode'];
        $regNo = $row['regNo'];
        $type = $row['type'];
        $quantity = $row['quantity'];
        $unit_cost = $row['unit_cost'];
        $supply_date = $row['supply_date'];
    }
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
            <?php titleBox("DASHBOARD : MANAGEMGNT", $USER['usr_name'], "Hello, Welcome Back", $USER['employeeID'], "dark", "../../../config/logout.php", "../mang.php", true); ?>

            <div class="card mt-3 shadow">
                <h5 class="card-header">Drug Code : <?php echo $drugCode ?></h5>
                <div class="card-body">
                    <?php

                    if (!$result) {
                    ?>
                        <div class="d-flex align-items-center justify-content-center" style="min-height:400px; width:100%;">
                            <h1 class="h1 text-center"> null No Report was found</h1>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="d-flex justify-content-end">
                            <a href="supplies.php" class="btn btn-primary">Go Back</a>
                        </div>
                        <div class="d-flex justify-content-center mt-3">

                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td class="col-md-2">Drug Code</td>
                                        <td class="col-md-1">:</td>
                                        <td class="col-md-9"><?php echo $drugCode; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Vendor Register Number</td>
                                        <td>:</td>
                                        <td><?php echo $regNo; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Drug Type</td>
                                        <td>:</td>
                                        <td><?php echo $type; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Quantity</td>
                                        <td>:</td>
                                        <td><?php echo $quantity; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Unit Cost</td>
                                        <td>:</td>
                                        <td><?php echo $unit_cost; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Cost</td>
                                        <td>:</td>
                                        <td><?php echo $quantity * $unit_cost; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Supply Date</td>
                                        <td>:</td>
                                        <td><?php echo $supply_date; ?></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                </div>
            <?php
                    }
            ?>
            </div>
        </div>

        <div style="width:100%; height:50px;"></div>
        </div>

        </div>
    </main>
</body>

</html>