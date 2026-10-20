<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "<div class='card'><p>Acceso no permitido.</p><a href='login.php' class='btn'>Volver al login</a></div>";
    exit;
}

$usuario_activo = $_POST['usuario_activo'] ?? '';
$edad = intval($_POST['edad']);

// Validación de edad (< 18 años)
if ($edad < 18) {
    echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><link rel='stylesheet' href='estilos.css'></head><body>";
    echo "<div class='card'>";
    echo "<h2>¡Acceso denegado!</h2>";
    echo "<p>Lo sentimos, el evento es exclusivo para mayores de edad (mínimo 18 años).</p>";
    echo "<form action='formulario_reserva.php' method='POST'>";
    echo "<input type='hidden' name='usuario_activo' value='" . htmlspecialchars($usuario_activo) . "'>";
    echo "<button type='submit' class='btn'>Volver al formulario</button>";
    echo "</form>";
    echo "</div></body></html>";
    exit;
}

$rutaDestino = "";
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $nombreOriginal = $_FILES['foto']['name'];
    $rutaTemporal = $_FILES['foto']['tmp_name'];

    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
    $nombreUnico = 'user_' . uniqid() . '.' . $extension;
    $rutaDestino = "uploads/" . $nombreUnico;

    if (!move_uploaded_file($rutaTemporal, $rutaDestino)) {
        echo "<p>Error al mover la imagen a la carpeta.</p>";
    }
} else {
    echo "<p>No se ha subido ninguna foto o ha ocurrido un error.</p>";
}

$precioBase = 0;
$tipoEntrada = $_POST['tipo_entrada'] ?? '';

if ($tipoEntrada == "50") {
    $precioBase = 50;
    $nombrePase = "General";
} elseif ($tipoEntrada == "120") {
    $precioBase = 120;
    $nombrePase = "VIP";
} elseif ($tipoEntrada == "180") {
    $precioBase = 180;
    $nombrePase = "SuperVIP";
} else {
    $nombrePase = $tipoEntrada;
}

$suplementoDias = 0;
$diasSeleccionados = [];

if (isset($_POST['dias'])) {
    $diasSeleccionados = $_POST['dias'];
    foreach ($diasSeleccionados as $dia) {
        $suplementoDias += 10;
    }
}

$precioTotal = ($precioBase + $suplementoDias) . "€";
$fechaActual = date('Y-m-d H:i:s');
$nombre = trim($_POST['nombre']);
$email = trim($_POST['email']);
$metodoPago = $_POST['metodoPago'] ?? '';
$diasStr = implode(', ', $diasSeleccionados);
$observaciones = trim($_POST['observaciones'] ?? '');

$lineaReserva = "$fechaActual|$nombre|$email|$edad|$nombrePase|$diasStr|$metodoPago|$precioTotal|$rutaDestino|$observaciones\n";
file_put_contents('reservas.txt', $lineaReserva, FILE_APPEND);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva Guardada - GetaFest</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="card profile-card" style="max-width: 500px; width: 100%;">
    <h2>🎉 Acreditación Generada 🎉</h2>

    <?php if (!empty($rutaDestino)): ?>
    <img src='<?php echo htmlspecialchars($rutaDestino); ?>' alt='Foto de perfil' style='width:150px; height:150px; object-fit:cover; border-radius:50%; display: block; margin: 0 auto 15px auto;'>
    <?php endif; ?>

    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre); ?></p>
    <p><strong>Correo:</strong> <?php echo htmlspecialchars($email); ?></p>
    <p><strong>Edad:</strong> <?php echo $edad; ?> años</p>
    <p><strong>Tipo de Entrada:</strong> <?php echo htmlspecialchars($nombrePase); ?></p>

    <p><strong>Días de asistencia:</strong>
        <?php
        if (!empty($diasSeleccionados)) {
        echo implode(", ", $diasSeleccionados);
        } else {
        echo "Ninguno extra";
        }
        ?>
    </p>

    <p><strong>Método de pago:</strong> <?php echo htmlspecialchars($metodoPago); ?></p>
    <?php if (!empty($observaciones)): ?>
    <p><strong>Observaciones:</strong> "<?php echo htmlspecialchars($observaciones); ?>"</p>
    <?php endif; ?>

    <hr style="border: 0; border-top: 1px solid #334155; margin: 15px 0;">
    <p>Precio Base: <?php echo $precioBase; ?> €</p>
    <p>Suplemento Días: <?php echo $suplementoDias; ?> €</p>
    <h3>Precio Total a Pagar: <?php echo $precioTotal; ?></h3>

    <br>
    <div style="display: flex; gap: 10px;">
        <form action="ver_reservas.php" method="POST" style="flex: 1;">
            <input type="hidden" name="usuario_activo" value="<?php echo htmlspecialchars($usuario_activo); ?>">
            <button type="submit" class="btn" style="background-color: #0ea5e9;">Ver Listado</button>
        </form>
        <form action="index.php" method="POST" style="flex: 1;">
            <input type="hidden" name="usuario_activo" value="<?php echo htmlspecialchars($usuario_activo); ?>">
            <button type="submit" class="btn">Volver al inicio</button>
        </form>
    </div>
</div>
</body>
</html>