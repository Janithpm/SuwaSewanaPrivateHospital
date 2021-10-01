<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');

if (isset($_POST['btn-add-next'])) {
    $query = " ";

    $unit_name = textboxValue("unit_name");
    $unit_managed_by = textboxValue("unit_managed_by");

    $sq = "INSERT INTO diagnostic_unit (unit_name, managed_by) VALUES ('$unit_name','$unit_managed_by')";
    if (mysqli_query($conn, $sq)) {

        $sq2 = "SELECT unitID from diagnostic_unit ORDER BY unitID DESC LIMIT 1";
        $result = mysqli_query($conn, $sq2);
        $row = mysqli_fetch_array($result);

        if (mysqli_num_rows($result) > 0) {
            $unitID = $row['unitID'];
?>
            <script>
                alert("New Unit added Successfully\nDiagnostic Unit Name : <?php echo $unit_name; ?>\nUnit ID : <?php echo $unitID; ?>\nManaged By: <?php echo $unit_managed_by; ?>\n")
            </script>
<?php

        } else {
            echo "error" . $conn->error;
        }
    } else {
        echo "error" . $conn->error;
    }
}

?>
<div class="card mt-3 shadow">
    <h5 class="card-header">ADD NEW DIAGNOSTIC UNIT</h5>
    <div class="card-body">
        <h5 class="card-title">Enter The Details Of New Unit : </h5>
        <div class="d-flex justify-content-center mt-3">
            <form action="" method="post" class="w-100">
                <div class="pt-2">
                    <?php inputElement("unit_name", "text", "Diagnostic Unit Name", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("unit_managed_by", "text", "Diagnostic Unit Managed By ( Employee ID only )", "", ""); ?>
                </div>

                <?php buttonElement("btn-submit", "btn btn-primary", "Submit", "btn-add-next", "") ?>
                <a onclick="displayViewEmp()" class="btn btn-danger">Cancel</a>

            </form>
        </div>
    </div>
</div>

<script>
    function displayViewEmp() {
        document.getElementById('addNewEmp').style = 'display: none';
        document.getElementById('viewEmp').style = 'display: block';

    }
</script>