<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/session.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/titleBox.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/inputElement.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/buttonElement.php');
date_default_timezone_set('Asia/Colombo');
$USER = getSessionData();


if (isset($_POST['btn-discharge'])) {
    if (isset($_GET['id'])) {
        $values = explode(" ", $_GET['id']);
        $patient_type = $values[0];
        $patinetID = $values[1];

        $discharged_date = date("Y-m-d");
        $discharged_time = date("h:i:sa");

        $sq =  "UPDATE in_patient SET discharged_date = '$discharged_date', discharged_time = '$discharged_time' WHERE patientID = $patinetID";

        if (mysqli_query($conn, $sq)) {
?>
            <script>
                alert("Patient ID<?php echo $paitentID ?>\n Dischage Date - Time : <?php echo $discharge_date . " " . $discharge_time ?>")
            </script>
        <?php
        } else {
            echo $conn->error;
        }
    }
}


if (isset($_POST['btn-admit'])) {
    if (isset($_GET['id'])) {
        $values = explode(" ", $_GET['id']);
        $patient_type = $values[0];
        $patientID = $values[1];

        $docID = $_SESSION['employeeID'];

        $sq =  "INSERT INTO patient_admit VALUES ($patientID, $docID)";
        if (mysqli_query($conn, $sq)) {

            $admit
        ?>
            <script>
                alert("Patient ID<?php echo $paitentID ?>\n Admited_by : <?php echo $DocID ?>")
            </script>
<?php
        } else {
            echo $conn->error;
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

    <!-- <script src="sections/addNewEmp.js" defer></script> -->
    <!-- <script src="sections/viewEmp.js" defer></script> -->
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
            <div id="viewReport">
                <?php include('viewReport.php') ?>
            </div>
            <div id="discharge" style="display: none">
                <?php include('discharge.php') ?>
            </div>
            <div id="admit" style="display:none">
                <?php include('admit.php') ?>
            </div>

            <div style="width:100%; height:50px;"></div>
        </div>

    </main>
</body>

</html>