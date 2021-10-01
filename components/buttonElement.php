<?php
function buttonElement($btnid, $styleclass, $text, $name, $attr)
{
    $btn = "
        <button name='$name' '$attr' style=\"margin: 5px 20px;\" class='$styleclass' id='$btnid'>$text</button>
    ";
    echo $btn;
}
