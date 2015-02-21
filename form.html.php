<!doctype html>

<html>
  <head>
    <title>Create slides</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <script src="http://tinymce.cachefly.net/4.0/tinymce.min.js"></script>
  <script>
  tinymce.init({
  selector: "textarea",
    plugins: [
      "advlist autolink lists link image charmap print preview anchor",
      "searchreplace visualblocks code fullscreen",
      "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
  });
  </script>

<script>
function dump()
{
  window.alert(document.getElementByName('action').value);
}
</script>
  </head>

  <body id="body">
    <div class="main-box">
      <h1 class="main-heading">Add slides</h1>

      <form method="post" action=".">

        <label for="slide_title">Slite title: </label><br>
        <input type="text" name="slide_title" id="slide_title">

        <br>

        <label for="slide_details">Detailed info: </label><br>
        <textarea rows="10" cols="50" name="slide_details" id="slide_details"></textarea>

        <br>

        <input type="hidden" name="slide_number" value="<?php echo $slide_number ?>">

        <input type="button" value="Add slide" name="action" onclick="dump();">
        <input type="button" value="Finish" name="action" onclick="dump();">
      </form>
    </div>
  </body>
</html>

<!-- vim:set ts=2 sw=2 et autoindent: -->
