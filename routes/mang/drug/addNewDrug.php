<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');

if (isset($_POST['btn-add-next'])) {
    $query = " ";
    $drug_name = textBoxValue('drug_name');
    $drug_type = textBoxValue('drug_type');
    $drug_unit_cost = (float)textBoxValue('drug_unit_cost');

    $sq = "INSERT INTO drug (name, type, unit_cost) VALUES ('$drug_name', '$drug_type', $drug_unit_cost)";
    if (mysqli_query($conn, $sq)) {

        $sq2 = "SELECT drugCode from drug ORDER BY drugCode DESC LIMIT 1";
        $result = mysqli_query($conn, $sq2);
        $row = mysqli_fetch_array($result);

        if (mysqli_num_rows($result) > 0) {
            $drugCode = $row['drugCode'];
?>
            <script>
                alert("New Drug added Successfully\nDVendor Name : <?php echo $drug_name; ?>\nDrug Code : <?php echo $drugCode; ?>")
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
    <h5 class="card-header">ADD NEW NEW DRUG</h5>
    <div class="card-body">
        <h5 class="card-title">Enter The Details Of the Drug : </h5>
        <div class="d-flex justify-content-center mt-3">
            <form action="" method="post" class="w-100">

                <div class="pt-2">
                    <?php inputElement("drug_name", "text", "Drug Name", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("drug_type", "text", "Drug Type", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("drug_unit_cost", "text", "Unit Cost", "", ""); ?>
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