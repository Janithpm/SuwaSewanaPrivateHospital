<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');

if (isset($_POST['btn-search'])) {

    $id = textBoxValue('patient_search');
    $sq = "SELECT * FROM patient WHERE patientID = '$id' OR name LIKE '$id'";
    $result = mysqli_query($conn, $sq);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
        $patientID = $row['patientID'];
        $_SESSION['patientID'] = $patientID;
        $patient_name = $row['name'];
        $patient_dob = $row['dob'];
        $patient_type = $row['type'];
    } else if (mysqli_num_rows($result) == 0) {
        $id = 0;
    } else {
        echo $conn->error;
    }
}


if (isset($_POST['btn-save-patient'])) {
    $patientID = $_SESSION['patientID'];
    $patient_name = textBoxValue('patient_name');
    $patient_dob = textBoxValue('patient_dob');
    $sq = "UPDATE patient SET name='$patient_name', dob='$patient_dob' WHERE patientID = $patientID ";
    if (mysqli_query($conn, $sq)) {

        if ($_SESSION['tn'] == "in_patient") {
            $patient_bedID = textBoxValue('patient_bedID');
            $patient_admited_by = textBoxValue('patient_admited_by');
            $admited_date = textBoxValue('admited_date');
            $admited_time = textBoxValue('admited_time');
            $discharged_date = textBoxValue('discharged_date');
            $discharged_time = textBoxValue('discharged_time');
            $sq = "UPDATE in_patient SET bedID = $patient_bedID, admit_by='$patient_admited_by', admited_date='$admited_date', admited_time = '$admited_time', discharged_date='$discharged_date', discharged_time='$discharged_time' WHERE patientID = $patientID";
            if (!mysqli_query($conn, $sq)) {
                echo "in" . $conn->error;
            }
        } else if ($_SESSION['tn'] == 'out_patient') {
            $arrived_date = textBoxValue('arrived_date');
            $arrived_time = textBoxValue('arrived_time');
            $sq = "UPDATE out_patient SET arrived_date = '$arrived_date', arrived_time = '$arrived_time' WHERE patientID = $patientID";
            if (!mysqli_query($conn, $sq)) {
                echo "out" . $conn->error;
            }
        }
    } else {
        echo "patient" . $conn->error;
    }
}

if (isset($_POST['btn-delete'])) {
    $vendor_regNo = $_SESSION['vendor_regNo'];
    $sq = "DELETE FROM vendor WHERE regNo = $vendor_regNo";
    if (!mysqli_query($conn, $sq)) {
        echo $conn->error;
    }
}

?>


<div class="card mt-3 shadow">
    <h5 class="card-header">VIEW / EDIT PATIENT</h5>
    <div class="card-body">
        <form method="post" action="" class="d-flex justify-content-start">
            <div class="row w-100">
                <div class="input-group col-md-6 w-50">
                    <input type="text" name="patient_search" class="form-control rounded" placeholder="Search Paitent : Patient ID or Name" aria-label="Search" aria-describedby="search-addon" />
                    <button name="btn-search" value="btn-search" class="btn btn-outline-primary">search</button>
                </div>
                <div class="input-group w-50 col-md-6 d-flex justify-content-end">
                    <a onclick="displayAddNew()" class="btn btn-primary"> + Add New Patient</a>
                </div>
            </div>
        </form>
        </br>
        <?php

        if (!isset($id)) {
        ?>
            <div class="d-flex align-items-center justify-content-center" style="min-height:400px; width:100%;">
                <h1 class="h1 text-center">SEARCH FOR PATIENT ...</h1>
            </div>
        <?php
        } else if ($id == 0) {
        ?>
            <div class="d-flex align-items-center justify-content-center" style="min-height:400px; width:100%;">
                <h1 class="h1 text-center">SORRY,<br>There is no Patient with that Patient ID. <br> Try Again !</h1>
            </div>

        <?php
        } else {
        ?>
            <hr>
            <div class="d-flex justify-content-center mt-3">
                <form action="" method="post" class="w-100">
                    <div class="d-flex justify-content-between">
                        <h2 class="h2">Patient ID : <?php echo isset($id) ? $patientID : ""; ?></h2>
                        <div>
                            <a onclick="enableEdit()" id="btn-edit-patient" class="btn btn-success"> Edit Details</a>
                        </div>

                    </div>
                    <h4 class="h4 pt-2 pb-2"><?php
                                                echo " -- ( ";
                                                if ($patient_type == "IN") echo "IN Patient";
                                                else if ($patient_type == "OUT") echo "OUT Patient";
                                                else echo "Other";
                                                echo " )"
                                                ?>
                    </h4>
                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="name">Patient Name</label>
                            <input type="text" name="patient_name" class="form-control" id="v_name" value="<?php echo $patient_name; ?>" disabled>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="address">Patient Date Of Birth</label>
                            <input type="text" name="patient_dob" class="form-control" id="v_dob" value="<?php echo $patient_dob; ?>" disabled>
                        </div>
                    </div>

                    <?php
                    if ($patient_type == "IN") {
                        $_SESSION['tn'] = "in_patient";
                        $sq = "SELECT * FROM in_patient WHERE patientID = $patientID";
                        $result = mysqli_query($conn, $sq);
                        $row = mysqli_fetch_assoc($result);
                        if (mysqli_num_rows($result) > 0) {
                            $patient_bedID = $row['bedID'];
                            $patient_admited_by = $row['admit_by'];
                            $admited_date = $row['admited_date'];
                            $admited_time = $row['admited_time'];
                            $discharged_date = $row['discharged_date'];
                            $discharged_time = $row['discharged_time'];
                    ?>
                            <div class="row mt-4">
                                <div class="form-group mb-2 col-md-4">
                                    <label for="patient_bedID">Patient Bed ID</label>
                                    <input type="text" class="form-control" id="patient_bedID" name="patient_bedID" disabled value="<?php echo $patient_bedID; ?>">
                                </div>
                                <div class="form-group mb-2 col-md-4">
                                    <label for="patient_admited_by">Admitted By</label>
                                    <input type="text" class="form-control" id="patient_admited_by" name="patient_admited_by" disabled value="<?php echo $patient_admited_by; ?>">
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="form-group mb-2 col-md-4">
                                    <label for="admited_date">Admitted Date</label>
                                    <input type="text" class="form-control" id="admited_date" name="admited_date" disabled value="<?php echo $admited_date; ?>">
                                </div>
                                <div class="form-group mb-2 col-md-4">
                                    <label for="admited_time">Admitted Time</label>
                                    <input type="text" class="form-control" id="admited_time" name="admited_time" disabled value="<?php echo $admited_time; ?>">
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="form-group mb-2 col-md-4">
                                    <label for="discharged_date">Discharged Date</label>
                                    <input type="text" class="form-control" id="discharged_date" name="discharged_date" disabled value="<?php echo $discharged_date; ?>">
                                </div>
                                <div class="form-group mb-2 col-md-4">
                                    <label for="discharged_time">Discharged Time</label>
                                    <input type="text" class="form-control" id="discharged_time" name="discharged_time" disabled value="<?php echo $discharged_time; ?>">
                                </div>
                            </div>
                        <?php
                        } else {
                            echo $conn->error;
                        }
                    } else if ($patient_type == "OUT") {
                        $_SESSION['tn'] = "out_patient";
                        $sq = "SELECT * FROM out_patient WHERE patientID = '$patientID'";
                        $result = mysqli_query($conn, $sq);
                        $row = mysqli_fetch_assoc($result);


                        if (mysqli_num_rows($result) > 0) {
                            $arrived_date = $row['arrived_date'];
                            $arrived_time = $row['arrived_time'];
                        ?>
                            <div class="row mt-4">
                                <div class="form-group mb-2 col-md-4">
                                    <label for="arrived_date">Arrived Date</label>
                                    <input type="text" class="form-control" id="arrived_date" name="arrived_date" disabled value="<?php echo $arrived_date; ?>">
                                </div>
                                <div class="form-group mb-2 col-md-4">
                                    <label for="arrived_time">Arrived Time</label>
                                    <input type="text" class="form-control" id="arrived_time" name="arrived_time" disabled value="<?php echo $arrived_time; ?>">
                                </div>
                            </div>
                    <?php
                        } else {
                            echo $conn->error;
                        }
                    }
                    ?>
                    <div class="mt-5" id="edit-cancel-btn"></div>
                </form>
            </div>
        <?php
        }
        ?>

        <script>
            function displayAddNew() {
                document.getElementById('addNewEmp').style = 'display: block';
                document.getElementById('viewEmp').style = 'display: none';
            }

            function enableEdit() {
                document.getElementById('edit-cancel-btn').innerHTML = `
                    <button name="btn-save-patient" style="margin-right:20px; margin-left: 0;" class="btn btn-danger" id='btn-save'>Save</button>
                    <a onclick="disableEdit()" class="btn btn-success">Cancel</a>
            `;
                document.getElementById('v_name').disabled = false;
                document.getElementById('v_dob').disabled = false;

                try {
                    document.getElementById('patient_bedID').disabled = false;
                    document.getElementById('patient_admited_by').disabled = false;
                    document.getElementById('admited_date').disabled = false;
                    document.getElementById('admited_time').disabled = false;
                    document.getElementById('discharged_date').disabled = false;
                    document.getElementById('discharged_time').disabled = false;
                } catch {
                    document.getElementById('arrived_date').disabled = false;
                    document.getElementById('arrived_time').disabled = false;
                }


            }

            function disableEdit() {
                document.getElementById('v_name').disabled = true;
                document.getElementById('v_dob').disabled = true;

                try {
                    document.getElementById('patient_bedID').disabled = true;
                    document.getElementById('patient_admited_by').disabled = true;
                    document.getElementById('admited_date').disabled = true;
                    document.getElementById('admited_time').disabled = true;
                    document.getElementById('discharged_date').disabled = true;
                    document.getElementById('discharged_time').disabled = true;
                } catch {
                    document.getElementById('arrived_date').disabled = true;
                    document.getElementById('arrived_time').disabled = true;
                }

                location.reload();
            }
        </script>
    </div>
</div>