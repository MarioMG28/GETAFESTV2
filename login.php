<?php
$error = ""; // inicializa una variable vacia llamada error

if ($_SERVER["REQUEST_METHOD"] == "POST") { // comprueba si se han enviado los datos
    $user = trim($_POST['usuario'] ?? ''); //recoge un valor, elimina los espacios en blanco sobrantes al inicio y al final con trim(), y previene errores con el operador de fusión ??.
    $pass = trim($_POST['password'] ?? '');

    $archivo = 'usuario.txt'; // Define el nombre del archivo de texto que actua como base de datos.

    if (!file_exists($archivo)) { // verifica si el usuario exixte
        $error = "Error: No existe el archivo usuario.txt"; // sino existe hace esto
    } else {
        $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); // lee el archivo linea por linea
        $encontrado = false; // esto hace que por ahora el nombre sea falso

        foreach ($lineas as $linea) { // va linea por linea mirando
            $partes = explode(':', trim($linea)); // encuentra el nombre y con los dos puntos separa usuario y contraseña
            if (count($partes) >= 2) { // comprueba que tiene 2 partes (usuario y contraseña)
                list($u_db, $p_db) = $partes; // le pone nombres a las 2 partes (u_db = usuario e igual con la password)
                if ($user === trim($u_db) && $pass === trim($p_db)) { // comprueba si es correcto el usuario
                    $encontrado = true;
                    break;
                }
            }
        }

        if ($encontrado) {
            echo '<form id="redirectForm" action="index.php" method="POST">'; // te lleva al index
            echo '<input type="hidden" name="usuario_activo" value="' . htmlspecialchars($user) . '">';
            echo '</form>';
            echo '<script>document.getElementById("redirectForm").submit();</script>';
            exit;
        } else {
            $error = "Usuario o contraseña incorrectos";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - GetaFest</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="card" style="max-width: 400px; width: 100%;">
    <h2>Iniciar Sesión</h2>
    <?php if (!empty($error)) { echo "<div style='background-color: #ef4444; color: white; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 0.9rem;'>$error</div>"; } ?>
    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" required placeholder="Ingresa tu usuario"> //campo obligatorio con texto adicional
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" required placeholder="Ingresa tu contraseña">
        </div>
        <button type="submit" class="btn">Entrar al Sistema</button>
    </form>
</div>
</body>
</html>