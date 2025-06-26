<?php
// Database connection settings
$servername = "localhost";    // if you're using XAMPP/LAMP, localhost is correct
$username = "root";           // default username for XAMPP is 'root'
$password = "";               // default password for XAMPP MySQL is empty
$database = "graphical_pass"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
