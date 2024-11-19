<?php

include('Conexion.php');


$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
$nombre2 = filter_input(INPUT_POST, 'nombre2', FILTER_SANITIZE_STRING);
$apellido1 = filter_input(INPUT_POST, 'apellido1', FILTER_SANITIZE_STRING);
$apellido2 = filter_input(INPUT_POST, 'apellido2', FILTER_SANITIZE_STRING);
$direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING);
$telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);





if (
    $id && $nombre && $nombre2 && $apellido1 && $apellido2 &&
    $direccion && $telefono 
) {
    
    $id = strtoupper($id);
    $nombre = strtoupper($nombre);
    $nombre2 = strtoupper($nombre2);
    $apellido1 = strtoupper($apellido1);
    $apellido2 = strtoupper($apellido2);
    $direccion = strtoupper($direccion);
    $telefono = strtoupper($telefono);
   

   
    $query = "INSERT INTO personas (id, nombre, nombre2, apellido1, apellido2, direccion, telefono) 
    VALUES (?, ?, ?, ?, ?, ?, ?)";

   
    if ($stmt = $connect->prepare($query)) {
       
        $stmt->bind_param(
            "sssssss", 
            $id,
            $nombre,
            $nombre2,
            $apellido1,
            $apellido2,
            $direccion,
            $telefono,
          
        );

       
        if ($stmt->execute()) {
           
            echo json_encode(array('status' => 'success', 'message' => 'Registro exitoso'));
        } else {
            
            echo json_encode(array('status' => 'error', 'message' => 'Error al registrar los datos: ' . $stmt->error));
        }

        $stmt->close();
    } else {
       
        echo json_encode(array('status' => 'error', 'message' => 'Error al preparar la consulta: ' . $connect->error));
    }
} else {
   
    echo json_encode(array('status' => 'error', 'message' => 'Los datos ingresados no son válidos.'));
}


$connect->close();
?>
