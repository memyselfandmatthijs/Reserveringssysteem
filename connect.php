<?php
$servername = "sql.hosted.hro.nl";
$username = "1013008";
$password = "hashooyi";
$database = "1013008";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

