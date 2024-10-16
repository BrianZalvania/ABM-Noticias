<?php
include_once("../../includes/db.php");

if (isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["email"]) && isset($_POST["password"])) {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
        die("La contraseña debe tener al menos 8 caracteres, incluir letras y números.");
    }

    $sentencia = $conx->prepare("INSERT INTO usuarios (nombre, apellido, email, password) VALUES (?, ?, ?, ?)");
    $sentencia->bind_param("ssss", $nombre, $apellido, $email, $password);
    $sentencia->execute();
    header("Location: listado.php");
} else {
    echo "Faltan datos necesarios.";
}
?>
