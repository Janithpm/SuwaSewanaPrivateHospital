<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');

if (isset($_POST['btn-add-supply'])) {
    $query = " ";
    $drugCode = textBoxValue('drugCode');
    $vendor_reg_no = textBoxValue('vendor_reg_no');
    $drug_type = textBoxValue('drug_type');
    $drug_quantity = (int)textBoxValue('drug_quantity');
    $drug_unit_cost = (float)textBoxValue('drug_unit_cost');
    $drug_supply_date = textBoxValue('drug_supply_date') ? textBoxValue('drug_supply_date') : date('Y-m-d');

    $sq = "INSERT INTO supply  VALUES ($drugCode, $vendor_reg_no, '$drug_type',$drug_quantity, $drug_unit_cost, '$drug_supply_date' )";
    if (mysqli_query($conn, $sq)) {

?>
        <script>
            alert("New supply added Successfully\nDrug Code: <?php echo $drugCode; ?>\nVendor RegNo : <?php echo $vendor_regNo; ?>\nSupply Date : <?php echo $supply_date; ?>")
        </script>
<?php



        //     $sq2 = "SELECT drugCode, regNo, supply_date from supply ORDER BY (drugCode, regNo) DESC LIMIT 1";
        //     $result = mysqli_query($conn, $sq2);
        //     $row = mysqli_fetch_array($result);

        //     if (mysqli_num_rows($result) > 0) {
        //         $drugCode = $row['drugCode'];
        //         $vendor_regNo = $row['regNo'];
        //         $supply_date = $row['supply_date'];
        //  header("Location: supplies.php");
        //     } else {
        //         echo "error" . $conn->error;
        //     }
    } else {
        echo "error" . $conn->error;
    }
}

?>
<div class="card mt-3 shadow">
    <h5 class="card-header">ADD NEW NEW SUPPLY</h5>
    <div class="card-body">
        <h5 class="card-title">Enter The Details Of New Supply : </h5>
        <div class="d-flex justify-content-center mt-3">
            <form action="" method="post" class="w-100">
                <div class="pt-2">
                    <?php inputElement("drugCode", "text", "Drug Code", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("vendor_reg_no", "text", "Vendor Register Number", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("drug_type", "text", "Drug Type", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("drug_quantity", "text", "Drug Quantity", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("drug_unit_cost", "text", "Drug Unit Cost", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("drug_supply_date", "text", "Drug Supply Date", "Default : Today", ""); ?>
                </div>

                <?php buttonElement("btn-submit", "btn btn-primary", "Submit", "btn-add-supply", "onclick=\"displayViewSupply()\"") ?>
                <a onclick="displayViewSupply()" class="btn btn-danger">Cancel</a>

            </form>
        </div>
    </div>
</div>

<script>
    function displayViewSupply() {
        document.getElementById('addNewSupply').style = 'display: none';
        document.getElementById('viewSupply').style = 'display: block';

    }
</script>