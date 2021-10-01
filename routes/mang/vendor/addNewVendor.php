<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');

if (isset($_POST['btn-add-next'])) {
    $query = " ";
    $vendor_name = textboxValue("vendor_name");
    $vendor_contact_no = textboxValue("vendor_contact_no");
    $vendor_address = textboxValue("vendor_address");

    $sq = "INSERT INTO vendor (name, contact_no, address) VALUES ('$vendor_name', '$vendor_contact_no', '$vendor_address')";
    if (mysqli_query($conn, $sq)) {

        $sq2 = "SELECT regNo from vendor ORDER BY regNo DESC LIMIT 1";
        $result = mysqli_query($conn, $sq2);
        $row = mysqli_fetch_array($result);

        if (mysqli_num_rows($result) > 0) {
            $vendor_regNo = $row['regNo'];
?>
            <script>
                alert("New Vendor added Successfully\nDVendor Name : <?php echo $vendor_name; ?>\nVendor RegNo : <?php echo $vendor_regNo; ?>")
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
    <h5 class="card-header">ADD NEW NEW VENDOR</h5>
    <div class="card-body">
        <h5 class="card-title">Enter The Details Of New Vendor : </h5>
        <div class="d-flex justify-content-center mt-3">
            <form action="" method="post" class="w-100">
                <div class="pt-2">
                    <?php inputElement("vendor_name", "text", "vendor Name", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("vendor_contact_no", "text", "Vendor Contact Number", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("vendor_address", "text", "Vendor address", "", ""); ?>
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