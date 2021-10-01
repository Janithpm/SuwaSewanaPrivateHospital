<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');


if (isset($_POST['btn-search'])) {

    $id = textBoxValue('employeeID');
    $sq = "SELECT * FROM diagnostic_unit WHERE unitID = '$id' OR managed_by = '$id' OR unit_name LIKE '$id'";
    $result = mysqli_query($conn, $sq);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
        $unitID = $row['unitID'];

        $_SESSION['unitID'] = $unitID;
        $unit_name = $row['unit_name'];
        $managed_by = $row['managed_by'];
    } else if (mysqli_num_rows($result) == 0) {
        $id = 0;
    } else {
        echo $conn->error;
    }
}


if (isset($_POST['btn-save'])) {
    $unit_name = textBoxValue('unit_name');
    $managed_by = textBoxValue('managed_by');

    $unitID = (int) $_SESSION['unitID'];
    $sq = "UPDATE diagnostic_unit SET unit_name='$unit_name', managed_by='$managed_by' WHERE unitID = $unitID ";
    if (!mysqli_query($conn, $sq)) {
        echo $conn->error;
    }
}

if (isset($_POST['btn-delete'])) {
    $unitID = $_SESSION['unitID'];
    $sq = "DELETE FROM diagnostic_unit WHERE unitID = $unitID";
    if (!mysqli_query($conn, $sq)) {
        echo $conn->error;
    }
}

?>

<div class="card mt-3 shadow">
    <h5 class="card-header">VIEW / EDIT / DELETE DIAGNOSTICS UNIT</h5>
    <div class="card-body">
        <form method="post" action="" class="d-flex justify-content-start">
            <div class="row w-100">
                <div class="input-group col-md-6 w-50">
                    <input type="text" name="employeeID" class="form-control rounded" placeholder="Search UNIT : Unit ID or Name or Manger's Employee ID" aria-label="Search" aria-describedby="search-addon" />
                    <button name="btn-search" value="btn-search" class="btn btn-outline-primary">search</button>
                </div>
                <div class="input-group w-50 col-md-6 d-flex justify-content-end">
                    <a onclick="displayAddNew()" class="btn btn-primary"> + Add New UNIT</a>
                </div>
            </div>
        </form>
        </br>
        <?php

        if (!isset($id)) {
        ?>
            <div class="d-flex align-items-center justify-content-center" style="min-height:400px; width:100%;">
                <?php
                $sq = "SELECT diagnostic_unit.unitID,  diagnostic_unit.unit_name,  diagnostic_unit.managed_by, employee.name FROM  diagnostic_unit INNER JOIN employee ON  diagnostic_unit.managed_by = employee.employeeID;
                ";
                $result = mysqli_query($conn, $sq);
                if (mysqli_num_rows($result) > 0) {
                ?>
                    <table class="table table-hover w-75">
                        <thead class=" text-center text-light bg-dark">
                            <tr>
                                <th scope="col">Diagnostic Unit ID</th>
                                <th scope="col">Diagnostic Unit Name</th>
                                <th scope="col">Diagnostic Unit Managed By (ID)</th>
                                <th scope="col">Diagnostic Unit Managed By (Name)</th>

                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <tr>
                                    <td scope="col"><?php echo $row['unitID']; ?></td>
                                    <td scope="col"><?php echo $row['unit_name']; ?></td>
                                    <td scope="col"><?php echo $row['managed_by']; ?></td>
                                    <td scope="col"><?php echo $row['name']; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                <?php
                } else {
                ?>
                    <h1 class="h1 text-center">No Diagnostic Unit was found<br><br>Add new Diagnostic Unit or Search for Unit ...</h1>
                <?php
                }
                ?>
            </div>
        <?php
        } else if ($id == 0) {
        ?>
            <div class="d-flex align-items-center justify-content-center" style="min-height:400px; width:100%;">
                <h1 class="h1 text-center">SORRY,<br>There is no Diagnostic Unit with given Details. <br> Try Again !</h1>
            </div>

        <?php
        } else {
        ?>
            <hr>
            <div class="d-flex justify-content-center mt-3">
                <form action="" method="post" class="w-100">
                    <div class="d-flex justify-content-between">
                        <h2 class="h2">Diagnostic Unit ID : <?php echo isset($id) ? $unitID : ""; ?></h2>
                        <div>
                            <a onclick="enableEdit()" id="btn-edit" class="btn btn-success"> Edit Details</a>
                            <?php buttonElement("btn-delete", "btn btn-danger", " - Delete Word", "btn-delete", "") ?>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="name">Diagnostic Unit Name</label>
                            <input type="text" name="unit_name" class="form-control" id="v_name" value="<?php echo $unit_name; ?>" disabled>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="address">Unit managed by</label>
                            <input type="text" name="managed_by" class="form-control" id="v_managed_by" value="<?php echo $managed_by; ?>" disabled>
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
                document.getElementById('addNewEmp').style = 'display: block';
                document.getElementById('viewEmp').style = 'display: none';
            }

            function enableEdit() {
                document.getElementById('edit-cancel-btn').innerHTML = `
                    <button name="btn-save" style="margin-right:20px; margin-left: 0;" class="btn btn-danger" id='btn-save'>Save</button>
                    <a onclick="disableEdit()" class="btn btn-success">Cancel</a>
            `;
                document.getElementById('v_name').disabled = false;
                document.getElementById('v_managed_by').disabled = false;

            }

            function disableEdit() {
                document.getElementById('v_name').disabled = true;
                document.getElementById('v_managed_by').disabled = true;
                location.reload();
            }
        </script>
    </div>
</div>