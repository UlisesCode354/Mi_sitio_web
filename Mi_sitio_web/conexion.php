<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "cecy_magic";

// Crear la conexión con MySQL
$conexion = new mysqli(
    $servidor,
    $usuario,
    $contrasena,
    $base_datos
);

// Comprobar si existe un error
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Configurar los caracteres para español
$conexion->set_charset("utf8mb4");
?>