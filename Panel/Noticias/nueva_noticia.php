<?php
include("../../includes/db.php");
session_start();

// Verificar conexión a la base de datos
if (!$conx) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Obtener datos de usuarios y categorías
$usuarios = $conx->query("SELECT id, nombre, apellido FROM usuarios");
$categorias = $conx->query("SELECT id, nombre FROM categorias");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nueva Noticia</title>
    <link rel="stylesheet" href="../../includes/CSS/estilo.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f9f1;
            display: flex;
        }
        .menu {
            height: 100vh;
            width: 200px;
            background-color: #f9fff9;
            border-right: 1px solid #4CAF50;
            padding-top: 20px;
        }
        .contenido {
            padding: 20px;
            margin-left: 220px;
            width: calc(100% - 220px);
        }
        h1 {
            color: #4CAF50;
            text-align: center;
        }
        form {
            background-color: #f9fff9;
            border: 1px solid #4CAF50;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], input[type="date"], textarea, select, input[type="file"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #4CAF50;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .volver {
            display: inline-block;
            margin-top: 20px;
            background-color: #555;
            color: white;
            padding: 10px;
            text-decoration: none;
            border-radius: 3px;
        }
    </style>
</head>
<body>

    <div class="menu">
        <ul>
            <li><a href="/programacion/abmnoticias/Panel/Noticias/listado_noticia.php">Noticias</a></li>
            <li><a href="/programacion/abmnoticias/Panel/Categorias/listado_categorias.php">Categorías</a></li>
            <li><a href="/programacion/abmnoticias/Panel/Usuarios/listado.php">Usuarios</a></li>
            <li><a href="/programacion/abmnoticias/cerrarSesion.php">Cerrar Sesión</a></li>
        </ul>
    </div>

    <div class="contenido">
        <h1>Agregar Nueva Noticia</h1>
        
        <form action="guardar_noticia.php" method="post" enctype="multipart/form-data">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" required>

            <label for="descripcion">Descripción:</label>
            <input type="text" name="descripcion" required>

            <label for="texto">Texto:</label>
            <textarea name="texto" required></textarea>

            <label for="imagen">Imagen:</label>
            <input type="file" name="imagen" required>

            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" required>

            <label for="id_usuario">Usuario:</label>
            <select name="id_usuario" required>
                <option value="">Seleccione un usuario</option>
                <?php while ($usuario = $usuarios->fetch_object()) { ?>
                    <option value="<?php echo $usuario->id; ?>"><?php echo $usuario->nombre . " " . $usuario->apellido; ?></option>
                <?php } ?>
            </select>

            <label for="id_categoria">Categoría:</label>
            <select name="id_categoria" required>
                <option value="">Seleccione una categoría</option>
                <?php while ($categoria = $categorias->fetch_object()) { ?>
                    <option value="<?php echo $categoria->id; ?>"><?php echo $categoria->nombre; ?></option>
                <?php } ?>
            </select>

            <button type="submit">Guardar Noticia</button>
        </form>

        <a href="listado_noticia.php" class="volver">Volver al listado de noticias</a>
    </div>

</body>
</html>
