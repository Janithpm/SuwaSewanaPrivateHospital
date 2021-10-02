<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');

if (isset($_POST['btn-search'])) {
    $id = textBoxValue('ec_search');
    $sq = "SELECT patientID FROM emegency_contact WHERE patientID = '$id'";
    $result = mysqli_query($conn, $sq);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
        $patientID = $row['patientID'];
    } else if (mysqli_num_rows($result) == 0) {
        $id = 0;
    } else {
        echo $conn->error;
    }
}


?>


<div class="card mt-3 shadow">
    <h5 class="card-header">VIEW EMEGENCY CONTACT</h5>
    <div class="card-body">
        <form method="post" action="" class="d-flex justify-content-start">
            <div class="row w-100">
                <div class="input-group col-md-6 w-50">
                    <input type="text" name="ec_search" class="form-control rounded" placeholder="Search Paitent : Patient ID" aria-label="Search" aria-describedby="search-addon" />
                    <button name="btn-search" value="btn-search" class="btn btn-outline-primary">search</button>
                </div>
                <div class="input-group w-50 col-md-6 d-flex justify-content-end">
                    <a onclick="displayAddNewEC()" class="btn btn-primary " style="margin-right: 10px"> + Add New Emegency Contact</a>
                </div>
            </div>
        </form>
        </br>
        <?php

        if (!isset($id)) {
        ?>
            <div class="d-flex align-items-center justify-content-center" style="min-height:400px; width:100%;">
                <h1 class="h1">SEARCH FOR PATIENT EMEGENCY CONTACT ...</h1>
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
                <form action="viewSingleEmegencyContact.php" method="get" class="w-100 flex-column align-items-center d-flex justify-content-center">
                    <div class="d-flex justify-content-between">
                        <h5 class="h5">Patient ID : <?php echo isset($id) ? $patientID : ""; ?></h5>
                    </div>
                    <h6 class="h6 pt-2 pb-2">( IN Patient )</h6>
                    <?php
                    $sq = "SELECT * FROM emegency_contact WHERE patientID = $patientID";

                    $result = mysqli_query($conn, $sq);
                    if (!$result) echo $conn->error;
                    if (mysqli_num_rows($result) > 0) {
                    ?>
                        <table class="table table-hover w-85">
                            <thead class=" text-center text-light bg-dark">
                                <tr>
                                    <th scope="col">Patient ID</th>
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Last Name</th>
                                    <th scope="col">Relationship</th>
                                    <th scope="col">Contact Number</th>
                                    <th scope="col">Address</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <tr>
                                        <td scope="col"><?php echo $row['patientID']; ?></td>
                                        <td scope="col"><?php echo $row['first_name']; ?></td>
                                        <td scope="col"><?php echo $row['last_name']; ?></td>
                                        <td scope="col"><?php echo $row['relationship']; ?></td>
                                        <td scope="col"><?php echo $row['contact_no']; ?></td>
                                        <td scope="col"><?php echo $row['address']; ?></td>
                                        <td>
                                            <button name="btn-select" onclick="displayReport()" class="btn btn-primary" value="<?php echo $row['patientID'] . " " . $row['first_name'] . " " . $row['last_name']; ?>">Edit / Delete</button>
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
            function displayAddNewEC() {
                document.getElementById('addNewEmegencyContact').style = 'display: block';
                document.getElementById('viewEmegencyContact').style = 'display: none';
            }


            function displayReport() {
                document.getElementById('viewSingleReport').style = 'display: block';
                document.getElementById('viewReport').style = 'display: none';
            }
        </script>
    </div>
</div>