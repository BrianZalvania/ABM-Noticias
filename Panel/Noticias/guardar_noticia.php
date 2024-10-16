<?php
include("../../includes/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos del formulario
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $texto = $_POST['texto'];
    $fecha = $_POST['fecha'];
    $id_usuarios = $_POST['id_usuario'];
    $id_categorias = $_POST['id_categoria'];
    
    $ruta_imagen = null;

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombre_imagen = $_FILES['imagen']['name'];
        $ruta_temporal = $_FILES['imagen']['tmp_name'];
        $carpeta_destino = "Uploads/";

        // Mover la imagen desde la carpeta temporal a la carpeta de destino
        if (move_uploaded_file($ruta_temporal, $carpeta_destino . $nombre_imagen)) {
            $ruta_imagen = "Uploads/" . $nombre_imagen;
        } else {
            echo "Error al mover la imagen.";
            exit;
        }
    }

    if ($id) {
        $query = "UPDATE noticias SET titulo = ?, descripcion = ?, texto = ?, fecha = ?, id_usuarios = ?, id_categorias = ?";
        if ($ruta_imagen) {
            $query .= ", imagen = ?";
        }
        $query .= " WHERE id = ?";

        $stmt = mysqli_prepare($conx, $query);
        if ($ruta_imagen) {
            mysqli_stmt_bind_param($stmt, "sssssssi", $titulo, $descripcion, $texto, $fecha, $id_usuarios, $id_categorias, $ruta_imagen, $id);
        } else {
            mysqli_stmt_bind_param($stmt, "ssssssi", $titulo, $descripcion, $texto, $fecha, $id_usuarios, $id_categorias, $id);
        }
    } else {
        if (!$ruta_imagen) {
            echo "Debe subir una imagen.";
            exit;
        }

        $query = "INSERT INTO noticias (titulo, descripcion, texto, imagen, fecha, id_usuarios, id_categorias) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conx, $query);
        mysqli_stmt_bind_param($stmt, "sssssss", $titulo, $descripcion, $texto, $ruta_imagen, $fecha, $id_usuarios, $id_categorias);
    }

    if (mysqli_stmt_execute($stmt)) {
        echo "Operación realizada exitosamente.";
        header("Location: listado_noticia.php");
        exit;
    } else {
        echo "Error al ejecutar la operación: " . mysqli_error($conx);
    }

    // Cerrar la consulta
    mysqli_stmt_close($stmt);
}

// Cerrar la conexión
mysqli_close($conx);
?>
