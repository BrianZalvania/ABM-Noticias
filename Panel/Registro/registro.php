<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexión a la base de datos
    $conx = new mysqli("localhost", "root", "", "base");

    if ($conx->connect_error) {
        die("Conexión fallida: " . $conx->connect_error);
    }

    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    // Insertar usuario en la base de datos
    $stmt = $conx->prepare("INSERT INTO usuarios (nombre, apellido, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $apellido, $email, $contraseña);

    if ($stmt->execute()) {
        echo "Registro exitoso. Ahora puedes <a href='login.php'>iniciar sesión</a>.";
    } else {
        echo "Error al registrarse: " . $stmt->error;
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
    <title>Registro</title>
    <link rel="stylesheet" href="../../includes/CSS/registro.css">
</head>
<body>
    <div class="registro-form">
     <img src="../../logo-UTN-1.png" alt="Logo" class="logo">
    <h2>Registro</h2>
    <form method="POST" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required><br>

        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required><br>

        <button type="submit">Registrarse</button>
    </form>
</body>
</html>
