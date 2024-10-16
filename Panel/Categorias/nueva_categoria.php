<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nueva Categoría</title>
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

        input[type="text"] {
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

    <nav class="menu">
        <ul>
            <li><strong></strong></li>
            <li><a href="/listado_noticia.php">Noticias</a></li>
            <li><a href="/listado_categorias.php">Categorías</a></li>
            <li><a href="/listado.php">Usuarios</a></li>
            <li><a href="../cerrarSesion.php">Cerrar Sesión</a></li>
        </ul>
    </nav>

    <div class="contenido">
        <h1>Nueva Categoría</h1>
        <form action="guardar_categorias.php" method="post">
            <label>Nombre:</label>
            <input type="text" name="nombre" required>
            <button type="submit">Guardar</button>
        </form>
    </div>
    
</body>
</html>
