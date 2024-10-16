<?php
include("../../includes/db.php");

$id = $_GET["id"];
$sentencia = $conx->prepare("DELETE FROM categorias WHERE id = ?");
$sentencia->bind_param("i", $id);
$sentencia->execute();
header("Location: listado_categorias.php");
?>
