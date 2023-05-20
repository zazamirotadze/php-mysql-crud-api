<?php
// Connect to the database
$host = "localhost"; // Replace with your host name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "phptoturial"; // Replace with your database name

$con = mysqli_connect($host, $username, $password, $dbname);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
