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
    <title>Getafest - Nueva Reserva</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="card" style="max-width: 700px; width: 100%;">
    <h2>🥳 GETAFEST 🥳</h2>
    <p style="font-size: 0.9rem; color: #94a3b8;">Usuario en sesión: <strong><?php echo htmlspecialchars($usuario_activo); ?></strong></p>

    <form method="post" action="procesar.php" enctype="multipart/form-data">
        <!-- Pasar el usuario activo de forma oculta -->
        <input type="hidden" name="usuario_activo" value="<?php echo htmlspecialchars($usuario_activo); ?>">

        <div class="form-group">
            <label for="nombre">Nombre de usuario:</label>
            <input type="text" name="nombre" required placeholder="Ej. Ivan">
        </div>

        <div class="form-group">
            <label for="email">Correo electrónico:</label>
            <input type="text" name="email" required placeholder="tunombre@correo.com">
        </div>

        <div class="form-group">
            <label for="edad">Edad:</label>
            <input type="number" name="edad" min="1" required placeholder="Ej. 20">
        </div>

        <div class="form-group">
            <label>Tipo de entrada:</label>
            <label><input type="radio" name="tipo_entrada" value="50" required> General (50€)</label>
            <label><input type="radio" name="tipo_entrada" value="120"> VIP (120€)</label>
            <label><input type="radio" name="tipo_entrada" value="180"> SuperVIP (180€)</label>
        </div>

        <div class="form-group">
            <label>Días de asistencia (cada día +10 €):</label>
            <label><input type="checkbox" name="dias[]" value="Viernes"> Viernes</label>
            <label><input type="checkbox" name="dias[]" value="Sabado"> Sábado</label>
            <label><input type="checkbox" name="dias[]" value="Domingo"> Domingo</label>
        </div>

        <div class="form-group">
            <label for="metodoPago">Método de pago:</label>
            <select id="metodoPago" name="metodoPago" required>
                <option value="">Selecciona una opción</option>
                <option value="Tarjeta de credito">Tarjeta de crédito</option>
                <option value="Bizum">Bizum</option>
                <option value="Paypal">Paypal</option>
            </select>
        </div>

        <h3>Acreditación</h3>
        <div class="form-group">
            <label for="foto">Selecciona una foto para la acreditación:</label>
            <input type="file" id="foto" name="foto" accept="image/*" required>
        </div>

        <h3>Observaciones</h3>
        <div class="form-group">
            <label for="observaciones">Comentarios o peticiones especiales:</label>
            <textarea id="observaciones" name="observaciones" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #334155; background-color: #0f172a; color: white; box-sizing: border-box;"></textarea>
        </div>

        <input type="submit" class="btn" value="Crear ficha" name="enviar">
    </form>
</div>
</body>
</html>