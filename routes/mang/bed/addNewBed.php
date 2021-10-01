<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');

if (isset($_POST['btn-add-next'])) {
    $query = " ";

    $wordID = textboxValue("word_id");

    $sq = "INSERT INTO bed (wordID) VALUES ('$wordID')";
    if (mysqli_query($conn, $sq)) {

        $sq2 = "SELECT bedID from bed ORDER BY bedID DESC LIMIT 1";
        $result = mysqli_query($conn, $sq2);
        $row = mysqli_fetch_array($result);

        if (mysqli_num_rows($result) > 0) {
            $bedID = $row['bedID'];
?>
            <script>
                alert("New Bed added Successfully\nBed ID : <?php echo $bedID; ?>\nWord ID : <?php echo $wordID; ?>\n")
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
    <h5 class="card-header">ADD NEW BED</h5>
    <div class="card-body">
        <h5 class="card-title">Enter The Details Of New Bed : </h5>
        <div class="d-flex justify-content-center mt-3">
            <form action="" method="post" class="w-100">
                <div class="pt-2">
                    <?php inputElement("word_id", "text", "Word ID", "", ""); ?>
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