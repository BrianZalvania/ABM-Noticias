<?php 
session_start();

// Verificar si el usuario no está logueado
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>

<?php
include("../../includes/db.php");

if (!$conx) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Preparar la consulta para obtener noticias con información del usuario y categoría
$stmt = $conx->prepare("
    SELECT noticias.id, noticias.titulo, noticias.descripcion, noticias.texto, noticias.imagen, noticias.fecha, 
           noticias.id_usuarios, noticias.id_categorias, 
           CONCAT(usuarios.nombre, ' ', usuarios.apellido) AS usuario, 
           categorias.nombre AS categoria 
    FROM noticias 
    JOIN usuarios ON noticias.id_usuarios = usuarios.id
    JOIN categorias ON noticias.id_categorias = categorias.id
");

$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Noticias</title>
    <link rel="stylesheet" href="../../includes/CSS/estilo.css">
    <link rel="stylesheet" type="text/css" href="CSS/menu.css">
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f9f1;
            display: flex;
        }

        /* Estilos del menú lateral */
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

        /* Contenedor principal */
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

        /* Estilo de la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #4CAF50;
            text-align: left;
        }

        th, td {
            padding: 8px; /* Reduce el padding para un tamaño más pequeño */
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        /* Botón de volver */
        a.volver {
            display: inline-block;
            margin-top: 20px;
            background-color: #555;
            color: white;
            padding: 10px;
            text-decoration: none;
            border-radius: 3px;
        }

        a.volver:hover {
            background-color: #333;
        }

        /* Estilo para la imagen de la noticia */
        img {
            width: 100px;
            height: auto;
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
            <li><a href="../Usuarios/listado.php">Usuarios</a></li>
            <li><a href="../cerrarSesion.php">Cerrar Sesión</a></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div class="contenido">
        <h1>Listado de Noticias</h1>
        <a href="nueva_noticia.php" class="button">Agregar nueva Noticia</a>
        <a href="../index.php" class="volver">Volver a la página principal</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Texto</th>
                    <th>Imagen</th>
                    <th>Fecha</th>
                    <th>ID Usuario</th> <!-- Nueva columna para id_usuario -->
                    <th>Usuario</th> 
                    <th>ID Categoría</th> <!-- Nueva columna para id_categoria -->
                    <th>Categoría</th> 
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($fila = $resultado->fetch_object()) { ?>
                <tr>
                    <td><?php echo $fila->id; ?></td>
                    <td><?php echo $fila->titulo; ?></td>
                    <td><?php echo $fila->descripcion; ?></td>
                    <td><?php echo (strlen($fila->texto) > 100 ? substr($fila->texto, 0, 50) . '...' : $fila->texto); ?></td> <!-- Recorta el texto -->
                    <td><img src="<?php echo $fila->imagen; ?>" alt="Imagen de la noticia"></td> 
                    <td><?php echo date('d/m/Y', strtotime($fila->fecha)); ?></td>
                    <td><?php echo $fila->id_usuarios; ?></td> <!-- Mostrar id_usuario -->
                    <td><?php echo $fila->usuario; ?></td> 
                    <td><?php echo $fila->id_categorias; ?></td> <!-- Mostrar id_categoria -->
                    <td><?php echo $fila->categoria; ?></td> 
                    <td>
                        <a href="editar_noticia.php?id=<?php echo $fila->id; ?>">Editar</a> |
                        <a href="eliminar_noticia.php?id=<?php echo $fila->id; ?>">Eliminar</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        
    </div>
    
</body>
</html>
