<?php
// Desactivar la visualización de errores en la salida para evitar romper el JSON
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

    // Verificar si se proporcionó el ID del usuario
    if (!isset($data['id_usuario']) || empty($data['id_usuario'])) {
        $conn->close();
        throw new Exception('ID de usuario requerido para editar');
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
        $sql = "UPDATE usuarios SET tipo_documento=?, numero_documento=?, nombres=?, apellidos=?, direccion=?, telefono=?, email=?, password=?, rol=? WHERE id_usuarios=?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception('Prepare failed: ' . $conn->error);
        }
        $stmt->bind_param("sssssssssi", $tipo_documento, $numero_documento, $nombres, $apellidos, $direccion, $telefono, $email, $password, $rol, $id_usuario);
    } else {
        $sql = "UPDATE usuarios SET tipo_documento=?, numero_documento=?, nombres=?, apellidos=?, direccion=?, telefono=?, email=?, rol=? WHERE id_usuarios=?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception('Prepare failed: ' . $conn->error);
        }
        $stmt->bind_param("ssssssssi", $tipo_documento, $numero_documento, $nombres, $apellidos, $direccion, $telefono, $email, $rol, $id_usuario);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Usuario actualizado correctamente']);
    } else {
        throw new Exception('Error al actualizar: ' . $stmt->error);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
