<?php

// ==========================================
// 1. CONECTAR CON LA BASE DE DATOS
// ==========================================

require_once "conexion.php";

// ==========================================
// 2. COMPROBAR EL ENVÍO DEL FORMULARIO
// ==========================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Acceso no válido.");
}

// ==========================================
// 3. RECIBIR LOS DATOS
// ==========================================

$nombre = trim($_POST["nombre"] ?? "");
$correo = trim($_POST["correo"] ?? "");
$tema = trim($_POST["tema"] ?? "");
$mensaje = trim($_POST["mensaje"] ?? "");

// ==========================================
// 4. VALIDAR LOS DATOS
// ==========================================

if ($nombre === "") {
    exit("Error: Escribe tu nombre.");
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    exit("Error: Verifica tu correo electrónico.");
}

if ($tema === "") {
    exit("Error: Selecciona un tema.");
}

if ($mensaje === "") {
    exit("Error: Escribe tu sugerencia.");
}

// ==========================================
// 5. PREPARAR LA CONSULTA SQL
// ==========================================

$sql = "INSERT INTO contactos
        (nombre, correo, tema, mensaje)
        VALUES (?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    exit("Error SQL: " . $conexion->error);
}

// ==========================================
// 6. VINCULAR LOS CUATRO DATOS
// ==========================================

$stmt->bind_param(
    "ssss",
    $nombre,
    $correo,
    $tema,
    $mensaje
);

// ==========================================
// 7. GUARDAR EN LA BASE DE DATOS
// ==========================================

if ($stmt->execute()) {

    ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>¡Gracias por participar! | CECyMagic</title>

        <link rel="stylesheet" href="estilos.css">
    </head>

    <body class="pagina-confirmacion">

        <main class="confirmacion-contenedor">

            <section class="confirmacion-tarjeta">

                <div class="confirmacion-icono">
                    <span>✓</span>
                </div>

                <p class="confirmacion-etiqueta">
                    CECyMagic Valle de Bravo
                </p>

                <h1>¡Gracias por tu participación!</h1>

                <h2>¡Tu opinión es importante!</h2>

                <p class="confirmacion-mensaje">
                    Tu sugerencia se guardó correctamente.
                </p>

                <p class="confirmacion-descripcion">
                    Gracias por colaborar con CECyMagic Valle de Bravo.
                    Tu participación nos ayuda a compartir y preservar
                    la riqueza de nuestra comunidad.
                </p>

                <div class="confirmacion-botones">

                    <a href="contacto.html" class="boton-regresar">
                        ← Volver al formulario
                    </a>

                    <a href="listar.php" class="boton-consultar">
                        Consultar sugerencias
                    </a>

                </div>

                <div class="confirmacion-pie">
                    Conoce · Comparte · Conserva
                </div>

            </section>

        </main>

    </body>
    </html>

    <?php

} else {

    echo "Error al guardar la sugerencia: " . $stmt->error;

}

// ==========================================
// 8. CERRAR LA CONEXIÓN
// ==========================================

$stmt->close();

$conexion->close();

?>

