<?php
$conn = new mysqli("localhost", "root", "");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully to MySQL server.<br>";

$result = $conn->query("SHOW DATABASES");
echo "<h3>Available Databases:</h3><ul>";
$found = false;
while($row = $result->fetch_assoc()) {
    echo "<li>" . $row['Database'] . "</li>";
    if ($row['Database'] == 'jasadentdb' || $row['Database'] == 'jasadentbd') {
        $found = $row['Database'];
    }
}
echo "</ul>";

if ($found) {
    echo "<h3>Found database: $found</h3>";
    $conn->select_db($found);
    $result = $conn->query("SHOW TABLES LIKE 'usuarios'");
    if ($result->num_rows > 0) {
        echo "Table 'usuarios' exists in $found.<br>";
        $result = $conn->query("DESCRIBE usuarios");
        echo "<table border='1'><tr><th>Field</th><th>Type</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['Field'] . "</td><td>" . $row['Type'] . "</td></tr>";
        }
        echo "</table>";

        echo "<h3>Latest Users:</h3>";
        $result = $conn->query("SELECT * FROM usuarios ORDER BY id_usuarios DESC LIMIT 5");
        while ($row = $result->fetch_assoc()) {
            echo "ID: " . $row['id_usuarios'] . "<br>";
            echo "Email: " . $row['email'] . "<br>";
            echo "Password Hash: " . substr($row['password'], 0, 20) . "...<br>";
            if (password_get_info($row['password'])['algo']) {
                echo "<strong>Password is hashed.</strong><br>";
            } else {
                echo "<strong>WARNING: Password is NOT hashed.</strong><br>";
            }
            echo "<hr>";
        }
    } else {
        echo "Table 'usuarios' does not exist in $found.<br>";
    }
} else {
    echo "<h3>Neither 'jasadentdb' nor 'jasadentbd' found.</h3>";
}

$conn->close();
?>
