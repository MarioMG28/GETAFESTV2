<?php
$usuario_activo = $_POST['usuario_activo'] ?? '';
$id_reserva = intval($_POST['id'] ?? 0);

if ($usuario_activo !== 'admin') {
    echo "<div class='card' style='max-width:400px; margin: 50px auto; text-align:center;'>";
    echo "<h2>Acceso Denegado</h2>";
    echo "<p>Esta sección es exclusiva para el usuario administrador.</p>";
    echo "<form action='ver_reservas.php' method='POST'>";
    echo "<input type='hidden' name='usuario_activo' value='" . htmlspecialchars($usuario_activo) . "'>";
    echo "<button type='submit' class='btn'>Volver a reservas</button>";
    echo "</form></div>";
    exit;
}

$archivo = 'reservas.txt';
$reservaEncontrada = null;

if (file_exists($archivo)) {
    $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $indice = $id_reserva - 1; // El ID corresponde a la línea del archivo[cite: 4]
    if (isset($lineas[$indice])) {
        $reservaEncontrada = explode('|', $lineas[$indice]);
    }
}

if (!$reservaEncontrada) {
    echo "<div class='card'><p>Reserva no encontrada.</p><a href='ver_reservas.php' class='btn'>Volver</a></div>";
    exit;
}

list($fecha, $nombre, $email, $edad, $pase, $dias, $pago, $total, $foto, $observaciones) = $reservaEncontrada;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acreditación Digital - GetaFest</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="card profile-card" style="max-width: 450px; width: 100%;">
    <h3>DEVMUSIC FEST 2026</h3>
    <p style="font-size: 0.8rem; color: #94a3b8;">Sistema Oficial de Reserva y Acreditación Digital</p>
    <p style="font-size: 0.85rem;">Usuario activo: <strong style="color: #6366f1;"><?php echo htmlspecialchars($usuario_activo); ?></strong></p>

    <hr style="border: 0; border-top: 1px solid #334155; margin: 15px 0;">

    <h4 style="margin-bottom: 15px; color: #38bdf8;">Acreditación #<?php echo $id_reserva; ?> (Vista Administrador)</h4>[cite: 5]

    <?php if (!empty($foto) && file_exists($foto)): ?>
        <img src="<?php echo htmlspecialchars($foto); ?>" alt="Foto del Asistente" style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; display: block; margin: 0 auto 15px auto; border: 2px solid #6366f1;">
    <?php endif; ?>

    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
    <p><strong>Edad:</strong> <?php echo htmlspecialchars($edad); ?> años</p>
    <p><strong>Tipo de Entrada:</strong> <?php echo htmlspecialchars($pase); ?></p>
    <p><strong>Días de asistencia:</strong> <?php echo !empty($dias) ? htmlspecialchars($dias) : "Ninguno extra"; ?></p>
    <p><strong>Método de pago:</strong> <?php echo htmlspecialchars($pago); ?></p>

    <?php if (!empty($observaciones)): ?>
        <p><strong>Observaciones:</strong> "<?php echo htmlspecialchars($observaciones); ?>"</p>
    <?php endif; ?>

    <h3 style="margin-top: 15px; color: #4ade80;">Total: <?php echo htmlspecialchars($total); ?></h3>

    <br>
    <form action="ver_reservas.php" method="POST">
        <input type="hidden" name="usuario_activo" value="<?php echo htmlspecialchars($usuario_activo); ?>">
        <button type="submit" class="btn" style="background-color: #334155;">&larr; Volver al listado de reservas</button>
    </form>
</div>
</body>
</html>