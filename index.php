<?php

if (isset($_POST['title']))
{
    $tutorialTitle = $_POST['title'];

    if ($tutorialTitle == "") {
        include "start.html.php";
        echo "<div class='error'><p>Title cannot be empty!</p></div>";
        exit;
    }

    $slide_number = 1;
    include "form.html.php";
}

else
{
    include "start.html.php";
}

?>
