<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');


if (isset($_POST['btn-search'])) {

    $id = textBoxValue('bedID');
    $sq = "SELECT * FROM bed WHERE bedID = '$id' OR wordID = '$id'";
    $result = mysqli_query($conn, $sq);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
        $bedID = $row['bedID'];

        $_SESSION['bedID'] = $bedID;
        $wordID = $row['wordID'];
    } else if (mysqli_num_rows($result) == 0) {
        $id = 0;
    } else {
        echo $conn->error;
    }
}


if (isset($_POST['btn-save'])) {
    $wordID = textBoxValue('word_id');

    $bedID = (int) $_SESSION['bedID'];
    $sq = "UPDATE bed SET WordID='$wordID' WHERE bedID = '$bedID'";
    if (!mysqli_query($conn, $sq)) {
        echo $conn->error;
    }
}

if (isset($_POST['btn-delete'])) {
    $bedID = $_SESSION['bedID'];
    $sq = "DELETE FROM bed WHERE bedID = $bedID";
    if (!mysqli_query($conn, $sq)) {
        echo $conn->error;
    }
}

?>

<div class="card mt-3 shadow">
    <h5 class="card-header">VIEW / EDIT / DELETE BED</h5>
    <div class="card-body">
        <form method="post" action="" class="d-flex justify-content-start">
            <div class="row w-100">
                <div class="input-group col-md-6 w-50">
                    <input type="text" name="bedID" class="form-control rounded" placeholder="Search UNIT : Unit ID or Name or Manger's Employee ID" aria-label="Search" aria-describedby="search-addon" />
                    <button name="btn-search" value="btn-search" class="btn btn-outline-primary">search</button>
                </div>
                <div class="input-group w-50 col-md-6 d-flex justify-content-end">
                    <a onclick="displayAddNew()" class="btn btn-primary"> + Add New BED</a>
                </div>
            </div>
        </form>
        </br>
        <?php

        if (!isset($id)) {
        ?>
            <div class="d-flex align-items-center justify-content-center" style="min-height:400px; width:100%;">
                <?php
                $sq = "SELECT * FROM bed";
                $result = mysqli_query($conn, $sq);
                if (mysqli_num_rows($result) > 0) {
                ?>
                    <table class="table table-hover w-75">
                        <thead class=" text-center text-light bg-dark">
                            <tr>
                                <th scope="col">Bed ID</th>
                                <th scope="col">Word ID</th>

                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <tr>
                                    <td scope="col"><?php echo $row['bedID']; ?></td>
                                    <td scope="col"><?php echo $row['wordID']; ?></td>

                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                <?php
                } else {
                ?>
                    <h1 class="h1 text-center">No Bed was found<br><br>Add new Bed or Search for Bed ...</h1>
                <?php
                }
                ?>
            </div>
        <?php
        } else if ($id == 0) {
        ?>
            <div class="d-flex align-items-center justify-content-center" style="min-height:400px; width:100%;">
                <h1 class="h1 text-center">SORRY,<br>There is no Bed with given Details. <br> Try Again !</h1>
            </div>

        <?php
        } else {
        ?>
            <hr>
            <div class="d-flex justify-content-center mt-3">
                <form action="" method="post" class="w-100">
                    <div class="d-flex justify-content-between">
                        <h2 class="h2">Bed ID : <?php echo isset($id) ? $bedID : ""; ?></h2>
                        <div>
                            <a onclick="enableEdit()" id="btn-edit" class="btn btn-success"> Edit Details</a>
                            <?php buttonElement("btn-delete", "btn btn-danger", " - Delete Word", "btn-delete", "") ?>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="form-group mb-3">
                            <label for="name">Word ID</label>
                            <input type="text" name="word_id" class="form-control" id="v_name" value="<?php echo $wordID; ?>" disabled>
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

            }

            function disableEdit() {
                document.getElementById('v_name').disabled = true;
                location.reload();
            }
        </script>
    </div>
</div>