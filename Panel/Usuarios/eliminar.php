<?php
$id = $_GET["id"];
include_once("../../includes/db.php");
$sentencia = $conx->prepare("DELETE FROM usuarios WHERE id = ?");
$sentencia->bind_param("i", $id);
$sentencia->execute();
header("Location: listado.php");
?>
