<?php
$usuario_activo = $_POST['usuario_activo'] ?? '';
if (empty($usuario_activo)) {
    header("Location: login.php");
    exit;
}

$archivo = 'reservas.txt';
$reservas = [];
if (file_exists($archivo)) {
    $reservas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Reservas - GetaFest</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 0.9rem; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #334155; }
        th { background-color: #0f172a; }
        .btn-accion { background-color: #0ea5e9; color: white; padding: 6px 10px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; text-decoration: none; display: inline-block; }
        .btn-accion:hover { filter: brightness(1.2); }
    </style>
</head>
<body>
<div class="card" style="max-width: 1000px; width: 100%;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
        <h2>📋 Listado de Reservas</h2>
        <form action="formulario_reserva.php" method="POST">
            <input type="hidden" name="usuario_activo" value="<?php echo htmlspecialchars($usuario_activo); ?>">
            <button type="submit" class="btn" style="width: auto; padding: 8px 15px;">+ Nueva Reserva</button>
        </form>
    </div>
    <p style="font-size: 0.85rem; color: #94a3b8;">Usuario en sesión: <strong><?php echo htmlspecialchars($usuario_activo); ?></strong></p>

    <div style="overflow-x: auto;">
        <table>
            <tr>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Edad</th>
                <th>Pase</th>
                <th>Pago</th>
                <th>Total</th>
                <th>Acción Admin</th>
            </tr>
            <?php
            if (empty($reservas)) {
                echo "<tr><td colspan='8' style='text-align: center; color: #94a3b8;'>No hay reservas registradas todavía.</td></tr>";
            } else {
                foreach ($reservas as $index => $linea) {
                    $datos = explode('|', $linea);
                    if (count($datos) >= 8) {
                        $id_reserva = $index + 1; // ID correlativo basado en la línea[cite: 4]
                        echo "<tr>";
                        echo "<td>{$datos[0]}</td>";
                        echo "<td>" . htmlspecialchars($datos[1]) . "</td>";
                        echo "<td>" . htmlspecialchars($datos[2]) . "</td>";
                        echo "<td>{$datos[3]}</td>";
                        echo "<td>" . htmlspecialchars($datos[4]) . "</td>";
                        echo "<td>" . htmlspecialchars($datos[6]) . "</td>";
                        echo "<td>{$datos[7]}</td>";
                        echo "<td>
                                    <form action='ver_pase.php' method='POST' style='display:inline;'>
                                        <input type='hidden' name='usuario_activo' value='" . htmlspecialchars($usuario_activo) . "'>
                                        <input type='hidden' name='id' value='{$id_reserva}'>
                                        <button type='submit' class='btn-accion'>Ver Pase</button>
                                    </form>
                                  </td>";
                        echo "</tr>";
                    }
                }
            }
            ?>
        </table>
    </div>

    <br>
    <form action="index.php" method="POST">
        <input type="hidden" name="usuario_activo" value="<?php echo htmlspecialchars($usuario_activo); ?>">
        <button type="submit" class="btn" style="background-color: #334155; width: auto; padding: 8px 15px;">&larr; Volver al Panel</button>
    </form>
</div>
</body>
</html>