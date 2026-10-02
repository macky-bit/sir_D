<?php

$servername = "db_server";
$username = "root";
$password = "root";
$database = "db_food_festive";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
