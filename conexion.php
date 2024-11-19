<?php
$servername = "database-1.cr4ia4cyokmb.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "Daniel0708*"; 
$database = "Cohorte7DB"; 

$connect = new mysqli($servername, $username, $password, $database);

if ($connect->connect_error) {
    die("Error de conexión: " . $connect->connect_error);
}
else {
    echo("conexion exitosa");
}
$connect->set_charset("utf8");


?>
