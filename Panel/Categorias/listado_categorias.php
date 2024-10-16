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

$resultado = $conx->query("SELECT * FROM categorias");

?>
<!DOCTYPE html>
<html>
<head>
    <title>Listado de Categorías</title>
    <link rel="stylesheet" href="../../includes/CSS/estilo.css">
    <link rel="stylesheet" type="text/css" href="CSS/menu.css">
    <style>
        /* Estilos para la barra lateral */
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f9f1;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .menu {
            height: 100vh; /* Altura completa de la ventana */
            width: 200px; /* Ancho de la barra lateral */
            background-color: #f9fff9;
            border-right: 1px solid #4CAF50;
            position: fixed;
            top: 0;
            left: 0;
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

        /* Contenedor principal para ajustar el contenido */
        .container {
            margin-left: 220px;
            padding: 20px;
            width: calc(100% - 220px);
        }

        /* Encabezado */
        h1 {
            color: #4CAF50;
            text-align: center;
        }

        /* Botón de agregar nueva categoría */
        a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Estilo para las tablas */
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
            padding: 12px;
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

    <div class="container">
        <h1>Listado de Categorías</h1>
        <a href="nueva_categoria.php" class="button">Agregar Nueva Categoría</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
            <?php while ($fila = $resultado->fetch_object()) { ?>
                <tr>
                    <td><?php echo $fila->id; ?></td>
                    <td><?php echo $fila->nombre; ?></td>
                    <td>
                        <a href="editar_categoria.php?id=<?php echo $fila->id; ?>">Editar</a> |
                        <a href="eliminar_categoria.php?id=<?php echo $fila->id; ?>">Eliminar</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <a href="../index.php" class="volver">Volver a la página principal</a>
    </div>
    
</body>
</html>
