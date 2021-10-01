<?php

function inputElement($name, $type, $displayText, $placeholder, $attrib)
{
  echo "
    <div class=\"form-group mb-3\">
    <label for='$name'>$displayText</label>
    <input type= '$type' name='$name' class=\"form-control\" id='$name' placeholder= '$placeholder' $attrib>
  </div>
    
    ";
}


// <div class=\"input-group-prepend\">
// <div class=\"input-group-text bg-warning\">$icon</div>
// </div>