<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');


if (isset($_POST['btn-search'])) {

    $id = textBoxValue('vendor_search');
    $sq = "SELECT * FROM vendor WHERE regNo = '$id' OR contact_no = '$id' OR name LIKE '$id'";
    $result = mysqli_query($conn, $sq);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
        $vendor_regNo = $row['regNo'];
        $_SESSION['vendor_regNo'] = $vendor_regNo;
        $vendor_name = $row['name'];
        $vendor_contact_no = $row['contact_no'];
        $vendor_address = $row['address'];
    } else if (mysqli_num_rows($result) == 0) {
        $id = 0;
    } else {
        echo $conn->error;
    }
}


if (isset($_POST['btn-save'])) {
    $vendor_name = textBoxValue('vendor_name');
    $vendor_contact_no = textBoxValue('vendor_contact_no');
    $vendor_address = textBoxValue('vendor_address');

    $vendor_regNo = (int) $_SESSION['vendor_regNo'];

    $sq = "UPDATE vendor SET regNo='$vendor_regNo', name='$vendor_name', contact_no='$vendor_contact_no', address='$vendor_address' WHERE regNo = $vendor_regNo ";
    if (!mysqli_query($conn, $sq)) {
        echo $conn->error;
    }
}

if (isset($_POST['btn-delete'])) {
    $vendor_regNo = $_SESSION['vendor_regNo'];
    $sq = "DELETE FROM vendor WHERE regNo = $vendor_regNo";
    if (!mysqli_query($conn, $sq)) {
        echo $conn->error;
    }
}

?>

<div class="card mt-3 shadow">
    <h5 class="card-header">VIEW / EDIT / DELETE VENDOR</h5>
    <div class="card-body">
        <form method="post" action="" class="d-flex justify-content-start">
            <div class="row w-100">
                <div class="input-group col-md-6 w-50">
                    <input type="text" name="vendor_search" class="form-control rounded" placeholder="Search VENDOR : Vendor RegNo or Name or Contact Number" aria-label="Search" aria-describedby="search-addon" />
                    <button name="btn-search" value="btn-search" class="btn btn-outline-primary">search</button>
                </div>
                <div class="input-group w-50 col-md-6 d-flex justify-content-end">
                    <a onclick="displayAddNew()" class="btn btn-primary"> + Add New VENDOR</a>
                </div>
            </div>
        </form>
        </br>
        <?php

        if (!isset($id)) {
        ?>
            <div class="d-flex align-items-center justify-content-center" style="min-height:400px; width:100%;">
                <?php
                $sq = "SELECT * FROM vendor;
                ";
                $result = mysqli_query($conn, $sq);
                if (mysqli_num_rows($result) > 0) {
                ?>
                    <table class="table table-hover w-75">
                        <thead class=" text-center text-light bg-dark">
                            <tr>
                                <th scope="col">Vendor Register Number</th>
                                <th scope="col">Vendor Name</th>
                                <th scope="col">Vendor Contact Number</th>
                                <th scope="col">Vendor Address</th>

                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <tr>
                                    <td scope="col"><?php echo $row['regNo']; ?></td>
                                    <td scope="col"><?php echo $row['name']; ?></td>
                                    <td scope="col"><?php echo $row['contact_no']; ?></td>
                                    <td scope="col"><?php echo $row['address']; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                <?php
                } else {
                ?>
                    <h1 class="h1 text-center">No Vendor was found<br><br>Add new Vendor or Search for Vendor ...</h1>
                <?php
                }
                ?>
            </div>
        <?php
        } else if ($id == 0) {
        ?>
            <div class="d-flex align-items-center justify-content-center" style="min-height:400px; width:100%;">
                <h1 class="h1 text-center">SORRY,<br>There is no Vendor with given Details. <br> Try Again !</h1>
            </div>

        <?php
        } else {
        ?>
            <hr>
            <div class="d-flex justify-content-center mt-3">
                <form action="" method="post" class="w-100">
                    <div class="d-flex justify-content-between">
                        <h2 class="h2">Vendor Register Number : <?php echo isset($id) ? $vendor_regNo : ""; ?></h2>
                        <div>
                            <a onclick="enableEdit()" id="btn-edit" class="btn btn-success"> Edit Details</a>
                            <?php buttonElement("btn-delete", "btn btn-danger", " - Delete Vendor", "btn-delete", "") ?>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="name">Vendor Name</label>
                            <input type="text" name="vendor_name" class="form-control" id="v_name" value="<?php echo $vendor_name; ?>" disabled>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="address">Vendor Contact Number</label>
                            <input type="text" name="vendor_contact_no" class="form-control" id="v_contact_no" value="<?php echo $vendor_contact_no; ?>" disabled>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="address">Vendor Address</label>
                            <input type="text" name="vendor_address" class="form-control" id="v_address" value="<?php echo $vendor_address; ?>" disabled>
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
                document.getElementById('v_contact_no').disabled = false;
                document.getElementById('v_address').disabled = false;

            }

            function disableEdit() {
                document.getElementById('v_name').disabled = true;
                document.getElementById('v_contact_no').disabled = true;
                document.getElementById('v_address').disabled = true;
                location.reload();
            }
        </script>
    </div>
</div>