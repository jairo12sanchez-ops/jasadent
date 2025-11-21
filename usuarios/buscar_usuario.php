<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "jasadentbd");

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

$numero_documento = isset($_GET['numero_documento']) ? $_GET['numero_documento'] : '';

if (empty($numero_documento)) {
    echo json_encode(['success' => false, 'error' => 'Número de documento requerido']);
    $conn->close();
    exit;
}

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE numero_documento = ?");
$stmt->bind_param("s", $numero_documento);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    // No devolver la contraseña por seguridad
    unset($usuario['password']);
    echo json_encode(['success' => true, 'usuario' => $usuario]);
} else {
    echo json_encode(['success' => false, 'error' => 'Usuario no encontrado']);
}

$stmt->close();
$conn->close();
?>
