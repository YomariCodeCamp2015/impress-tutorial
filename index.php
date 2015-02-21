<?php

$step = 1000;

if (isset($_POST['action']))
{
    if ($_POST['action'] == "Create")
    {
        $tutorialTitle = $_POST['title'];

        if ($tutorialTitle == "") {
            include "start.html.php";
            echo "<div class='error'><p>Title cannot be empty!</p></div>";
            exit;
        }

        $header_file = fopen('tutorial_header.html', 'r') or die("Cannot open header file");
        $header_html = fread($header_file, filesize("tutorial_header.html"));
        fclose($header_file);
        $header_html = $header_html .
            "<title>" . $tutorialTitle . "</title></head>" .
            "<body class='impress-not-supported'>" .
            "<div id='impress'>";

        $tutorial_file = fopen('tutorial.html', 'w') or die("Cannot open tutorial file");
        fwrite($tutorial_file, $header_html);
        fclose($tutorial_file);
        
        $slide_number = 1;
        include "form.html.php";
    }
    else if ($_POST['action'] == "Add slide")
    {
        $slide_number = $_POST['slide_number'];
        $slide_title = $_POST['slide_title'];
        $slide_details = $_POST['slide_details'];
        $slide_html =
            "<div class='step slide' data-x='0' data-y='" . ($slide_number * $step) . "'>" .
            "<h1 style='font-weight:bold;text-align:center;'>" . $slide_title . "</h1>" . $slide_details .
            "</div>";

        $tutorial_file = fopen('tutorial.html', 'a+');
        fwrite($tutorial_file, $slide_html);
        fclose($tutorial_file);

        $slide_number = $slide_number + 1;
        include "form.html.php";
    }
    else if ($_POST['action'] == "Finish")
    {
        $slide_number = $_POST['slide_number'];
        $slide_title = $_POST['slide_title'];
        $slide_details = $_POST['slide_details'];

        $slide_html =
            "<div class='step slide' data-x='0' data-y='".($slide_number * $step)."'>" .
            "<h1 style='font-weight:bold;text-align:center;'>" . $slide_title . "</h1>" . $slide_details .
            "</div>";

        $footer_file = fopen('tutorial_footer.html', 'r');
        $footer_html = fread($footer_file, filesize("tutorial_footer.html"));
        fclose($footer_file);

        $tutorial_file = fopen('tutorial.html', 'a+');
        fwrite($tutorial_file, $slide_html . $footer_html);
        fclose($tutorial_file);

        header('Location: tutorial.html');
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
