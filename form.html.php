<?php
$curstep = $_SESSION['slide_number'];

require_once "connect.php";

try {
  $sql = "SELECT * FROM " . $_SESSION['title'] . " WHERE stepid=" . $curstep;
  $result = $conn->query($sql);
  $rows = $result->fetchall();
  if (count($rows) == 1) {
    try {
      $sql = "SELECT * FROM " . $_SESSION['title'] . " WHERE stepid=" . $curstep;
      $result = $conn->query($sql);
      $row = $result->fetch();

      $title = $row['title'];
      $details = $row['details'];
    }catch(PDOException $e) {
      echo "Cannot select";
    }
  }
  else {
    $title = "";
    $details = "";
  }
} catch (PDOException $e) {
  echo "Cannot count";
}

?>
<!doctype html>

<html>
  <head>
    <title>Create slides</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <script src="tutorial/js/tinymce/tinymce.min.js"></script>
  <script>
  tinymce.init({ selector: "textarea", plugins: "image" });
  </script>
  </head>

  <body id="body">
    <div class="main-box">
      <h1 class="main-heading">Add slide #<?php echo $_SESSION['slide_number']; ?></h1>

      <p>Your tutorial will be at: <?php echo $_SERVER['HTTP_REFERER'] . $_SESSION['tutorial_filename']; ?></p>

      <form method="post" action=".">
        <p>
        <label for="slide_title">Slite title: </label><br>
        <input type="text" name="slide_title" id="slide_title" style="width:500px;" value="<?php echo $title; ?>">
        </p>

        <p>
        <label for="slide_details">Detailed info: </label><br>
        <textarea rows="10" cols="50" name="slide_details" id="slide_details"><?php echo $details; ?></textarea>
        </p>

        <input type="hidden" name="slide_number" value="<?php echo $_SESSION['slide_number']; ?>">

        <p>
        <input type="submit" value="Previous slide" name="action" <?php if ($curstep < 2) echo 'disabled';?>>
        <input type="submit" value="Next slide" name="action">
        <input type="submit" value="Finish" name="action">
        <input type="submit" value="Cancel" name="action">
        </p>
      </form>
    </div>
  </body>
</html>

<!-- vim:set ts=2 sw=2 et autoindent: -->
