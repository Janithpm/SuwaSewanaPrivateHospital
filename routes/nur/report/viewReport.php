<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');

if (isset($_POST['btn-search'])) {
    $id = textBoxValue('patient_search');
    $sq = "SELECT patientID, type FROM patient WHERE patientID = '$id' OR name LIKE '$id'";
    $result = mysqli_query($conn, $sq);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
        $patientID = $row['patientID'];
        $patient_type = $row['type'];
    } else if (mysqli_num_rows($result) == 0) {
        $id = 0;
    } else {
        echo $conn->error;
    }
}


?>


<div class="card mt-3 shadow">
    <h5 class="card-header">VIEW PATIENT REPORTS</h5>
    <div class="card-body">
        <form method="post" action="" class="d-flex justify-content-start">
            <div class="row w-100">
                <div class="input-group col-md-6 w-50">
                    <input type="text" name="patient_search" class="form-control rounded" placeholder="Search Paitent : Patient ID or Name" aria-label="Search" aria-describedby="search-addon" />
                    <button name="btn-search" value="btn-search" class="btn btn-outline-primary">search</button>
                </div>
                <div class="input-group w-50 col-md-6 d-flex justify-content-end">
                    <a onclick="displayAddNewInP()" class="btn btn-primary " style="margin-right: 10px"> + Add New <span class="font-weight-bold">IN Patient</span></a>
                    <a onclick="displayAddNewOutP()" class="btn btn-success"> + Add New <span class="font-weight-bold">OUT Patient</span></a>
                </div>
            </div>
        </form>
        </br>
        <?php

        if (!isset($id)) {
        ?>
            <div class="d-flex align-items-center justify-content-center" style="min-height:400px; width:100%;">
                <h1 class="h1">SEARCH FOR PATIENT REPORT ...</h1>
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
                <form action="veiwSingleReport.php" method="get" class="w-100 flex-column align-items-center d-flex justify-content-center">
                    <div class="d-flex justify-content-between">
                        <h5 class="h5">Patient ID : <?php echo isset($id) ? $patientID : ""; ?></h5>
                    </div>
                    <h6 class="h6 pt-2 pb-2"><?php
                                                echo "( ";
                                                if ($patient_type == "IN") echo "IN Patient";
                                                else if ($patient_type == "OUT") echo "OUT Patient";
                                                else echo "Other";
                                                echo " )"
                                                ?>
                    </h6>
                    <?php
                    $sq = " ";
                    if ($patient_type == "IN") {
                        $sq = "SELECT patientID, recorded_date, recorded_time FROM in_patient_daily_record WHERE patientID = $patientID";
                    } else {
                        $sq = "SELECT patientID, recorded_date, recorded_time FROM out_patient_record WHERE patientID = $patientID";
                    }
                    $result = mysqli_query($conn, $sq);
                    if (!$result) echo $conn->error;
                    if (mysqli_num_rows($result) > 0) {
                    ?>
                        <table class="table table-hover w-75">
                            <thead class=" text-center text-light bg-dark">
                                <tr>
                                    <th scope="col">Patient ID</th>
                                    <th scope="col">Recorded Date</th>
                                    <th scope="col">Recorded Time</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <tr>
                                        <td scope="col"><?php echo $row['patientID']; ?></td>
                                        <td scope="col"><?php echo $row['recorded_date']; ?></td>
                                        <td scope="col"><?php echo $row['recorded_time']; ?></td>
                                        <td>
                                            <button name="btn-select" onclick="displayReport()" class="btn btn-primary" value="<?php echo $patient_type . " " . $row['patientID'] . " " . $row['recorded_date'] . " " . $row['recorded_time']; ?>">View</button>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    <?php
                    } else {
                    ?>
                        <h1 class="h1 text-center">No Record Found</h1>
                    <?php
                    }
                    ?>


                </form>
            </div>
        <?php
        }
        ?>

        <script>
            function displayAddNewInP() {
                document.getElementById('addNewInP').style = 'display: block';
                document.getElementById('viewReport').style = 'display: none';
            }

            function displayAddNewOutP() {
                document.getElementById('addNewOutP').style = 'display: block';
                document.getElementById('viewReport').style = 'display: none';
            }

            function displayReport() {
                document.getElementById('viewSingleReport').style = 'display: block';
                document.getElementById('viewReport').style = 'display: none';
            }
        </script>
    </div>
</div>