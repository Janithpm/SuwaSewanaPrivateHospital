<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');

if (isset($_POST['btn-search'])) {
    $id = textBoxValue('supply_search');
    $sq = "SELECT drugCode FROM supply WHERE drugCode = '$id'";
    $result = mysqli_query($conn, $sq);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
        $drugCode = $row['drugCode'];
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
                    <input type="text" name="supply_search" class="form-control rounded" placeholder="Search Supply : Drug Code" aria-label="Search" aria-describedby="search-addon" />
                    <button name="btn-search" value="btn-search" class="btn btn-outline-primary">search</button>
                </div>
                <div class="input-group w-50 col-md-6 d-flex justify-content-end">
                    <a onclick="displayAddNewSupply()" class="btn btn-success"> + Add New Supply</a>
                </div>
            </div>
        </form>
        </br>
        <?php

        if (!isset($id)) {
        ?>
            <div class="d-flex align-items-center justify-content-center" style="min-height:400px; width:100%;">
                <h1 class="h1">SEARCH FOR SUPPLIES ...</h1>
            </div>
        <?php
        } else if ($id == 0) {
        ?>
            <div class="d-flex align-items-center justify-content-center" style="min-height:400px; width:100%;">
                <h1 class="h1 text-center">SORRY,<br>There is no Supply with that Drug Code. <br> Try Again !</h1>
            </div>

        <?php
        } else {
        ?>
            <hr>
            <div class="d-flex justify-content-center mt-3">
                <form action="veiwSingleSupply.php" method="get" class="w-100 flex-column align-items-center d-flex justify-content-center">
                    <div class="d-flex justify-content-between">
                        <h5 class="h5">Search Result : Drug Code : <?php echo isset($id) ? $drugCode : ""; ?></h5>
                    </div>
                    <br>
                    <?php
                    $sq = "SELECT drugCode, regNo, supply_date FROM supply WHERE drugCode = '$id'";

                    $result = mysqli_query($conn, $sq);
                    if (!$result) echo $conn->error;
                    if (mysqli_num_rows($result) > 0) {
                    ?>
                        <table class="table table-hover w-75">
                            <thead class=" text-center text-light bg-dark">
                                <tr>
                                    <th scope="col">Drug Code</th>
                                    <th scope="col">Vendor Register Number</th>
                                    <th scope="col">Supply Date</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <tr>
                                        <td scope="col"><?php echo $row['drugCode']; ?></td>
                                        <td scope="col"><?php echo $row['regNo']; ?></td>
                                        <td scope="col"><?php echo $row['supply_date']; ?></td>
                                        <td>
                                            <button name="btn-select" onclick="displayReport()" class="btn btn-primary" value="<?php echo $row['drugCode'] . " " . $row['regNo'] . " " . $row['supply_date']; ?>">View</button>
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
            function displayAddNewSupply() {
                document.getElementById('addNewSupply').style = 'display: block';
                document.getElementById('viewSupply').style = 'display: none';
            }
        </script>
    </div>
</div>