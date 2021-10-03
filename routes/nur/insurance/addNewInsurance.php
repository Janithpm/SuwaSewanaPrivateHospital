<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');

if (isset($_POST['btn-add-next'])) {
    $query = " ";

    $patientID = textBoxValue('patientID');
    $insurance_no = textBoxValue('insurance_no');
    $company_name = textBoxValue('company_name');
    $branch_name = textBoxValue('branch_name');
    $contact_no = textBoxValue('contact_no');
    $branch_address = textBoxValue('branch_address');
    $sub_fname = textBoxValue('sub_fname') ? textBoxValue('sub_fname') : "";
    $sub_lname = textBoxValue('sub_lname') ? textBoxValue('sub_lname') : "";
    $sub_relationship = textBoxValue('sub_relationship') ? textBoxValue('sub_relationship') : "";
    $sub_contact_no = textBoxValue('sub_contact_no') ? textBoxValue('sub_contact_no') : "";
    $sub_address = textBoxValue('sub_address') ? textBoxValue('sub_address') : "";

    $sq = "INSERT INTO insurance VALUES ($patientID, '$insurance_no', '$company_name', '$branch_name', '$contact_no', '$branch_address', '$sub_fname', '$sub_lname', '$sub_relationship', '$sub_contact_no', '$sub_address')";
    if (mysqli_query($conn, $sq)) {
?>
        <script>
            alert("New Insurance Details added Successfully\nPatient ID : <?php echo $patientID; ?>\n")
        </script>
<?php

    } else {
        echo "error" . $conn->error;
    }
}

?>
<div class="card mt-3 shadow">
    <h5 class="card-header">ADD NEW INSURANCE DETAILS</h5>
    <div class="card-body">
        <h5 class="card-title">Enter The Details Of New Insurance Details : </h5>
        <div class="d-flex justify-content-center mt-3">
            <form action="" method="post" class="w-100">
                <div class="pt-2">
                    <?php inputElement("patientID", "text", "Patient ID", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("insurance_no", "text", "Insurance Number", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("company_name", "text", "Company Name", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("branch_name", "text", "Branch Name", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("contact_no", "text", "Contact Number", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("branch_address", "text", "Branch Address", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("sub_fname", "text", "Subscriber First Name", "Optional", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("sub_lname", "text", "Subscriber Last Name", "Optional", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("sub_relationship", "text", "Subscriber Relationship", "Optional", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("sub_contact_no", "text", "Subscriber Contact Number", "Optional", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("sub_address", "text", "Subscriber Address", "Optional", ""); ?>
                </div>

                <?php buttonElement("btn-submit", "btn btn-primary", "Submit", "btn-add-next", "") ?>
                <a onclick="displayViewEmp()" class="btn btn-danger">Cancel</a>

            </form>
        </div>
    </div>
</div>

<script>
    function displayViewEmp() {
        document.getElementById('addNewInsurance').style = 'display: none';
        document.getElementById('viewInsurance').style = 'display: block';

    }
</script>