<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');

if (isset($_POST['btn-add-new-test'])) {
    $query = " ";
    $test_name = textBoxValue('test_name');
    $test_cost = (float)textBoxValue('test_cost');
    $diagnostic_unitID = textBoxValue('diagnostic_unit_id');

    $sq = "INSERT INTO test (name, cost, diagnostic_unitID) VALUES ('$test_name', '$test_cost', '$diagnostic_unitID')";
    if (mysqli_query($conn, $sq)) {

        $sq2 = "SELECT testCode from test ORDER BY testCode DESC LIMIT 1";
        $result = mysqli_query($conn, $sq2);
        $row = mysqli_fetch_array($result);
        if (!$result) echo $conn->error;

        if (mysqli_num_rows($result) > 0) {
            $testCode = $row['testCode'];
?>
            <script>
                alert("New test added Successfully\nTest Name : <?php echo $test_name; ?>\nTest Code : <?php echo $testCode; ?>")
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
    <h5 class="card-header">ADD NEW NEW TEST</h5>
    <div class="card-body">
        <h5 class="card-title">Enter The Details Of New Test : </h5>
        <div class="d-flex justify-content-center mt-3">
            <form action="" method="post" class="w-100">
                <div class="pt-2">
                    <?php inputElement("test_name", "text", "Test Name", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("test_cost", "text", "Test Cost", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("diagnostic_unit_id", "text", "Diagnostic Unit ID", "", ""); ?>
                </div>

                <?php buttonElement("btn-add-new-test", "btn btn-primary", "Submit", "btn-add-new-test", "") ?>
                <a onclick="displayViewTest()" class="btn btn-danger">Cancel</a>

            </form>
        </div>
    </div>
</div>

<script>
    function displayViewTest() {
        document.getElementById('addNewTest').style = 'display: none';
        document.getElementById('viewTest').style = 'display: block';

    }
</script>