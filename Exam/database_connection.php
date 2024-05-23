<?php
// Connection details
$host = "localhost";
$user = "sibojean";
$pass = "222019374";
$database = "virtual _occupational_therapy_sessions_platform";

// Creating connection
$connection = new mysqli($host, $user, $pass, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}