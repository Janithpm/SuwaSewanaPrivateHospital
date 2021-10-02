<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/inputElement.php');

if (isset($_POST['btn-add-Emegeny-contact'])) {
    $query = "";

    $patientID = textboxValue("patientID");
    $ec_fname = textboxValue("ec_fname");
    $ec_lname = textboxValue("ec_lname");
    $ec_relationship = textboxValue("ec_relationship");
    $ec_contact_no = textboxValue("ec_contact_no");
    $ec_address = textboxValue("ec_address");

    $query = "INSERT INTO emegency_contact VALUES ($patientID, '$ec_fname', '$ec_lname', '$ec_relationship', '$ec_contact_no', '$ec_address')";
    if (mysqli_query($conn, $query)) {

?>
        <script>
            alert("New Emegency Contact added Successfully\nDPatient ID : <?php echo $patientID; ?>\nCotact Name : <?php echo $ec_fname . " " . $ec_lname; ?>")
        </script>
<?php

    } else {
        echo "error" . $conn->error;
    }
}

?>
<div class="card mt-3 shadow">
    <h5 class="card-header">ADD NEW NEW EMEGNECY CONSTACT</h5>
    <div class="card-body">
        <h5 class="card-title">Enter The Details Of New Emegency Contact : </h5>
        <div class="d-flex justify-content-center mt-3">
            <form action="" method="post" class="w-100">
                <div class="pt-2">
                    <?php inputElement("patientID", "text", "Patient ID", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("ec_fname", "text", "First Name", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("ec_lname", "text", "Last Name", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("ec_relationship", "text", "Relationship", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("ec_contact_no", "text", "Contact Number", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("ec_address", "text", "Address", "", ""); ?>
                </div>


                <?php buttonElement("btn-add-Emegeny-contact", "btn btn-primary", "Submit", "btn-add-Emegeny-contact", "") ?>
                <a onclick="displayViewEmeContact()" class="btn btn-danger">Cancel</a>

            </form>
        </div>
    </div>
</div>

<script>
    function displayViewEmeContact() {
        document.getElementById('addNewEmegencyContact').style = 'display: none';
        document.getElementById('viewEmegencyContact').style = 'display: block';
    }
</script>