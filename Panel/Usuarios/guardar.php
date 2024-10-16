<?php
include("../../includes/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos del formulario
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $texto = $_POST['texto'];
    $fecha = $_POST['fecha'];
    $id_usuarios = $_POST['id_usuario'];
    $id_categorias = $_POST['id_categoria'];
    
    // Inicializar la ruta de la imagen
    $ruta_imagen = null;

    // Verificar si se ha subido una nueva imagen
    if (isset($_FILES['nueva_imagen']) && $_FILES['nueva_imagen']['error'] === UPLOAD_ERR_OK) {
        $nombre_imagen = $_FILES['nueva_imagen']['name'];
        $ruta_temporal = $_FILES['nueva_imagen']['tmp_name'];
        $carpeta_destino = "Uploads/";

        // Mover la imagen desde la carpeta temporal a la carpeta de destino
        if (move_uploaded_file($ruta_temporal, $carpeta_destino . $nombre_imagen)) {
            $ruta_imagen = "Uploads/" . $nombre_imagen;
        } else {
            echo "Error al mover la imagen.";
            exit;
        }
    }

    // Verificar si es una actualización o una inserción
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        // Actualizar la noticia existente
        $id_noticia = (int)$_GET['id'];

        // Si no se ha subido una nueva imagen, mantener la imagen existente
        if ($ruta_imagen === null) {
            $consulta_imagen = $conx->query("SELECT imagen FROM noticias WHERE id = $id_noticia");
            if ($consulta_imagen && $fila = $consulta_imagen->fetch_object()) {
                $ruta_imagen = $fila->imagen;
            } else {
                echo "Error al obtener la imagen existente.";
                exit;
            }
        }

        // Actualizar la noticia en la base de datos
        $query = "UPDATE noticias SET titulo = '$titulo', descripcion = '$descripcion', texto = '$texto', imagen = '$ruta_imagen', fecha = '$fecha', id_usuarios = '$id_usuarios', id_categorias = '$id_categorias' WHERE id = $id_noticia";

        if (mysqli_query($conx, $query)) {
            echo "Noticia actualizada exitosamente.";
            header("Location: listado_noticia.php");
            exit;
        } else {
            echo "Error al actualizar la noticia: " . mysqli_error($conx);
        }
    } else {
        // Insertar una nueva noticia
        if ($ruta_imagen === null) {
            echo "Debe subir una imagen para la nueva noticia.";
            exit;
        }

        // Inserción de la nueva noticia
        $query = "INSERT INTO noticias (titulo, descripcion, texto, imagen, fecha, id_usuarios, id_categorias) VALUES ('$titulo', '$descripcion', '$texto', '$ruta_imagen', '$fecha', '$id_usuarios', '$id_categorias')";

        if (mysqli_query($conx, $query)) {
            echo "Noticia guardada exitosamente.";
            header("Location: listado_noticia.php");
            exit;
        } else {
            echo "Error al guardar la noticia: " . mysqli_error($conx);
        }
    }
}
?>
