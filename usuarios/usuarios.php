<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(['success' => false, 'error' => 'Invalid JSON input']);
    exit;
}

$conn = new mysqli("localhost", "root", "", "jasadentbd");

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

$password = password_hash($data['password'], PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO usuarios (tipo_documento, numero_documento, nombres, apellidos, direccion, telefono, email, password, rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    echo json_encode(['success' => false, 'error' => 'Prepare failed: ' . $conn->error]);
    $conn->close();
    exit;
}

$stmt->bind_param("sssssssss", 
    $data['tipo_documento'],
    $data['numero_documento'],
    $data['nombres'],
    $data['apellidos'],
    $data['direccion'],
    $data['telefono'],
    $data['email'],
    $password,
    $data['rol']
);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'id_usuario' => $stmt->insert_id]);
} else {
    echo json_encode(['success' => false, 'error' => 'Execute failed: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
