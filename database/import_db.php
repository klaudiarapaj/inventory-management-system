<?php
$host = "localhost";
$username = "root";
$password = "";

// Connect to MySQL
$conn = new mysqli($host, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Load SQL
$sql = file_get_contents(__DIR__ . '/grocery_db.sql');

// Run SQL
if ($conn->multi_query($sql)) {
    do {
        
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->more_results() && $conn->next_result());

    echo "Database imported successfully.";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
