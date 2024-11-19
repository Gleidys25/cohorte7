<?php
// Establecer los encabezados para permitir el uso de JSON
header('Content-Type: application/json');

// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Obtener el cuerpo de la solicitud (JSON)
$input = json_decode(file_get_contents('php://input'), true);

// Verificar si los parámetros 'id', 'nombre' y 'apellido1' están presentes en el JSON
if (isset($input['id']) && isset($input['nombre']) && isset($input['apellido1'])) {
    $id = filter_var($input['id'], FILTER_SANITIZE_STRING);
    $nombre = filter_var($input['nombre'], FILTER_SANITIZE_STRING);
    $apellido1 = filter_var($input['apellido1'], FILTER_SANITIZE_STRING);
    $telefono = isset($input['telefono']) ? filter_var($input['telefono'], FILTER_SANITIZE_STRING) : null;

    // Preparar la consulta SQL para actualizar los datos de la persona
    $sql = "UPDATE personas SET nombre = ?, apellido1 = ?, telefono = ? WHERE id = ?";

    // Preparar la sentencia
    $stmt = $connect->prepare($sql);

    // Verificar si la preparación fue exitosa
    if ($stmt === false) {
        echo json_encode(["error" => "Error en la preparación de la consulta: " . $connect->error]);
        exit;
    }

    // Enlazar los parámetros con los placeholders de la consulta SQL
    $stmt->bind_param("ssss", $nombre, $apellido1, $telefono, $id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode(["message" => "Persona actualizada con éxito."]);
    } else {
        echo json_encode(["error" => "Error al actualizar la persona: " . $stmt->error]);
    }

    // Cerrar la sentencia y la conexión
    $stmt->close();
    $connect->close();
} else {
    echo json_encode(["error" => "El parámetro 'id', 'nombre' y 'apellido1' son obligatorios."]);
}
?>