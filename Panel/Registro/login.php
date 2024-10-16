<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexión a la base de datos
    $conx = new mysqli("localhost", "root", "", "base");

    if ($conx->connect_error) {
        die("Conexión fallida: " . $conx->connect_error);
    }

    // Obtener datos del formulario
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    // Buscar el usuario en la base de datos
    $stmt = $conx->prepare("SELECT id, nombre, apellido, password FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Verificar si se encontró el usuario
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $nombre, $apellido, $stored_password);
        $stmt->fetch();

        // Verificar la contraseña
        if ($contraseña === $stored_password) {
            // Iniciar sesión y redirigir al usuario
            $_SESSION['usuario_id'] = $id;
            $_SESSION['usuario_nombre'] = $nombre;
            $_SESSION['usuario_apellido'] = $apellido;
            header("Location: ../../frontend.php");
            exit;
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No se encontró ningún usuario con ese correo.";
    }

    // Cerrar la conexión
    $stmt->close();
    $conx->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../../includes/CSS/registro.css">
</head>
<body>
    <div class="container">
        <img src="../../logo-UTN-1.png" alt="Logo" class="logo">
        <h2>Iniciar Sesión</h2>
        <form method="POST" action="">
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="contraseña">Contraseña:</label>
            <input type="password" id="contraseña" name="contraseña" required><br>

            <button type="submit">Iniciar sesión</button>
            <p>¿No tienes una cuenta? <a href="registro.php">Registrarse</a></p>
        </form>
    </div>
</body>
</html>
