<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/inputElement.php');
date_default_timezone_set("Asia/Colombo");
if (isset($_POST['btn-add-patient'])) {

    $patient_name = textboxValue("patient_name");
    $patient_type = textboxValue("patient_type");

    $query = "INSERT INTO patient (name, type) VALUES ('$patient_name', '$patient_type')";
    if (mysqli_query($conn, $query)) {

        $sq = "SELECT patientID from patient ORDER BY patientID DESC LIMIT 1";
        $result = mysqli_query($conn, $sq);
        $row = mysqli_fetch_array($result);

        if (mysqli_num_rows($result) > 0) {
            $patientID = $row['patientID'];

            if ($patient_type == 'IN') {
                $patient_bedID = textboxValue("patient_bedID");
                $patient_wordID = textboxValue("patient_wordID");
                $patient_dob = textboxValue("patient_dob");
                $patient_admit_by = textboxValue("patient_admit_by");
                $admited_date = textboxValue("admited_date") ? textboxValue("admited_date") : date("Y-m-d");
                $admited_time = textboxValue("admited_time") ? textboxValue("admited_time") : date("h:i:sa");
                $query = "INSERT INTO in_patient (patientID, dob, bedID) VALUES ($patientID,'$patient_dob', $patient_bedID)";
                $sq1 = "INSERT INTO patient_assign_to (patientID, wordID, admit_date, admit_time) VALUES ($patientID, $patient_wordID, '$admited_date', '$admited_time')";
                $sq2 = "INSERT INTO patient_admit VALUES ($patientID, $patient_admit_by)";
                if (mysqli_query($conn, $query)) {
                    if (mysqli_query($conn, $sq1)) {
                        if (mysqli_query($conn, $sq2)) {
?>
                            <script>
                                alert("New In Patient added Successfully\nPatient ID : <?php echo $patientID; ?>\nPatient Name : <?php echo $patient_name; ?>")
                            </script>
                    <?php
                        } else {
                            echo $conn->error;
                        }
                    } else {
                        echo $conn->error;
                    }
                } else {
                    echo $conn->error;
                }
            } else if ($patient_type == 'OUT') {
                $arrived_date = textboxValue("arrived_date") ? textboxValue("arrived_date") : date("Y-m-d");
                $arrived_time = textboxValue("arrived_time") ? textboxValue("arrived_time") : date("h:i:sa");
                $query = "INSERT INTO out_patient (patientID, arrived_date, arrived_time) VALUES ($patientID, '$arrived_date', '$arrived_time')";


                if (mysqli_query($conn, $query)) {
                    ?>
                    <script>
                        alert("New Out Patient added Successfully\nPatient ID : <?php echo $patientID; ?>\nPatient Name : <?php echo $patient_name; ?>")
                    </script>
<?php
                } else {
                    echo "error" . $conn->error;
                }
            }
        }
    } else {
        echo "error" . $conn->error;
    }
}

?>
<div class="card mt-3 shadow">
    <h5 class="card-header">ADD NEW NEW PATIENT</h5>
    <div class="card-body">
        <h5 class="card-title">Enter The Details Of New Patient : </h5>
        <div class="d-flex justify-content-center mt-3">
            <form action="" method="post" class="w-100">
                <div class="pt-2">
                    <?php inputElement("patient_name", "text", "Patient Name", "", ""); ?>
                </div>

                <div class="pt-2">
                    <legend class="col-form-label pt-0">Working Status</legend>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="patient_type" id="gridRadios1" value="OUT" onclick="outP()">
                        <label class="form-check-label" for="gridRadios1">
                            Out Patinet
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="patient_type" id="gridRadios2" value="IN" onclick="inP()">
                        <label class="form-check-label" for="gridRadios2">
                            In Patient
                        </label>
                    </div>
                </div>


                <div class="pt-3 mt-3" id="addNewPatinetAdditional"></div>

                <?php buttonElement("btn-add-patient", "btn btn-primary", "Submit", "btn-add-patient", "") ?>
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

    function inP() {
        document.getElementById("addNewPatinetAdditional").innerHTML = `
    <div class="row">

        <div class="form-group mb-2 col-md-4">
            <label for="patient_dob">Patient Date Of Birth</label>
            <input type="text" class="form-control" id="patient_dob" name="patient_dob">
        </div>
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
            <label for="speciality">Admited By ( Doctor's Employee ID )</label>
            <input type="text" class="form-control" id="patient_admit_by" name="patient_admit_by">
        </div>
        <div class="form-group mb-2 col-md-4">
            <label for="medC_reg_no">Admitted Date</label>
            <input type="text" class="form-control" id="admited_date" name="admited_date" placeholder="Default : Today">
        </div>
        <div class="form-group mb-2 col-md-4">
            <label for="medC_joined_date">Admitted Time</label>
            <input type="text" class="form-control" id="admited_time" name="admited_time" placeholder="Default : Now">
        </div>
    </div>
    `;
    }

    function outP() {
        document.getElementById("addNewPatinetAdditional").innerHTML = `
    <div class="row">
        <div class="form-group mb-2 col-md-4">
            <label for="medC_reg_no">Arrvied Date</label>
            <input type="text" class="form-control" id="arrived_date" name="arrived_date">
        </div>
        <div class="form-group mb-2 col-md-4">
            <label for="medC_joined_date">Arrvied Time</label>
            <input type="text" class="form-control" id="arrived_time" name="arrived_time">
        </div>
    </div>
    `;
    }
</script>