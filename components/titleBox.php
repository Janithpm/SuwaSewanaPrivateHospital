<?php
function titleBox($feature, $bigText, $smallText, $footerText, $bgColor, $logoutPage, $returnPath, $isReturn)
{
    $temp = $isReturn ? "<a class='btn btn-primary text-light' href=\"$returnPath\" style=\" margin-right: 15px\">Go Back</a>" : " ";


    echo "
    <div class=\"card mt-1 shadow  text-white bg-$bgColor\">
    <div class=\"card-header\">
    <div class=\"d-flex justify-content-between align-items-center\">
    <div>$feature</div>
    <div>
    $temp
    <a class='btn btn-warning text-dark' href=\"$logoutPage\">Log out</a>
    </div>
    </div>
    </div>
        <div class=\"card-body\">
            <blockquote class=\"blockquote mb-0\">
                <h5 class=\"h5\">$smallText</h5>
                <h1 class=\"h1 pb-3\" style=\"font-size:40px;\">$bigText</h1>
                <footer class=\"blockquote-footer text-white\">EMPID : $footerText</footer>
            </blockquote>
        </div>
    </div>";
}
