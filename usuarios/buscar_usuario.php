<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
header('Content-Type: application/json');

try {
    $conn = new mysqli("localhost", "root", "", "jasadentbd");

    if ($conn->connect_error) {
        throw new Exception('Database connection failed: ' . $conn->connect_error);
    }

    $numero_documento = isset($_GET['numero_documento']) ? $_GET['numero_documento'] : '';

    if (empty($numero_documento)) {
        $conn->close();
        throw new Exception('Número de documento requerido');
    }

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE numero_documento = ?");
    
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }

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

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
