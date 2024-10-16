<?php
include("../../includes/db.php");

if (!$conx) {
    die("Conexión fallida: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conx->prepare("DELETE FROM noticias WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Noticia eliminada exitosamente.";
    } else {
        echo "Error al eliminar la noticia: " . $stmt->error;
    }

    $stmt->close();
}

$conx->close();
?>
<a href="listado_noticia.php">Volver al listado de noticias</a>
