<?php

$servername = $OPENSHIFT_MYSQL_DB_URL;
$databasename = "impresstutorial";
$username = $OPENSHIFT_MYSQL_DB_USERNAME;
$password = $OPENSHIFT_MYSQL_DB_PASSWORD;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>
