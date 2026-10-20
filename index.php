<?php
$usuario_activo = $_POST['usuario_activo'] ?? '';

if (empty($usuario_activo)) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel - GetaFest 2026</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="card" style="max-width: 600px; width: 100%; text-align: center;">
    <h2 style="background-color: lightgreen">🥳 GETAFEST 2026 🥳</h2>
    <p>Sistema Oficial de Reserva y Acreditación Digital</p>
    <p>Usuario activo: <strong><?php echo htmlspecialchars($usuario_activo); ?></strong></p>

    <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
        <form action="ver_reservas.php" method="POST">
            <input type="hidden" name="usuario_activo" value="<?php echo htmlspecialchars($usuario_activo); ?>">
            <button type="submit" class="btn" style="background-color: #0ea5e9;">Consultar Reservas</button>
        </form>

        <form action="formulario_reserva.php" method="POST">
            <input type="hidden" name="usuario_activo" value="<?php echo htmlspecialchars($usuario_activo); ?>">
            <button type="submit" class="btn">+ Nueva Reserva</button>
        </form>
    </div>
    <br><br>
    <a href="login.php" style="color: #94a3b8; text-decoration: none; font-size: 0.9rem;">Cerrar Sesión</a>
</div>
</body>
</html>