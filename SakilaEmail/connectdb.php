<?php

$servername = "localhost";
$username = "root";
$password = "root";
$my_db = "sakila";


// Create connection
$conn = new mysqli($servername, $username, $password, $my_db);

// Check connection
if (mysqli_connect_errno()) {
  die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully!";
?>