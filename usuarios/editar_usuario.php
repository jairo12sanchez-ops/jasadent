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

// Verificar si se proporcionó el ID del usuario
if (!isset($data['id_usuario']) || empty($data['id_usuario'])) {
    echo json_encode(['success' => false, 'error' => 'ID de usuario requerido para editar']);
    $conn->close();
    exit;
}

$id_usuario = $data['id_usuario'];
$tipo_documento = $data['tipo_documento'];
$numero_documento = $data['numero_documento'];
$nombres = $data['nombres'];
$apellidos = $data['apellidos'];
$direccion = $data['direccion'];
$telefono = $data['telefono'];
$email = $data['email'];
$rol = $data['rol'];

// Construir la consulta SQL dinámicamente dependiendo de si hay contraseña
if (!empty($data['password'])) {
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $sql = "UPDATE usuarios SET tipo_documento=?, numero_documento=?, nombres=?, apellidos=?, direccion=?, telefono=?, email=?, password=?, rol=? WHERE id_usuario=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssi", $tipo_documento, $numero_documento, $nombres, $apellidos, $direccion, $telefono, $email, $password, $rol, $id_usuario);
} else {
    $sql = "UPDATE usuarios SET tipo_documento=?, numero_documento=?, nombres=?, apellidos=?, direccion=?, telefono=?, email=?, rol=? WHERE id_usuario=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssi", $tipo_documento, $numero_documento, $nombres, $apellidos, $direccion, $telefono, $email, $rol, $id_usuario);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Usuario actualizado correctamente']);
} else {
    echo json_encode(['success' => false, 'error' => 'Error al actualizar: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
