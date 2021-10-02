<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');


if (isset($_POST['btn-search'])) {

    $id = textBoxValue('employeeID');
    $sq = "SELECT * FROM employee WHERE employeeID = '$id' OR contact_no = '$id' OR name LIKE '$id'";
    $result = mysqli_query($conn, $sq);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
        $employeeID = $row['employeeID'];

        $_SESSION['empid'] = $employeeID;
        $name = $row['name'];
        $address = $row['address'];
        $contact_no = $row['contact_no'];
        $working_status = $row['working_status'];
        $job_type = $row['job_type'];

        if ($job_type == "DOC") {
            $_SESSION['tn'] = "doctor";
            $sq1 = "SELECT * FROM doctor WHERE employeeID = $employeeID";
            $result = mysqli_query($conn, $sq1);
            $row = mysqli_fetch_assoc($result);
            if (mysqli_num_rows($result) > 0) {
                $DEA_no = $row['DEA_no'];
                $speciality = $row['speciality'];
                $medC_reg_no = $row['med_council_reg_no'];
                $medC_joined_date = $row['medC_joined_date'];
                $medC_resigned_date = $row['medC_resigned_date'];
            }
        } else if ($job_type == "NUR") {
            $_SESSION['tn'] = "nurse";
            $sq1 = "SELECT * FROM nurse WHERE employeeID = $employeeID";
            $result = mysqli_query($conn, $sq1);
            $row = mysqli_fetch_assoc($result);
            if (mysqli_num_rows($result) > 0) {
                $medC_reg_no = $row['med_council_reg_no'];
                $medC_joined_date = $row['medC_joined_date'];
                $medC_resigned_date = $row['medC_resigned_date'];
            }
        } else if ($job_type == "ATD") {
            $_SESSION['tn'] = "attendent";
            $sq1 = "SELECT * FROM attendent WHERE employeeID = $employeeID";
            $result = mysqli_query($conn, $sq1);
            $row = mysqli_fetch_assoc($result);
            if (mysqli_num_rows($result) > 0) {
                $hourly_charge_rate = $row['hourly_charge_rate'];
            }
        } else if ($job_type == "CLN") {
            $_SESSION['tn'] = "cleaner";
            $sq1 = "SELECT * FROM cleaner WHERE employeeID = $employeeID";
            $result = mysqli_query($conn, $sq1);
            $row = mysqli_fetch_assoc($result);
            if (mysqli_num_rows($result) > 0) {
                $contract_no = $row['contract_no'];
                $start_date = $row['start_date'];
                $end_date = $row['end_date'];
            }
        } else if ($job_type == "MANG") {
            $_SESSION['tn'] = "";
        }
    } else if (mysqli_num_rows($result) == 0) {
        $id = 0;
    } else {
        echo $conn->error;
    }
}


if (isset($_POST['btn-save'])) {
    $name = textBoxValue('name');
    $address = textBoxValue('address');
    $contact_no = textBoxValue('contact_no');

    $employeeID = (int) $_SESSION['empid'];
    $tableName = $_SESSION['tn'];
    $working_status = $_POST['working_status'];
    $sq = "UPDATE employee SET name='$name', address='$address', contact_no='$contact_no', working_status='$working_status' WHERE employeeID = $employeeID ";
    if (!mysqli_query($conn, $sq)) {
        echo $conn->error;
    }

    if ($tableName == "doctor") {
        $dea_no = textBoxValue('dea_no');
        $speciality = textBoxValue('speciality');
        $medC_reg_no = textBoxValue('medC_reg_no');
        $medC_joined_date = textBoxValue('medC_joined_date');
        $medC_resigned_date = textBoxValue('medC_resigned_date');
        $sq1 = "UPDATE doctor SET DEA_no='$dea_no', speciality='$speciality', med_council_reg_no='$medC_reg_no', medC_joined_date='$medC_joined_date', medC_resigned_date='$medC_resigned_date' WHERE employeeID = $employeeID";
        if (!mysqli_query($conn, $sq1)) {
            echo $conn->error;
        }
    } else if ($tableName == "nurse") {
        $medC_reg_no = textBoxValue('medC_reg_no');
        $medC_joined_date = textBoxValue('medC_joined_Date');
        $medC_resigned_date = textBoxValue('medC_resigned_Date');
        $sq1 = "UPDATE nurse SET med_council_reg_no='$medC_reg_no', medC_joined_date='$medC_joined_date', medC_resigned_date='$medC_resigned_date' WHERE employeeID = $employeeID";
        if (!mysqli_query($conn, $sq1)) {
            echo $conn->error;
        }
    } else if ($tableName == "attendent") {
        $hourly_charge_rate = (float)textBoxValue('hourly_charge_rate');
        $sq1 = "UPDATE attendent SET hourly_charge_rate=$hourly_charge_rate WHERE employeeID = $employeeID";
        if (!mysqli_query($conn, $sq1)) {
            echo $conn->error;
        }
    } else if ($tableName == "cleaner") {
        $contract_no = textBoxValue('contract_no');
        $start_date = textBoxValue('start_date');
        $end_date = textBoxValue('end_date');
        $sq1 = "UPDATE cleaner SET contract_no='$contract_no', start_date='$start_date', end_date='$end_date' WHERE employeeID = $employeeID";
        if (!mysqli_query($conn, $sq1)) {
            echo $conn->error;
        }
    }
}


if (isset($_POST['btn-delete'])) {
    $employeeID = $_SESSION['empid'];
    $tableName = $_SESSION['tn'];
    $sq = "DELETE FROM employee WHERE employeeID = $employeeID";
    if (!mysqli_query($conn, $sq)) {
        echo $conn->error;
    }
    $sq = "DELETE FROM $tableName WHERE employeeID = $employeeID";
    if (!mysqli_query($conn, $sq)) {
        echo $conn->error;
    }
}

?>

<div class="card mt-3 shadow">
    <h5 class="card-header">VIEW / EDIT / DELETE EMPLOYEE</h5>
    <div class="card-body">
        <form method="post" action="" class="d-flex justify-content-start">
            <div class="row w-100">
                <div class="input-group col-md-6 w-50">
                    <input type="text" name="employeeID" class="form-control rounded" placeholder="Search Employee : Employee ID or Contact Number or Name" aria-label="Search" aria-describedby="search-addon" />
                    <button name="btn-search" value="btn-search" class="btn btn-outline-primary">search</button>
                </div>
                <div class="input-group w-50 col-md-6 d-flex justify-content-end">
                    <a onclick="displayAddNew()" class="btn btn-primary"> + Add New Employee</a>
                </div>
            </div>
        </form>
        </br>
        <?php

        if (!isset($id)) {
        ?>
            <div class="d-flex align-items-center justify-content-center" style="min-height:400px; width:100%;">
                <h1 class="h1 text-center">SEARCH FOR EMPLOYEE ...</h1>
            </div>
        <?php
        } else if ($id == 0) {
        ?>
            <div class="d-flex align-items-center justify-content-center" style="min-height:400px; width:100%;">
                <h1 class="h1 text-center">SORRY,<br>There is no employee with that employee ID. <br> Try Again !</h1>
            </div>

        <?php
        } else {
        ?>
            <hr>
            <div class="d-flex justify-content-center mt-3">
                <form action="" method="post" class="w-100">
                    <div class="d-flex justify-content-between">
                        <h2 class="h2">Emloyee ID : <?php echo isset($id) ? $employeeID : ""; ?></h2>
                        <div>
                            <a onclick="enableEdit()" id="btn-edit" class="btn btn-success"> Edit Details</a>
                            <?php buttonElement("btn-delete", "btn btn-danger", " - Delete Employee", "btn-delete", "") ?>
                        </div>

                    </div>
                    <h4 class="h4 pt-2 pb-2"><?php
                                                echo " -- ( ";
                                                if ($job_type == "DOC") echo "Doctor";
                                                else if ($job_type == "NUR") echo "Nurse";
                                                else if ($job_type == "ATD") echo "Attendent";
                                                else if ($job_type == "CLN") echo "Cleaner";
                                                else if ($job_type == "MANG") echo "Management";
                                                else echo "Other";
                                                echo " )"
                                                ?>
                    </h4>
                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="name">Employee Name</label>
                            <input type="text" name="name" class="form-control" id="v_name" value="<?php echo $name; ?>" disabled>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="address">Employee Address</label>
                            <input type="text" name="address" class="form-control" id="v_address" value="<?php echo $address; ?>" disabled>
                        </div>
                    </div>

                    <div class="row pt-2">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="contact_no">Employee Contact Number</label>
                                <input type="text" name="contact_no" class="form-control" id="v_contact_no" value="<?php echo $contact_no; ?>" disabled>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <legend class="col-form-label pt-0">Working Status</legend>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="working_status" id="gr1" value="F" disabled <?php echo $working_status == 'F' ? "checked" : ""; ?>>
                                <label class="form-check-label text-dark" for="gr1">
                                    Full Time
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="working_status" id="gr2" value="P" disabled <?php echo $working_status == 'P' ? "checked" : ""; ?>>
                                <label class="form-check-label text-dark" for="gr2">
                                    Part Time
                                </label>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($job_type == "DOC") {
                    ?>
                        <div class="row mt-4">
                            <div class="form-group mb-2 col-md-4">
                                <label for="dea_no">DEA No</label>
                                <input type="text" class="form-control" id="dea_no" name="dea_no" disabled value="<?php echo $DEA_no; ?>">
                            </div>
                            <div class="form-group mb-2 col-md-4">
                                <label for="speciality">Speciality</label>
                                <input type="text" class="form-control" id="speciality" name="speciality" disabled value="<?php echo $speciality; ?>">
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="form-group mb-2 col-md-4">
                                <label for="medC_reg_no">Medical Council Registration No</label>
                                <input type="text" class="form-control" id="medC_reg_no" name="medC_reg_no" disabled value="<?php echo $medC_reg_no; ?>">
                            </div>
                            <div class="form-group mb-2 col-md-4">
                                <label for="medC_joined_date">Joined Date</label>
                                <input type="text" class="form-control" id="medC_joined_date" name="medC_joined_date" disabled value="<?php echo $medC_joined_date; ?>">
                            </div>
                            <div class="form-group mb-2 col-md-4">
                                <label for="medC_resigned_date">Resigned Date</label>
                                <input type="text" class="form-control" id="medC_resigned_date" name="medC_resigned_date" disabled value="<?php echo $medC_resigned_date; ?>">
                            </div>
                        </div>
                    <?php
                    } else if ($job_type == "NUR") {
                    ?>
                        <div class="row mt-4">
                            <div class="form-group mb-2 col-md-4">
                                <label for="medC_reg_no">Medical Council Registration No</label>
                                <input type="text" class="form-control" id="n_medC_reg_no" name="medC_reg_no" disabled value="<?php echo $medC_reg_no; ?>">
                            </div>
                            <div class="form-group mb-2 col-md-4">
                                <label for="medC_joined_Date">Joined Date</label>
                                <input type="text" class="form-control" id="n_medC_joined_date" name="medC_joined_Date" disabled value="<?php echo $medC_joined_date; ?>">
                            </div>
                            <div class="form-group mb-2 col-md-4">
                                <label for="medC_resigned_Date">Resigned Date</label>
                                <input type="text" class="form-control" id="n_medC_resigned_date" name="medC_resigned_Date" disabled value="<?php echo $medC_resigned_date; ?>">
                            </div>
                        </div>
                    <?php
                    } else if ($job_type == "ATD") {
                    ?>
                        <div class="row mt-4">
                            <div class="form-group mb-2 col-md-4">
                                <label for="hourly_charge_rate">Hourly Charge Rate</label>
                                <input type="text" class="form-control" id="hourly_charge_rate" name="hourly_charge_rate" disabled value="<?php echo $hourly_charge_rate; ?>">
                            </div>
                        </div>

                    <?php
                    } else if ($job_type == "CLN") {
                    ?>
                        <div class="row mt-4">
                            <div class="form-group mb-2 col-md-4">
                                <label for="contract_no">Contract No</label>
                                <input type="text" class="form-control" id="contract_no" name="contract_no" disabled value="<?php echo $contract_no; ?>">
                            </div>
                            <div class="form-group mb-2 col-md-4">
                                <label for="start_date">Start Date</label>
                                <input type="text" class="form-control" id="start_date" name="start_date" disabled value="<?php echo $start_date; ?>">
                            </div>
                            <div class="form-group mb-2 col-md-4">
                                <label for="end_date">End Date</label>
                                <input type="text" class="form-control" id="end_date" name="end_date" disabled value="<?php echo $end_date; ?>">
                            </div>
                        </div>
                    <?php
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
                    <button name="btn-save" style="margin-right:20px; margin-left: 0;" class="btn btn-danger" id='btn-save'>Save</button>
                    <a onclick="disableEdit()" class="btn btn-success">Cancel</a>
            `;
                document.getElementById('v_name').disabled = false;
                document.getElementById('v_address').disabled = false;
                document.getElementById('v_contact_no').disabled = false;
                document.getElementById('gr1').disabled = false;
                document.getElementById('gr2').disabled = false;
                try {
                    document.getElementById('dea_no').disabled = false;
                    document.getElementById('speciality').disabled = false;
                    document.getElementById('medC_reg_no').disabled = false;
                    document.getElementById('medC_joined_date').disabled = false;
                    document.getElementById('medC_resigned_date').disabled = false;
                } catch {
                    try {
                        document.getElementById('n_medC_reg_no').disabled = false;
                        document.getElementById('n_medC_joined_date').disabled = false;
                        document.getElementById('n_medC_resigned_date').disabled = false;
                    } catch {
                        try {
                            document.getElementById('hourly_charge_rate').disabled = false;
                        } catch {
                            document.getElementById('contract_no').disabled = false;
                            document.getElementById('start_date').disabled = false;
                            document.getElementById('end_date').disabled = false;
                        }
                    }
                }


            }

            function disableEdit() {
                document.getElementById('v_name').disabled = true;
                document.getElementById('v_address').disabled = true;
                document.getElementById('v_contact_no').disabled = true;
                document.getElementById('gr1').disabled = true;
                document.getElementById('gr2').disabled = true;
                try {
                    document.getElementById('dea_no').disabled = true;
                    document.getElementById('speciality').disabled = true;
                    document.getElementById('medC_reg_no').disabled = true;
                    document.getElementById('medC_joined_date').disabled = true;
                    document.getElementById('medC_resigned_date').disabled = true;
                } catch {
                    try {
                        document.getElementById('n_medC_reg_no').disabled = true;
                        document.getElementById('n_medC_joined_date').disabled = true;
                        document.getElementById('n_medC_resigned_date').disabled = true;
                    } catch {
                        try {
                            document.getElementById('hourly_charge_rate').disabled = true;
                        } catch {
                            document.getElementById('contract_no').disabled = true;
                            document.getElementById('start_date').disabled = true;
                            document.getElementById('end_date').disabled = true;
                        }
                    }
                }

                location.reload();
            }
        </script>
    </div>
</div>