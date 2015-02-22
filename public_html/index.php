<?php

require_once "../connect.php";

session_start(); // session start must be used to acess previous session variable otherwise session will be null
$step = 800;

if (isset($_POST['action']) or isset($_SESSION["tutorial_filename"]))
{

    if ($_POST['action'] == "Create")
    {
        $_SESSION['title'] = str_replace('/', '_', str_replace(' ', '_', $_POST['title']));

        if ($_SESSION['title'] == "") {
            include "../start.html.php";
            echo "<div class='error'><p>Title cannot be empty!</p></div>";
            exit;
        }


        $filename = 'tutorial/' . $_SESSION['title'] . '.html';

        if (file_exists($filename)) {
            include "start.html.php";
            echo "<div class='error'><p>This name is already occupied. Choose another name.</p></div>";
            exit;
        }
        $_SESSION["tutorial_filename"]=$filename;

        $sql =
            "CREATE TABLE " . $_SESSION['title'] . " (" .
            "stepid INT(6) UNSIGNED PRIMARY KEY," .
            "title VARCHAR(50)," .
            "details VARCHAR(1000)" .
            ")";
        try {
            $conn->exec($sql);
        } catch (PDOException $e) {
            echo "Cannot create table: " . $e->getMessage();
        }

        $_SESSION['slide_number'] = 1;
        include "../form.html.php";
    }
    else if ($_POST['action'] == "Next slide")
    {
        $curstep = $_SESSION['slide_number'];

        try {
            $sql = "SELECT * FROM " . $_SESSION['title'] . " WHERE stepid=" . $curstep;
            $result = $conn->query($sql);
            $rows = $result->fetchAll();
            if (count($rows) == 0) { // Create new
                $title = $_POST['slide_title'];
                $details = $_POST['slide_details'];

                try {
                    $sql = "INSERT INTO " . $_SESSION['title'] . " VALUES (:stepid, :title, :details)";
                    $s = $conn->prepare($sql);
                    $s->bindValue(':stepid', "$curstep");
                    $s->bindValue(':title', "$title");
                    $s->bindValue(':details', "$details");
                    $s->execute();
                }
                catch (PDOException $e) {
                    echo "Coundnot add step" . $e->getMessage();
                }
            }
            else { // Update
                $title = $_POST['slide_title'];
                $details = $_POST['slide_details'];

                try {
                    $sql = "UPDATE " . $_SESSION['title'] . " SET title=:title, details=:details WHERE stepid=:stepid";
                    $s = $conn->prepare($sql);
                    $s->bindValue(':stepid', "$curstep");
                    $s->bindValue(':title', "$title");
                    $s->bindValue(':details', "$details");
                    $s->execute();
                }
                catch (PDOException $e) {
                    echo "Coundnot update step" . $e->getMessage();
                }
            }
        } catch (PDOException $e) {
            echo "Couldn't not select from table: " . $e->getMessage();
        }

        $_SESSION["slide_number"] = $_SESSION["slide_number"] + 1;
        include "../form.html.php";
    }
    else if ($_POST['action'] == "Previous slide") {

        $_SESSION["slide_number"] = $_SESSION["slide_number"] - 1;
        include "../form.html.php";

    }
    else if ($_POST['action'] == "Finish")
    {
        $_SESSION['slide_number'] = $_POST['slide_number'];
        $curstep = $_SESSION['slide_number'];

        // Update the final step

        try {
            $sql = "SELECT * FROM " . $_SESSION['title'] . " WHERE stepid=" . $curstep;
            $result = $conn->query($sql);
            $rows = $result->fetchAll();
            if (count($rows) == 0) { // Create new
                $title = $_POST['slide_title'];
                $details = $_POST['slide_details'];

                try {
                    $sql = "INSERT INTO " . $_SESSION['title'] . " VALUES (:stepid, :title, :details)";
                    $s = $conn->prepare($sql);
                    $s->bindValue(':stepid', "$curstep");
                    $s->bindValue(':title', "$title");
                    $s->bindValue(':details', "$details");
                    $s->execute();
                }
                catch (PDOException $e) {
                    echo "Coundnot add step" . $e->getMessage();
                }
            }
            else { // Update
                $title = $_POST['slide_title'];
                $details = $_POST['slide_details'];

                try {
                    $sql = "UPDATE " . $_SESSION['title'] . " SET title=:title, details=:details WHERE stepid=:stepid";
                    $s = $conn->prepare($sql);
                    $s->bindValue(':stepid', "$curstep");
                    $s->bindValue(':title', "$title");
                    $s->bindValue(':details', "$details");
                    $s->execute();
                }
                catch (PDOException $e) {
                    echo "Coundnot update step" . $e->getMessage();
                }
            }
        } catch (PDOException $e) {
            echo "Couldn't not select from table: " . $e->getMessage();
        }

        // Write output

        $header_file = fopen('tutorial_header.html', 'r') or die("Cannot open header file");
        $html = fread($header_file, filesize("tutorial_header.html"));
        fclose($header_file);
        $html = $html .
            "\n<title>" . $tutorialTitle . "</title></head>" .
            "\n<body class='impress-not-supported'>" .
            "\n<div id='impress'>";

        $sql = "SELECT * FROM " . $_SESSION['title'];
        $result = $conn->query($sql);
        while ($row = $result->fetch()) {
            $slide_html =
                "\n<div class='step slide' data-x='0' data-y='".($row['stepid'] * $step)."'>" .
                "\n<h1 style='font-weight:bold;text-align:center;'>" . $row['title'] . "</h1>" . 
                "\n" . $row['details'] .
                "\n</div>";
            $html = $html . "\n" . $slide_html;
        }

        $footer_file = fopen('tutorial_footer.html', 'r');
        $footer_html = fread($footer_file, filesize("tutorial_footer.html"));
        $html = $html .
            "\n\n" . $footer_html;
        fclose($footer_file);

        $tutorial_file = fopen($_SESSION['tutorial_filename'], 'w') or die("Cannot open tutorial file");
        fwrite($tutorial_file, $html);
        fclose($tutorial_file);


        // Delete table

        $sql = "DROP TABLE " . $_SESSION['title'];
        try {
            $conn->exec($sql);
        } catch (PDOException $e) {
            echo "Cannot delete table: " . $e->getMessage();
        }

        // Unset SESSION

        $tutorial_filename = $_SESSION['tutorial_filename'];
        session_unset();

        header('Location: ' . $tutorial_filename);
    }
    else if ($_POST['action'] == "Cancel")
    {
        unlink($_SESSION['tutorial_filename']);
        include "../start.html.php";

        $sql = "DROP TABLE " . $_SESSION['title'];
        try {
            $conn->exec($sql);
        }
        catch (PDOException $e) {
            echo "Cannot delete table: " . $e->getMessage();
        }

        session_unset();       
    }
    else
    {
        include "../form.html.php";
    }
}
else
{
    include "../start.html.php";
}

require_once "../disconnect.php";

?>
