<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/session.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/titleBox.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/inputElement.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/buttonElement.php');
date_default_timezone_set("Asia/Colombo");

$USER = getSessionData();

if (isset($_GET['btn-select'])) {
    $values = explode(" ", $_GET['btn-select']);
    $patient_type = $values[0];
    $patinetID = $values[1];
    $recorded_date = $values[2];
    $recorded_time = $values[3];

    $sq = "SELECT name FROM patient WHERE patientID = $patinetID";
    $result = mysqli_query($conn, $sq);
    if (!$result) echo "patient" . $conn->error;
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $patient_name = $row['name'];

        if ($patient_type == 'IN') {
            $sq = "SELECT *, in_patient.dob FROM in_patient_daily_record INNER JOIN in_patient ON in_patient_daily_record.patientID = in_patient.patientID WHERE in_patient_daily_record.patientID = $patinetID";
        } else {
            $sq = "SELECT * FROM out_patient_record WHERE patientID = $patinetID";
        }
        $result = mysqli_query($conn, $sq);
        if (!$result) echo "in or out patient" . $conn->error;

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $patient_pulse = $row['pulse'];
            $patient_blood_presure = $row['blood_presure'];
            $patient_weight = $row['weight'];
            $patient_temperature = $row['temperature'];
            $patient_symptoms = $row['symptoms'];
            $patient_recorded_by = $row['recorded_by'];
        }
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
            <?php titleBox("DASHBOARD : DOCTOR", $USER['usr_name'], "Hello, Welcome Back", $USER['employeeID'], "dark", "../../../config/logout.php", "doc.php", true); ?>

            <div class="card mt-3 shadow">
                <h5 class="card-header"><?php echo $patient_type ?> Patient Report</h5>
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
                            <form method="post" action="doc.php?id=<?php echo $_GET['btn-select'] ?>">
                                <?php
                                if ($patient_type == "IN") {
                                ?>
                                    <button name="btn-discharge" class="btn btn-success" style="margin: 0 15px;">Discharge The Patient</button>

                                <?php
                                } else {
                                ?>
                                    <a onclick="viewAdmit()" class="btn btn-success" style="margin: 0 15px;">Admit The Patient</a>
                                <?php
                                }
                                ?>
                            </form>
                            <a href="doc.php" class="btn btn-primary">Go Back</a>
                        </div>
                        <div class="mb-3" id="viewAdmitBox"></div>

                        <div id="vprt" class="d-flex justify-content-center mt-3">

                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td class="col-md-2">Patient ID</td>
                                        <td class="col-md-1">:</td>
                                        <td class="col-md-9"><?php echo $patinetID; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Patient Name</td>
                                        <td>:</td>
                                        <td><?php echo $patient_name; ?></td>
                                    </tr>
                                    <?php
                                    if (isset($row['dob'])) {
                                        $patient_dob = $row['dob'];
                                    ?>
                                        <tr>
                                            <td>Patient Date Of Birth</td>
                                            <td>:</td>
                                            <td><?php echo $patient_dob; ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr>
                                        <td>Recorded Date</td>
                                        <td>:</td>
                                        <td><?php echo $recorded_date; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Recorded Time</td>
                                        <td>:</td>
                                        <td><?php echo $recorded_time; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Recorded BY</td>
                                        <td>:</td>
                                        <td><?php echo $patient_recorded_by; ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td>Pulse</td>
                                        <td>:</td>
                                        <td><?php echo $patient_pulse; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Blood Pressure</td>
                                        <td>:</td>
                                        <td><?php echo $patient_blood_presure; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td>:</td>
                                        <td><?php echo $patient_weight; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Temperature</td>
                                        <td>:</td>
                                        <td><?php echo $patient_temperature; ?></td>
                                    </tr>
                                    <tr>
                                        <td>symptoms</td>
                                        <td>:</td>
                                        <td><?php echo $patient_symptoms; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="viewAdmitBox"></div>


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

<script>
    function viewAdmit() {

        document.getElementById('viewAdmitBox').innerHTML = `
        <div class="h-50 w-100 d-flex align-items-center" style=" min-height:200px; border-bottom: 2px solid black;">
        <form method="post" class="w-100" action="doc.php?id=<?php echo $_GET['btn-select'] ?>">
            <div class="row">
            <div class="form-group mb-2 col-md-4">
                <label for="dea_no">Word ID</label>
                <input type="text" class="form-control" id="patient_wordID" name="patient_wordID">
            </div>

            <div class="form-group mb-2 col-md-4">
                <label for="dea_no">Bed ID</label>
                <input type="text" class="form-control" id="patient_bedID" name="patient_bedID">
            </div>

            </div>
            <div class="row">
            <div class="form-group mb-2 col-md-4">
                <label for="dea_no">Patient Date Of Birth</label>
                <input type="text" class="form-control" id="patient_dob" name="patient_dob">
            </div>
            </div>
            <div class="mt-2">
            <a class="btn btn-primary"onclick="hideAdmit()">Cancel</a>
            <button name="patient-admit" class="btn btn-danger">Admit Now</button>
            </div>
        </form>
        </div>
        `;

    }

    function hideAdmit() {
        document.getElementById('viewAdmitBox').innerHTML = ``;
        location.reload();


    }
</script>



</html>