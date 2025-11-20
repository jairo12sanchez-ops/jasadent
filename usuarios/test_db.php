<?php
$conn = new mysqli("localhost", "root", "", "jasadentdb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully\n";

$result = $conn->query("SHOW TABLES LIKE 'usuarios'");
if ($result->num_rows > 0) {
    echo "Table 'usuarios' exists\n";
    $result = $conn->query("DESCRIBE usuarios");
    while($row = $result->fetch_assoc()) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
} else {
    echo "Table 'usuarios' does not exist\n";
}
$conn->close();
?>
