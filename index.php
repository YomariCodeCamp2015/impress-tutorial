<?php

if (isset($_POST['title'])) {
    echo "Working";
}
else {
    include "start.html";

    echo $_POST['title'];
}

?>
