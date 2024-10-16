<?php
include("../../includes/db.php");

if (!$conx) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Obtener el ID de la noticia desde la URL
$id_noticia = $_GET['id'];

// Consulta para obtener los detalles de la noticia
$consulta = $conx->query("SELECT * FROM noticias WHERE id = $id_noticia");
$noticia = $consulta->fetch_object();

if (!$noticia) {
    die("No se encontró la noticia.");
}

$usuarios = $conx->query("SELECT id, nombre, apellido FROM usuarios");
$categorias = $conx->query("SELECT id, nombre FROM categorias");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Noticia</title>
    <link rel="stylesheet" href="../../includes/CSS/estilo.css">
    <link rel="stylesheet" type="text/css" href="CSS/menu.css">
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

        .menu ul {
            list-style-type: none;
            padding: 0;
        }

        .menu ul li {
            margin-bottom: 10px;
        }

        .menu ul li a {
            text-decoration: none;
            font-weight: bold;
            color: #4CAF50;
            padding: 10px;
            display: block;
            text-align: center;
        }

        .menu ul li a:hover {
            background-color: #4CAF50;
            color: white;
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

        a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Estilo de los formularios */
        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"], input[type="date"], textarea, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #4CAF50;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <!-- Menú de navegación -->
    <nav class="menu">
        <ul>
            <li><strong></strong></li>
            <li><a href="/programacion/abmnoticias/Panel/Noticias/listado_noticia.php">Noticias</a></li>
            <li><a href="../Categorias/listado_categorias.php">Categorías</a></li>
            <li><a href="listado.php">Usuarios</a></li>
            <li><a href="../cerrarSesion.php">Cerrar Sesión</a></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div class="contenido">
        <h1>Editar Noticia</h1>
        <form action="guardar_noticia.php?id=<?php echo $noticia->id; ?>" method="post" enctype="multipart/form-data">

            <label for="titulo">Título:</label>
            <input type="text" name="titulo" value="<?php echo htmlspecialchars($noticia->titulo); ?>" required><br>

            <label for="descripcion">Descripción:</label>
            <input type="text" name="descripcion" value="<?php echo htmlspecialchars($noticia->descripcion); ?>" required><br>

            <label for="texto">Texto:</label>
            <textarea name="texto" required><?php echo htmlspecialchars($noticia->texto); ?></textarea><br> 

            <label for="nueva_imagen">Cambiar Imagen (opcional):</label>
            <input type="file" name="nueva_imagen"><br>
            <?php if ($noticia->imagen) { ?>
                <img src="<?php echo htmlspecialchars($noticia->imagen); ?>" alt="Imagen Actual" style="max-width: 200px;"><br>
                <p>Imagen actual: <?php echo htmlspecialchars($noticia->imagen); ?></p>
            <?php } ?>

            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" value="<?php echo htmlspecialchars($noticia->fecha); ?>" required><br>

            <label for="id_usuario">Usuario:</label>
            <select name="id_usuario" required>
                <option value="">Seleccione un usuario</option>
                <?php while ($usuario = $usuarios->fetch_object()) { ?>
                    <option value="<?php echo $usuario->id; ?>" <?php if($usuario->id == $noticia->id_usuarios) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($usuario->nombre . " " . $usuario->apellido); ?>
                    </option>
                <?php } ?>
            </select><br>

            <label for="id_categoria">Categoría:</label>
            <select name="id_categoria" required>
                <option value="">Seleccione una categoría</option>
                <?php while ($categoria = $categorias->fetch_object()) { ?>
                    <option value="<?php echo $categoria->id; ?>" <?php if($categoria->id == $noticia->id_categorias) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($categoria->nombre); ?>
                    </option>
                <?php } ?>
            </select><br>

            <button type="submit">Guardar Cambios</button>
        </form>
        <div>
            <a href="listado_noticia.php">Volver al listado de noticias</a>
        </div>
    </div>
    
</body>
</html>
