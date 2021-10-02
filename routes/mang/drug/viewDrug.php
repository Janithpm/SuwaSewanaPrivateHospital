<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');


if (isset($_POST['btn-search'])) {

    $id = textBoxValue('drug_search');
    $sq = "SELECT * FROM drug WHERE drugCode = '$id' OR name LIKE '$id'";
    $result = mysqli_query($conn, $sq);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
        $drugCode = $row['drugCode'];
        $_SESSION['drugCode'] = $drugCode;
        $drug_name = $row['name'];
        $drug_type = $row['type'];
        $drug_unit_cost = $row['unit_cost'];
    } else if (mysqli_num_rows($result) == 0) {
        $id = 0;
    } else {
        echo $conn->error;
    }
}


if (isset($_POST['btn-save'])) {
    $drug_name = textBoxValue('drug_name');
    $drug_type = textBoxValue('drug_type');
    $drug_unit_cost = (float)textBoxValue('drug_unit_cost');

    $drugCode = (int) $_SESSION['drugCode'];

    $sq = "UPDATE drug SET name='$drug_name', type='$drug_type', unit_cost= $drug_unit_cost WHERE drugCode = $drugCode ";
    if (!mysqli_query($conn, $sq)) {
        echo $conn->error;
    }
}

if (isset($_POST['btn-delete'])) {
    $drugCode = $_SESSION['drugCode'];
    $sq = "DELETE FROM drug WHERE drugCode = $drugCode";
    if (!mysqli_query($conn, $sq)) {
        echo $conn->error;
    }
}

?>

<div class="card mt-3 shadow">
    <h5 class="card-header">VIEW / EDIT / DELETE DRUG</h5>
    <div class="card-body">
        <form method="post" action="" class="d-flex justify-content-start">
            <div class="row w-100">
                <div class="input-group col-md-6 w-50">
                    <input type="text" name="drug_search" class="form-control rounded" placeholder="Search Drug : Drug Code or Name" aria-label="Search" aria-describedby="search-addon" />
                    <button name="btn-search" value="btn-search" class="btn btn-outline-primary">search</button>
                </div>
                <div class="input-group w-50 col-md-6 d-flex justify-content-end">
                    <a onclick="displayAddNew()" class="btn btn-primary"> + Add New Drug</a>
                </div>
            </div>
        </form>
        </br>
        <?php

        if (!isset($id)) {
        ?>
            <div class="d-flex align-items-center justify-content-center" style="min-height:400px; width:100%;">
                <?php
                $sq = "SELECT * FROM drug;
                ";
                $result = mysqli_query($conn, $sq);
                if (mysqli_num_rows($result) > 0) {
                ?>
                    <table class="table table-hover w-75">
                        <thead class=" text-center text-light bg-dark">
                            <tr>
                                <th scope="col">Drug Code</th>
                                <th scope="col">Drug Name</th>
                                <th scope="col">Drug Type</th>
                                <th scope="col">Unit Cost</th>

                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <tr>
                                    <td scope="col"><?php echo $row['drugCode']; ?></td>
                                    <td scope="col"><?php echo $row['name']; ?></td>
                                    <td scope="col"><?php echo $row['type']; ?></td>
                                    <td scope="col"><?php echo $row['unit_cost']; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                <?php
                } else {
                ?>
                    <h1 class="h1 text-center">No Drug was found<br><br>Add new Drug or Search for Drug ...</h1>
                <?php
                }
                ?>
            </div>
        <?php
        } else if ($id == 0) {
        ?>
            <div class="d-flex align-items-center justify-content-center" style="min-height:400px; width:100%;">
                <h1 class="h1 text-center">SORRY,<br>There is no Drug with given Details. <br> Try Again !</h1>
            </div>

        <?php
        } else {
        ?>
            <hr>
            <div class="d-flex justify-content-center mt-3">
                <form action="" method="post" class="w-100">
                    <div class="d-flex justify-content-between">
                        <h2 class="h2">Droug Code : <?php echo isset($id) ? $drugCode : ""; ?></h2>
                        <div>
                            <a onclick="enableDrugEdit()" id="btn-edit" class="btn btn-success"> Edit Details</a>
                            <?php buttonElement("btn-delete", "btn btn-danger", " - Delete Drug", "btn-delete", "") ?>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="drug_name">Drug Name</label>
                            <input type="text" name="drug_name" class="form-control" id="d_name" value="<?php echo $drug_name; ?>" disabled>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="drug_type">Drug Type</label>
                            <input type="text" name="drug_type" class="form-control" id="d_type" value="<?php echo $drug_type; ?>" disabled>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="unit_cost">Unit Cost</label>
                            <input type="text" name="drug_unit_cost" class="form-control" id="d_unit_cost" value="<?php echo $drug_unit_cost; ?>" disabled>
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

            function enableDrugEdit() {
                console.log('enableDrugEdit');
                document.getElementById('edit-cancel-btn').innerHTML = `
                    <button name="btn-save" style="margin-right:20px; margin-left: 0;" class="btn btn-danger" id='btn-save'>Save</button>
                    <a onclick="disableDrugEdit()" class="btn btn-success">Cancel</a>
            `;
                document.getElementById('d_name').disabled = false;
                document.getElementById('d_type').disabled = false;
                document.getElementById('d_unit_cost').disabled = false;

            }

            function disableDrugEdit() {
                console.log('disableDrugEdit');
                document.getElementById('d_name').disabled = true;
                document.getElementById('d_type').disabled = true;
                document.getElementById('d_unit_cost').disabled = true;
                location.reload();
            }
        </script>
    </div>
</div>