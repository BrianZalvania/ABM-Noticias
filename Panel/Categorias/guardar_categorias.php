<?php
include("../../includes/db.php");

if (isset($_POST["nombre"])) {
    $nombre = $_POST["nombre"];
    $sentencia = $conx->prepare("INSERT INTO categorias (nombre) VALUES (?)");
    $sentencia->bind_param("s", $nombre);
    $sentencia->execute();
    header("Location: listado_categorias.php");
}
?>
