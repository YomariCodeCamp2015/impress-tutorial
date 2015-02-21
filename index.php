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
else if (isset($_POST['action']))
{
    if ($_POST['action'] == "Add slide")
    {
        $slide_number = $_POST['slide_number'] + 1;

        include "form.html.php";
    }
    else if ($_POST['action'] == "Finish")
    {
        include "tutorial.html.php";
    }
    else
    {
        echo "<p>ERROR</p>";
    }
}
else
{
    include "start.html.php";
}

?>
