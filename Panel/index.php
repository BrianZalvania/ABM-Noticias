<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>

<?php
include("../includes/db.php");


// Consulta de noticias
$resultNoticias = mysqli_query($conx, 'SELECT * FROM Noticias');
if (!$resultNoticias) {
    die('Error en la consulta de noticias: ' . mysqli_error($conx));
}

// Consulta de usuarios
$resultUsuarios = mysqli_query($conx, 'SELECT * FROM Usuarios');
if (!$resultUsuarios) {
    die('Error en la consulta de usuarios: ' . mysqli_error($conx));
}

// Consulta de categorías
$resultCategorias = mysqli_query($conx, 'SELECT * FROM Categorias');
if (!$resultCategorias) {
    die('Error en la consulta de categorías: ' . mysqli_error($conx));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Noticias</title>
    <link rel="stylesheet" href="CSS/menu.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f9f1;
            display: flex;
        }

        /* Menú de navegación */
        .menu {
            width: 200px;
            background-color: #f9fff9;
            border-right: 1px solid #4CAF50;
            padding-top: 20px;
            height: 100vh;
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
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        h1 {
            font-size: 3em;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.5em;
            color: #333;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.2em;
        }

        .btn:hover {
            background-color: #388E3C;
        }
    </style>
</head>
<body>

    <nav class="menu">
        <ul>
            <li><strong></strong></li>
            <li><a href="/programacion/abmnoticias/Panel/Noticias/listado_noticia.php">Noticias</a></li>
            <li><a href="Categorias/listado_categorias.php">Categorías</a></li>
            <li><a href="Usuarios/listado.php">Usuarios</a></li>
            <li><a href="cerrarSesion.php">Cerrar Sesión</a></li>
        </ul>
    </nav>

    <div class="contenido">
        <div>
            <h1>Bienvenido al Panel Administrativo</h1>
            <p>Seleccione una opción del menú para comenzar.</p>
            <a href="/programacion/abmnoticias/frontend.php" class="btn">Ver Página Web</a>
        </div>
    </div>

</body>
</html>
