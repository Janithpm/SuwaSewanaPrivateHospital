<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/dbConn.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/customFunc/textBoxValue.php');

if (isset($_POST['btn-add-next'])) {
    $query = " ";

    $word_name = textboxValue("word_name");
    $word_managed_by = textboxValue("word_managed_by");

    $sq = "INSERT INTO word (word_name, managed_by) VALUES ('$word_name','$word_managed_by')";
    if (mysqli_query($conn, $sq)) {

        $sq2 = "SELECT wordID from word ORDER BY wordID DESC LIMIT 1";
        $result = mysqli_query($conn, $sq2);
        $row = mysqli_fetch_array($result);

        if (mysqli_num_rows($result) > 0) {

            $wordID = $row['wordID'];
?>
            <script>
                alert("New Word added Successfully\nWord Name : <?php echo $word_name; ?>\nWord ID : <?php echo $wordID; ?>\nManaged By: <?php echo $word_managed_by; ?>\n")
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
    <h5 class="card-header">ADD NEW WORD</h5>
    <div class="card-body">
        <h5 class="card-title">Enter The Details Of New Word : </h5>
        <div class="d-flex justify-content-center mt-3">
            <form action="" method="post" class="w-100">
                <div class="pt-2">
                    <?php inputElement("word_name", "text", "Word Name", "", ""); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("word_managed_by", "text", "Word Managed By ( Employee ID only )", "", ""); ?>
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