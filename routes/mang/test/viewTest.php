<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');


if (isset($_POST['btn-search'])) {

    $id = textBoxValue('test_search');
    $sq = "SELECT * FROM test WHERE testCode = '$id' OR name LIKE '$id'";
    $result = mysqli_query($conn, $sq);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
        $testCode = $row['testCode'];
        $_SESSION['testCode'] = $testCode;
        $test_name = $row['name'];
        $test_cost = $row['cost'];
        $diagnostic_unitID = $row['diagnostic_unitID'];
    } else if (mysqli_num_rows($result) == 0) {
        $id = 0;
    } else {
        echo $conn->error;
    }
}


if (isset($_POST['btn-save'])) {

    $testCode = (int) $_SESSION['testCode'];
    $test_name = textBoxValue('test_name');
    $test_cost = textBoxValue('test_cost');
    $test_diagnostic_unitID = textBoxValue('test_diagnostic_unitID');

    $sq = "UPDATE test SET name='$test_name', cost='$test_cost', diagnostic_unitID='$test_diagnostic_unitID' WHERE testCode = $testCode ";
    if (!mysqli_query($conn, $sq)) {
        echo $conn->error;
    }
}

if (isset($_POST['btn-delete'])) {
    $testCode = $_SESSION['testCode'];
    $sq = "DELETE FROM test WHERE testCode = $testCode";
    if (!mysqli_query($conn, $sq)) {
        echo $conn->error;
    }
}

?>

<div class="card mt-3 shadow">
    <h5 class="card-header">VIEW / EDIT / DELETE TEST</h5>
    <div class="card-body">
        <form method="post" action="" class="d-flex justify-content-start">
            <div class="row w-100">
                <div class="input-group col-md-6 w-50">
                    <input type="text" name="test_search" class="form-control rounded" placeholder="Search Test : Test Code or Test Name " aria-label="Search" aria-describedby="search-addon" />
                    <button name="btn-search" value="btn-search" class="btn btn-outline-primary">search</button>
                </div>
                <div class="input-group w-50 col-md-6 d-flex justify-content-end">
                    <a onclick="displayAddNew()" class="btn btn-primary"> + Add New TEST</a>
                </div>
            </div>
        </form>
        </br>
        <?php

        if (!isset($id)) {
        ?>
            <div class="d-flex align-items-center justify-content-center" style="min-height:400px; width:100%;">
                <?php
                $sq = "SELECT test.testCode, test.name, test.cost, diagnostic_unit.unit_name FROM test INNER JOIN diagnostic_unit ON test.diagnostic_unitID = diagnostic_unit.unitID
                ";
                $result = mysqli_query($conn, $sq);
                if (!$result) echo $conn->error;
                if (mysqli_num_rows($result) > 0) {
                ?>
                    <table class="table table-hover w-75">
                        <thead class=" text-center text-light bg-dark">
                            <tr>
                                <th scope="col">Test Code</th>
                                <th scope="col">Test Name</th>
                                <th scope="col">Test Cost</th>
                                <th scope="col">Diagnostic Unit</th>

                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <tr>
                                    <td scope="col"><?php echo $row['testCode']; ?></td>
                                    <td scope="col"><?php echo $row['name']; ?></td>
                                    <td scope="col"><?php echo $row['cost']; ?></td>
                                    <td scope="col"><?php echo $row['unit_name']; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                <?php
                } else {
                ?>
                    <h1 class="h1 text-center">No Test was found<br><br>Add new Test or Search for Test ...</h1>
                <?php
                }
                ?>
            </div>
        <?php
        } else if ($id == 0) {
        ?>
            <div class="d-flex align-items-center justify-content-center" style="min-height:400px; width:100%;">
                <h1 class="h1 text-center">SORRY,<br>There is no Test with given Details. <br> Try Again !</h1>
            </div>

        <?php
        } else {
        ?>
            <hr>
            <div class="d-flex justify-content-center mt-3">
                <form action="" method="post" class="w-100">
                    <div class="d-flex justify-content-between">
                        <h2 class="h2">Test Code : <?php echo isset($id) ? $testCode : ""; ?></h2>
                        <div>
                            <a onclick="enableEdit()" id="btn-edit" class="btn btn-success"> Edit Details</a>
                            <?php buttonElement("btn-delete", "btn btn-danger", " - Delete Test", "btn-delete", "") ?>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="name">Test Name</label>
                            <input type="text" name="test_name" class="form-control" id="t_name" value="<?php echo $test_name; ?>" disabled>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="address">Test Cost</label>
                            <input type="text" name="test_cost" class="form-control" id="t_cost" value="<?php echo $test_cost; ?>" disabled>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="address">Diagnostic Unit ID</label>
                            <input type="text" name="test_diagnostic_unitID" class="form-control" id="t_unitID" value="<?php echo $diagnostic_unitID; ?>" disabled>
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
                document.getElementById('addNewTest').style = 'display: block';
                document.getElementById('viewTest').style = 'display: none';
            }

            function enableEdit() {
                document.getElementById('edit-cancel-btn').innerHTML = `
                    <button name="btn-save" style="margin-right:20px; margin-left: 0;" class="btn btn-danger" id='btn-save'>Save</button>
                    <a onclick="disableEdit()" class="btn btn-success">Cancel</a>
            `;
                document.getElementById('t_name').disabled = false;
                document.getElementById('t_cost').disabled = false;
                document.getElementById('t_unitID').disabled = false;

            }

            function disableEdit() {
                document.getElementById('t_name').disabled = true;
                document.getElementById('t_cost').disabled = true;
                document.getElementById('t_unitID').disabled = true;
                location.reload();
            }
        </script>
    </div>
</div>