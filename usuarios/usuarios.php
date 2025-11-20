<?php
$data = json_decode(file_get_contents("php://input"), true);

$conn = new mysqli("localhost", "root", "", "jasadentdb");

$sql = "INSERT INTO usuarios (tipo_documento, numero_documento, nombres, apellidos, direccion, telefono, email, rol)
        VALUES (
            '{$data['tipo_documento']}',
            '{$data['numero_documento']}',
            '{$data['nombres']}',
            '{$data['apellidos']}',
            '{$data['direccion']}',
            '{$data['telefono']}',
            '{$data['email']}',
            '{$data['rol']}'
        )";
if($conn->query($sql) === TRUE){
    echo json_encode(['success' => true, 'id_usuario' => $conn->insert_id]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}
$conn->close();
?>
