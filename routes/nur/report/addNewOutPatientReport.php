<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/inputElement.php');

if (isset($_POST['btn-add-out-patient-report'])) {

    $query = "";
    $patientID = textboxValue("patientID");
    $recorded_by = textboxValue("recorded_by");
    $recorded_date = textboxValue("recorded_date");
    $recorded_time = textboxValue("recorded_time");
    $patient_pulse = textboxValue("patient_pulse");
    $patient_blood_presure = textboxValue("patient_blood_presure");
    $patinet_weight = textboxValue("patient_weight");
    $patient_temperature = textboxValue("patient_temperature");
    $patient_symptoms = textboxValue("patient_symptoms");

    $query = "INSERT INTO out_patient_record (patientID, recorded_date, recorded_time, pulse, blood_presure, weight, temperature, symptoms, recorded_by) VALUES ($patientID, '$recorded_date', '$recorded_time', $patient_pulse, $patient_blood_presure, $patinet_weight, $patient_temperature, '$patient_symptoms', $recorded_by )";
    if (mysqli_query($conn, $query)) {
?>
        <script>
            alert("Record added Successfully\nDPatient ID : <?php echo $patientID; ?>")
        </script>
<?php

    } else {
        echo "error" . $conn->error;
    }
}

?>
<div class="card mt-3 shadow">
    <h5 class="card-header">ADD NEW OUT PATIENT REPORT</h5>
    <div class="card-body">
        <h5 class="card-title">Enter The Details : </h5>
        <div class="d-flex justify-content-center mt-3">
            <form action="" method="post" class="w-100">
                <div class="row">
                    <div class="pt-2 col-md-6">
                        <?php inputElement("patientID", "text", "Patient ID", "", ""); ?>
                    </div>
                    <div class="pt-2 col-md-6">
                        <?php inputElement("recorded_by", "text", "Recorded By", "", ""); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="pt-2 col-md-6">
                        <?php inputElement("recorded_date", "text", "Recorded Date", "", ""); ?>
                    </div>
                    <div class="pt-2 col-md-6">
                        <?php inputElement("recorded_time", "text", "Recorded Time", "", ""); ?>
                    </div>
                </div>
                <br>
                <h5 class="h5"></h5>
                <hr>
                <div class="row">
                    <div class="pt-2 col-md-3">
                        <?php inputElement("patient_pulse", "text", "Pulse", "", ""); ?>
                    </div>
                    <div class="pt-2 col-md-3">
                        <?php inputElement("patient_blood_presure", "text", "Blood Presure", "", ""); ?>
                    </div>
                    <div class="pt-2 col-md-3">
                        <?php inputElement("patient_weight", "text", "Weight", "", ""); ?>
                    </div>
                    <div class="pt-2 col-md-3">
                        <?php inputElement("patient_temperature", "text", "Temperature", "", ""); ?>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="form-group mb-3">
                        <label for='patient_symptoms'>Symptoms</label>
                        <textArea rows="5" cols="100" id="patient_symptoms" name='patient_symptoms' class="form-control" id='patient_symptoms'></textArea>
                    </div>
                </div>

                <?php buttonElement("btn-add-out-patient-report", "btn btn-primary", "Submit", "btn-add-out-patient-report", "") ?>
                <a onclick="displayViewEmp()" class="btn btn-danger">Cancel</a>

            </form>
        </div>
    </div>
</div>

<script>
    function displayViewEmp() {
        document.getElementById('addNewOutP').style = 'display: none';
        document.getElementById('viewReport').style = 'display: block';
    }
</script>