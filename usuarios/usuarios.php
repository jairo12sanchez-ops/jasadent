<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
header('Content-Type: application/json');

try {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (!$data) {
        throw new Exception('Invalid JSON input');
    }

    $conn = new mysqli("localhost", "root", "", "jasadentbd");

    if ($conn->connect_error) {
        throw new Exception('Database connection failed: ' . $conn->connect_error);
    }

    $password = password_hash($data['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuarios (tipo_documento, numero_documento, nombres, apellidos, direccion, telefono, email, password, rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
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
        throw new Exception('Execute failed: ' . $stmt->error);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
