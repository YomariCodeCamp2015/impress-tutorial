<?php

session_start(); // session start must be used to acess previous session variable otherwise session will be null
$step = 800;

if (isset($_POST['action']) or isset($_SESSION["tutorial_filename"]))
{

    if ($_POST['action'] == "Create")
    {
        $tutorialTitle = $_POST['title'];

        if ($tutorialTitle == "") {
            include "start.html.php";
            echo "<div class='error'><p>Title cannot be empty!</p></div>";
            exit;
        }


        $filename = 'tutorial/' . str_replace('/', '-', str_replace(' ', '-', $tutorialTitle)) . '.html';

        if (file_exists($_SESSION['tutorial_filename'])) {
            include "start.html.php";
            echo "<div class='error'><p>This name is already occupied. Choose another name.</p></div>";
            exit;
        }
        else {
            $_SESSION["tutorial_filename"]=$filename;
        }

        $header_file = fopen('tutorial_header.html', 'r') or die("Cannot open header file");
        $header_html = fread($header_file, filesize("tutorial_header.html"));
        fclose($header_file);
        $header_html = $header_html .
            "<title>" . $tutorialTitle . "</title></head>" .
            "<body class='impress-not-supported'>" .
            "<div id='impress'>";

        $tutorial_file = fopen($_SESSION['tutorial_filename'], 'w') or die("Cannot open tutorial file");
        fwrite($tutorial_file, $header_html);
        fclose($tutorial_file);
        
        $_SESSION['slide_number'] = 1;
        include "form.html.php";
    }
    else if ($_POST['action'] == "Add slide")
    {
        $_SESSION['slide_number'] = $_POST['slide_number'];
        $slide_title = $_POST['slide_title'];
        $slide_details = $_POST['slide_details'];
        $slide_html =
            "<div class='step slide' data-x='0' data-y='" . ($_SESSION['slide_number'] * $step) . "'>" .
            "<h1 style='font-weight:bold;text-align:center;'>" . $slide_title . "</h1>" . $slide_details .
            "</div>";

        $tutorial_file = fopen($_SESSION['tutorial_filename'], 'a') or die("Cannot open tutorial file");
        fwrite($tutorial_file, $slide_html);
        fclose($tutorial_file);

        $_SESSION["slide_number"] = $_SESSION["slide_number"] + 1;
        include "form.html.php";
    }
    else if ($_POST['action'] == "Finish")
    {
        $_SESSION['slide_number'] = $_POST['slide_number'];
        $slide_title = $_POST['slide_title'];
        $slide_details = $_POST['slide_details'];

        $slide_html =
            "<div class='step slide' data-x='0' data-y='".($_SESSION['slide_number'] * $step)."'>" .
            "<h1 style='font-weight:bold;text-align:center;'>" . $slide_title . "</h1>" . $slide_details .
            "</div>";

        $footer_file = fopen('tutorial_footer.html', 'r');
        $footer_html = fread($footer_file, filesize("tutorial_footer.html"));
        fclose($footer_file);

        $tutorial_file = fopen($_SESSION['tutorial_filename'], 'a') or die("Cannot open tutorial file");
        fwrite($tutorial_file, $slide_html . $footer_html);
        fclose($tutorial_file);

        header('Location: ' . $_SESSION['tutorial_filename']);
        session_unset();
    }
    else if ($_POST['action'] == "Cancel")
    {
        unlink($_SESSION['tutorial_filename']);
        include "start.html.php";
        session_unset();       
    }
    else
    {
        include "form.html.php";
    }
}
else
{
    include "start.html.php";
}

?>
