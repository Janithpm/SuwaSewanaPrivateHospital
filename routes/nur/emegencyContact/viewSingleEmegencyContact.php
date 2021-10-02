<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/session.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/titleBox.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/inputElement.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/buttonElement.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');

$USER = getSessionData();

if (isset($_GET['btn-select'])) {
    $values = explode(" ", $_GET['btn-select']);
    $patientID = $values[0];
    $first_name = $values[1];
    $last_name = $values[2];

    $sq = "SELECT relationship, contact_no, address FROM emegency_contact WHERE (patientID = $patientID AND first_name = '$first_name' AND last_name = '$last_name')";
    $result = mysqli_query($conn, $sq);
    if (!$result) echo "patient" . $conn->error;
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $relationship = $row['relationship'];
        $contact_no = $row['contact_no'];
        $address = $row['address'];
    }


    if (isset($_POST['btn-update-Emegeny-contact'])) {
        $ec_first_name = textBoxValue('first_name');
        $ec_last_name = textBoxValue('last_name');
        $ec_relationship = textBoxValue('ec_relationship');
        $ec_contact_no = textBoxValue('ec_contact_no');
        $ec_address = textBoxValue('ec_address');

        $sq = "UPDATE emegency_contact SET first_name= '$ec_first_name', last_name= '$ec_last_name', relationship= '$ec_relationship', contact_no= '$ec_contact_no', address = '$ec_address' WHERE (patientID = $patientID AND first_name = '$first_name' AND last_name = '$last_name')";

        if (!mysqli_query($conn, $sq)) echo $conn->error;
        else header("Location: emegencyContact.php");
    }


    if (isset($_POST['btn-delete-Emegeny-contact'])) {
        $sq = "DELETE FROM emegency_contact WHERE (patientID = $patientID AND first_name = '$first_name' AND last_name = '$last_name')";
        if (!mysqli_query($conn, $sq)) echo $conn->error;
        else header("Location: emegencyContact.php");
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
            <?php titleBox("DASHBOARD : NURSE", $USER['usr_name'], "Hello, Welcome Back", $USER['employeeID'], "dark", "../../../config/logout.php", "../nur.php", true); ?>

            <div class="card mt-3 shadow">
                <h5 class="card-header">Emegency Contact Edit</h5>
                <div class="card-body">
                    <?php

                    if (!$result) {
                    ?>
                        <div class="d-flex align-items-center justify-content-center" style="min-height:400px; width:100%;">
                            <h1 class="h1 text-center">No Contact was found</h1>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="d-flex justify-content-end">

                            <a onclick="enableEditEC()" class="btn btn-success" style="margin: 0 15px;">Edit Details</a>
                            <a href="emegencyContact.php" class="btn btn-primary">Go Back</a>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <form action="" method="post" class="w-100">
                                <div class="form-group mb-3">
                                    <label for="name">Patient ID</label>
                                    <input type="text" name="patientID" class="form-control" id="ec_patientID" value="<?php echo $patientID; ?>" disabled>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Emegency Contact First Name</label>
                                    <input type="text" name="first_name" class="form-control" id="ec_first_name" value="<?php echo $first_name; ?>" disabled>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Emegency Contact Last Name</label>
                                    <input type="text" name="last_name" class="form-control" id="ec_last_name" value="<?php echo $last_name; ?>" disabled>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Relationship</label>
                                    <input type="text" name="ec_relationship" class="form-control" id="ec_relationship" value="<?php echo $relationship; ?>" disabled>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Contact Number</label>
                                    <input type="text" name="ec_contact_no" class="form-control" id="ec_contact_no" value="<?php echo $contact_no; ?>" disabled>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Address</label>
                                    <input type="text" name="ec_address" class="form-control" id="ec_address" value="<?php echo $address; ?>" disabled>
                                </div>


                                <?php buttonElement("btn-add-Emegeny-contact", "btn btn-primary", "Save", "btn-update-Emegeny-contact", "") ?>
                                <?php buttonElement("btn-delete-Emegeny-contact", "btn btn-danger", "Delete Contact", "btn-delete-Emegeny-contact", "") ?>
                            </form>
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

<script>
    function enableEditEC() {
        // document.getElementById('ec_patientID').disabled = false;
        document.getElementById('ec_first_name').disabled = false;
        document.getElementById('ec_last_name').disabled = false;
        document.getElementById('ec_relationship').disabled = false;
        document.getElementById('ec_contact_no').disabled = false;
        document.getElementById('ec_address').disabled = false;

    }
</script>

</html>