<!doctype html>

<html>
  <head>
    <title>Create slides</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <script src="tutorial/js/tinymce/tinymce.min.js"></script>
  <script>
  tinymce.init({ selector: "textarea" });
  </script>
  </head>

  <body id="body">
    <div class="main-box">
      <h1 class="main-heading">Add slide #<?php echo $_SESSION['slide_number']; ?></h1>

      <p>Your tutorial will be at: <?php echo $_SERVER['HTTP_REFERER'] . $_SESSION['tutorial_filename']; ?></p>

      <form method="post" action=".">
        <p>
        <label for="slide_title">Slite title: </label><br>
        <input type="text" name="slide_title" id="slide_title" style="width:500px;">
        </p>

        <p>
        <label for="slide_details">Detailed info: </label><br>
        <textarea rows="10" cols="50" name="slide_details" id="slide_details"></textarea>
        </p>

        <input type="hidden" name="slide_number" value="<?php echo $_SESSION['slide_number']; ?>">

        <p>
        <input type="submit" value="Add slide" name="action">
        <input type="submit" value="Finish" name="action">
        <input type="submit" value="Cancel" name="action">
        </p>
      </form>
    </div>
  </body>
</html>

<!-- vim:set ts=2 sw=2 et autoindent: -->
