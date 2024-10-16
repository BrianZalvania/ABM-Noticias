<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agregar Nuevo Usuario</title>
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

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #4CAF50;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
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
        <li><a href="/programacion/abmnoticias/Panel/Noticias/listado_noticia.php">Noticias</a></li>
        <li><a href="../Categorias/listado_categorias.php">Categorías</a></li>
        <li><a href="../Usuarios/listado.php">Usuarios</a></li> 
        <li><a href="../cerrarSesion.php">Cerrar Sesión</a></li>
    </ul>
</nav>

    <div class="contenido">
        <h1>Agregar Nuevo Usuario</h1>
        <form action="insertar.php" method="post">
            <div>
                <label>Nombre</label>
                <input type="text" name="nombre" required>
            </div>
            <div>
                <label>Apellido</label>
                <input type="text" name="apellido" required>
            </div>
            <div>
                <label>Email</label>
                <input type="text" name="email" required>
            </div>
            <div>
                <label>Password</label>
                <input type="text" name="password" required>
            </div>
            <button type="submit">Agregar Usuario</button>
        </form>
    </div>
    
</body>
</html>
