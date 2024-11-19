<?php
// Establecer los encabezados para permitir el uso de JSON
header('Content-Type: application/json');

// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Obtener el cuerpo de la solicitud (JSON)
$input = json_decode(file_get_contents('php://input'), true);

// Verificar si el parámetro 'id' está presente en el JSON
if (isset($input['id'])) {
    $id = filter_var($input['id'], FILTER_SANITIZE_STRING);

    // Preparar la consulta SQL para eliminar el registro
    $sql = "DELETE FROM personas WHERE id = ?";

    // Preparar la sentencia
    $stmt = $connect->prepare($sql);

    // Verificar si la preparación fue exitosa
    if ($stmt === false) {
        echo json_encode(["error" => "Error en la preparación de la consulta: " . $connect->error]);
        exit;
    }

    // Enlazar el parámetro 'id' con el placeholder de la consulta SQL
    $stmt->bind_param("s", $id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode(["message" => "Persona eliminada con éxito."]);
    } else {
        echo json_encode(["error" => "Error al eliminar la persona: " . $stmt->error]);
    }

    // Cerrar la sentencia y la conexión
    $stmt->close();
    $connect->close();
} else {
    echo json_encode(["error" => "El parámetro 'id' es obligatorio."]);
}
?>