<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');


if (isset($_POST['btn-search'])) {

    $id = textBoxValue('insurance_search');
    $sq = "SELECT * FROM insurance WHERE patientID = '$id'";
    $result = mysqli_query($conn, $sq);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
        $patientID = $row['patientID'];
        $_SESSION['patientID'] = $patientID;
        $insurance_no = $row['insurance_no'];
        $company_name = $row['company_name'];
        $branch_name = $row['branch_name'];
        $contact_no = $row['contact_no'];
        $branch_address = $row['branch_address'];
        $sub_fname = $row['sub_fname'];
        $sub_lname = $row['sub_lname'];
        $sub_relationship = $row['sub_relationship'];
        $sub_contact_no = $row['sub_contact_no'];
        $sub_address = $row['sub_address'];
    } else if (mysqli_num_rows($result) == 0) {
        $id = 0;
    } else {
        echo $conn->error;
    }
}


if (isset($_POST['btn-save'])) {
    $patientID = (int)$_SESSION['patientID'];
    $insurance_no = textBoxValue('insurance_no');
    $company_name = textBoxValue('company_name');
    $branch_name = textBoxValue('branch_name');
    $contact_no = textBoxValue('contact_no');
    $branch_address = textBoxValue('branch_address');
    $sub_fname = textBoxValue('sub_fname');
    $sub_lname = textBoxValue('sub_lname');
    $sub_relationship = textBoxValue('sub_relationship');
    $sub_contact_no = textBoxValue('sub_contact_no');
    $sub_address = textBoxValue('sub_address');
    $sq = "UPDATE insurance SET insurance_no = '$insurance_no', company_name='$company_name', branch_name='$branch_name', contact_no='$contact_no', branch_address='$branch_address', sub_fname='$sub_fname', sub_lname='$sub_lname', sub_relationship='$sub_relationship', sub_contact_no='$sub_contact_no', sub_address='$sub_address' WHERE patientID = $patientID ";
    if (!mysqli_query($conn, $sq)) {
        echo $conn->error;
    }
}

if (isset($_POST['btn-delete'])) {
    $patientID = $_SESSION['patientID'];
    $sq = "DELETE FROM insurance WHERE patientID = $patientID";
    if (!mysqli_query($conn, $sq)) {
        echo $conn->error;
    }
}

?>

<div class="card mt-3 shadow">
    <h5 class="card-header">VIEW / EDIT / DELETE INSURANCE DETAILS</h5>
    <div class="card-body">
        <form method="post" action="" class="d-flex justify-content-start">
            <div class="row w-100">
                <div class="input-group col-md-6 w-50">
                    <input type="text" name="insurance_search" class="form-control rounded" placeholder="Search Insurance Details : Patient ID" aria-label="Search" aria-describedby="search-addon" />
                    <button name="btn-search" value="btn-search" class="btn btn-outline-primary">search</button>
                </div>
                <div class="input-group w-50 col-md-6 d-flex justify-content-end">
                    <a onclick="displayAddNew()" class="btn btn-primary"> + Add New Insurance Details</a>
                </div>
            </div>
        </form>
        </br>
        <?php

        if (!isset($id)) {
        ?>
            <div class="d-flex align-items-center justify-content-center" style="min-height:400px; width:100%;">
                <h1 class="h1 text-center">SEARCH FOR INSURANCE DETAILS ...</h1>
            </div>
        <?php
        } else if ($id == 0) {
        ?>
            <div class="d-flex align-items-center justify-content-center" style="min-height:400px; width:100%;">
                <h1 class="h1 text-center">SORRY,<br>There is no Insurance Details with given Details. <br> Try Again !</h1>
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
                            <a onclick="enableEdit()" id="btn-edit" class="btn btn-success"> Edit Details</a>
                            <?php buttonElement("btn-delete", "btn btn-danger", " - Delete Insurance Details", "btn-delete", "") ?>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="name">Insurance Number</label>
                            <input type="text" name="insurance_no" class="form-control" id="sub_insurance_no" value="<?php echo $insurance_no; ?>" disabled>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="name">Company Name</label>
                            <input type="text" name="company_name" class="form-control" id="sub_company_name" value="<?php echo $company_name; ?>" disabled>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="address">Branch Name</label>
                            <input type="text" name="branch_name" class="form-control" id="sub_branch_name" value="<?php echo $branch_name; ?>" disabled>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="address">Contact Number</label>
                            <input type="text" name="contact_no" class="form-control" id="sub_int_contact_no" value="<?php echo $contact_no; ?>" disabled>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="name">Branch Address</label>
                            <input type="text" name="branch_address" class="form-control" id="sub_branch_address" value="<?php echo $branch_address; ?>" disabled>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="address">Subscriber First Name</label>
                            <input type="text" name="sub_fname" class="form-control" id="sub_int_fname" value="<?php echo $sub_fname; ?>" disabled>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="address">Subscriber Last Name</label>
                            <input type="text" name="sub_lname" class="form-control" id="sub_int_lname" value="<?php echo $sub_lname; ?>" disabled>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="name">Subscriber Relationship</label>
                            <input type="text" name="sub_relationship" class="form-control" id="sub_int_relationship" value="<?php echo $sub_relationship; ?>" disabled>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="address">Subscriber Contact Number</label>
                            <input type="text" name="sub_contact_no" class="form-control" id="sub_int_contact_no_2" value="<?php echo $sub_contact_no; ?>" disabled>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="address">Subscriber Address</label>
                            <input type="text" name="sub_address" class="form-control" id="sub_int_address" value="<?php echo $sub_address; ?>" disabled>
                        </div>
                    </div>

                    <div class="mt-5" id="edit-cancel-btn"></div>
                </form>
            </div>
        <?php
        }
        ?>

        <script>
            function displayAddNew() {
                document.getElementById('addNewInsurance').style = 'display: block';
                document.getElementById('viewInsurance').style = 'display: none';
            }

            function enableEdit() {
                document.getElementById('edit-cancel-btn').innerHTML = `
                    <button name="btn-save" style="margin-right:20px; margin-left: 0;" class="btn btn-danger" id='btn-save'>Save</button>
                    <a onclick="disableEdit()" class="btn btn-success">Cancel</a>
            `;
                document.getElementById('sub_insurance_no').disabled = false;
                document.getElementById('sub_company_name').disabled = false;
                document.getElementById('sub_branch_name').disabled = false;
                document.getElementById('sub_int_contact_no').disabled = false;
                document.getElementById('sub_branch_address').disabled = false;
                document.getElementById('sub_int_fname').disabled = false;
                document.getElementById('sub_int_lname').disabled = false;
                document.getElementById('sub_int_relationship').disabled = false;
                document.getElementById('sub_int_contact_no_2').disabled = false;
                document.getElementById('sub_int_address').disabled = false;

            }

            function disableEdit() {
                document.getElementById('sub_insurance_no').disabled = true;
                document.getElementById('sub_company_name').disabled = true;
                document.getElementById('sub_branch_name').disabled = true;
                document.getElementById('sub_int_contact_no').disabled = true;
                document.getElementById('sub_branch_address').disabled = true;
                document.getElementById('sub_int_fname').disabled = true;
                document.getElementById('sub_int_lname').disabled = true;
                document.getElementById('sub_int_relationship').disabled = true;
                document.getElementById('sub_int_contact_no_2').disabled = true;
                document.getElementById('sub_int_address').disabled = true;
                location.reload();
            }
        </script>
    </div>
</div>