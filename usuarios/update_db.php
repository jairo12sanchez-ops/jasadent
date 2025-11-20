<?php
$conn = new mysqli("localhost", "root", "", "jasadentbd");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if column exists
$result = $conn->query("SHOW COLUMNS FROM usuarios LIKE 'password'");
if ($result->num_rows == 0) {
    $sql = "ALTER TABLE usuarios ADD COLUMN password VARCHAR(255) NOT NULL AFTER email";
    if ($conn->query($sql) === TRUE) {
        echo "Column 'password' added successfully";
    } else {
        echo "Error adding column: " . $conn->error;
    }
} else {
    echo "Column 'password' already exists";
}

$conn->close();
?>
