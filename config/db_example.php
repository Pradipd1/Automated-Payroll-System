<?php
$conn = new mysqli("localhost", "username", "password", "database_name");

if($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}
?>