<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');


if (isset($_POST['btn-add-next'])) {
    $query = " ";

    $name = textboxValue("name");
    $address = textboxValue("address");
    $contact_no = textboxValue("contact_no");
    $contact_no = textboxValue("contact_no");
    $working_status = $_POST["working_status"];
    $job_type = $_POST["job_type"];

    if ($job_type == "DOC" || $job_type == "NUR") $type = "MED_STAFF";
    else $type = "NON_MED_STAFF";

    $sq = "INSERT INTO employee (name, working_status, contact_no, address, type, job_type) VALUES ('$name','$working_status','$contact_no','$address','$type','$job_type')";
    if (mysqli_query($conn, $sq)) {

        $sq2 = "SELECT employeeID, type from employee ORDER BY employeeID DESC LIMIT 1";
        $result = mysqli_query($conn, $sq2);
        $row = mysqli_fetch_array($result);

        if (mysqli_num_rows($result) > 0) {

            $employeeID = $row['employeeID'];
?>
            <script>
                alert("New Employee added Successfully\nName : <?php echo $name; ?>\nEmployee ID : <?php echo $employeeID; ?>\nLogin credentials are employee ID and Contact Number")
            </script>
            <?php
            if ($type == "MED_STAFF") {
                $medC_reg_no = textboxValue("medC_reg_no");
                $medC_joined_date = textboxValue("medC_joined_date");
                $medC_resigned_date = textboxValue("medC_resigned_date");
                if ($job_type == "DOC") {
                    $DEA_no = textboxValue("dea_no");
                    $speciality = textboxValue("speciality");
                    $query = "INSERT INTO doctor VALUES ($employeeID, '$DEA_no', '$speciality', '$medC_reg_no', '$medC_joined_date', '$medC_resigned_date')";
                } else if ($job_type == "NUR") {
                    $query = "INSERT INTO nurse VALUES ($employeeID,'$medC_reg_no', '$medC_joined_date', '$medC_resigned_date')";
                }
            } else if ($type == "NON_MED_STAFF") {
                if ($job_type == "ATD") {
                    $hourly_charge_rate = (float)textboxValue("hourly_charge_rate");
                    $query = "INSERT INTO attendent VALUES ($employeeID, $hourly_charge_rate)";
                } else if ($job_type == "CLN") {
                    $contract_no = textboxValue("contract_no");
                    $start_date = textboxValue("start_date");
                    $end_date = textboxValue("end_date");
                    $query = "INSERT INTO cleaner VALUES ($employeeID,'$contract_no', '$start_date', '$end_date')";
                }
            }
            if ($job_type != "MANG") {
                if (mysqli_query($conn, $query)) {
            ?>
                    <script>
                        addNewEmpSuccessfull()
                        alert("add new")
                    </script>
<?php
                } else {
                    echo "error " . $conn->error;
                }
            }
        } else {
            echo "error" . $conn->error;
        }
    } else {
        echo "error" . $conn->error;
    }
}

?>
<div class="card mt-3 shadow">
    <h5 class="card-header">ADD NEW EMPLOYEE</h5>
    <div class="card-body">
        <h5 class="card-title">Enter The Basic Details Of New Employee : </h5>
        <div class="d-flex justify-content-center mt-3">
            <form action="" method="post" class="w-100">
                <div class="pt-2">
                    <?php inputElement("name", "text", "Employee Name", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("address", "text", "Employee Address", "", ""); ?>
                </div>
                <div class="row pt-2">
                    <div class="col-md-6">
                        <?php inputElement("contact_no", "text", "Employee Contact Number", "", ""); ?>
                    </div>
                    <div class="col-md-6">
                        <legend class="col-form-label pt-0">Working Status</legend>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="working_status" id="gridRadios1" value="F">
                            <label class="form-check-label" for="gridRadios1">
                                Full Time
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="working_status" id="gridRadios2" value="P">
                            <label class="form-check-label" for="gridRadios2">
                                Part Time
                            </label>
                        </div>
                    </div>
                </div>
                <div class="pt-3">
                    <fieldset class="form-group">
                        <div class="row w-75">
                            <div class="col-md-6">
                                <legend class="col-form-label pt-0">Medical Staff</legend>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="job_type" id="gridRadios1" value="DOC" onclick="doc()">
                                    <label class="form-check-label" for="gridRadios1">
                                        Doctor
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="job_type" id="gridRadios2" value="NUR" onclick="nur()">
                                    <label class="form-check-label" for="gridRadios2">
                                        Nurse
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <legend class="col-form-label pt-0">Non Medical Staff</legend>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="job_type" id="gridRadios2" value="MANG" onclick="mang()">
                                    <label class="form-check-label" for="gridRadios2">
                                        Management
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="job_type" id="gridRadios4" value="ATD" onclick="atd()">
                                    <label class="form-check-label" for="gridRadios2">
                                        Attendent
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="job_type" id="gridRadios5" value="CLN" onclick="cln()">
                                    <label class="form-check-label" for="gridRadios2">
                                        Cleaner
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="pt-3 mt-3" id="addNewEmpAdditional"></div>
                <?php buttonElement("btn-add-next", "btn btn-primary", "Submit", "btn-add-next", "") ?>
                <a onclick="displayViewEmp()" class="btn btn-danger">Cancel</a>

            </form>
        </div>
    </div>
</div>

<script>
    function displayViewEmp() {
        document.getElementById('addNewEmp').style = 'display: none';
        document.getElementById('viewEmp').style = 'display: block';

    }

    function doc() {
        document.getElementById("addNewEmpAdditional").innerHTML = `
    <div class="row">
        <div class="form-group mb-2 col-md-4">
            <label for="dea_no">DEA No</label>
            <input type="text" class="form-control" id="dea_no" name="dea_no">
        </div>
        <div class="form-group mb-2 col-md-4">
            <label for="speciality">speciality</label>
            <input type="text" class="form-control" id="speciality" name="speciality">
        </div>
    </div>
    <div class="row">
        <div class="form-group mb-2 col-md-4">
            <label for="medC_reg_no">Medical Council Registration No</label>
            <input type="text" class="form-control" id="medC_reg_no" name="medC_reg_no">
        </div>
        <div class="form-group mb-2 col-md-4">
            <label for="medC_joined_date">Joined Date</label>
            <input type="text" class="form-control" id="medC_joined_date" name="medC_joined_date">
        </div>
        <div class="form-group mb-2 col-md-4">
            <label for="medC_resigned_date">Resigned Date</label>
            <input type="text" class="form-control" id="medC_resigned_date" name="medC_resigned_date">
        </div>
    </div>
    `;
    }

    function nur() {
        document.getElementById("addNewEmpAdditional").innerHTML = `
    <div class="row">
        <div class="form-group mb-2 col-md-4">
            <label for="medC_reg_no">Medical Council Registration No</label>
            <input type="text" class="form-control" id="medC_reg_no" name="medC_reg_no">
        </div>
        <div class="form-group mb-2 col-md-4">
            <label for="medC_joined_date">Joined Date</label>
            <input type="text" class="form-control" id="medC_joined_date" name="medC_joined_date">
        </div>
        <div class="form-group mb-2 col-md-4">
            <label for="medC_resigned_date">Resigned Date</label>
            <input type="text" class="form-control" id="medC_resigned_date" name="medC_resigned_date">
        </div>
    </div>
    `;
    }

    function atd() {
        document.getElementById("addNewEmpAdditional").innerHTML = `
    <div class="row">
        <div class="form-group mb-2 col-md-4">
            <label for="hourly_charge_rate">Hourly Charge Rate</label>
            <input type="text" class="form-control" id="hourly_charge_rate" name="hourly_charge_rate">
        </div>
    </div>
    `;
    }


    function cln() {
        document.getElementById("addNewEmpAdditional").innerHTML = `
    <div class="row">
        <div class="form-group mb-2 col-md-4">
            <label for="contract_no">Contract No</label>
            <input type="text" class="form-control" id="contract_no" name="contract_no">
        </div>
        <div class="form-group mb-2 col-md-4">
            <label for="start_date">Start Date</label>
            <input type="text" class="form-control" id="start_date" name="start_date">
        </div>
        <div class="form-group mb-2 col-md-4">
            <label for="end_date">End Date</label>
            <input type="text" class="form-control" id="end_date" name="end_date">
        </div>
    </div>
    `;
    }

    function mang() {
        document.getElementById("addNewEmpAdditional").innerHTML = "";
    }
</script>