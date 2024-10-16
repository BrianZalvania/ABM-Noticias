<?php
include("../../includes/db.php");

if (!$conx) {
    die("Conexión fallida: " . mysqli_connect_error());
}

$resultado = $conx->query("SELECT * FROM usuarios");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Usuarios</title>
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

    <nav class="menu">
        <ul>
            <li><strong></strong></li>
            <li><a href="/programacion/abmnoticias/Panel/Noticias/listado_noticia.php">Noticias</a></li>
            <li><a href="../Categorias/listado_categorias.php">Categorías</a></li>
            <li><a href="listado.php">Usuarios</a></li>
            <li><a href="../cerrarSesion.php">Cerrar Sesión</a></li>
        </ul>
    </nav>

    <div class="contenido">
        <h1>Listado de Usuarios</h1>
        <a href="nuevo.php" class="button">Agregar nuevo Usuario</a>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($fila = $resultado->fetch_object()) { ?>
                <tr>
                    <td><?php echo $fila->id; ?></td>
                    <td><?php echo $fila->nombre; ?></td>
                    <td><?php echo $fila->apellido; ?></td>
                    <td><?php echo $fila->email; ?></td>
                    <td><?php echo $fila->password; ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo $fila->id; ?>">Editar</a> |
                        <a href="eliminar.php?id=<?php echo $fila->id; ?>">Eliminar</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

        <a href="../index.php" class="volver">Volver a la página principal</a>
    </div>
    
</body>
</html>
