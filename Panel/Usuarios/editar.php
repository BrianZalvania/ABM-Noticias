<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
include("../../includes/db.php");

$id = $_GET["id"];
$sentencia = $conx->prepare("SELECT * FROM usuarios WHERE id = ?");
$sentencia->bind_param("i", $id);
$sentencia->execute();
$resultado = $sentencia->get_result();
$usuario = $resultado->fetch_object();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Usuario</title>
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
            <li><a href="/programacion/abmnoticias/Panel/Noticias/listado_noticia.php">Noticias</a></li>
            <li><a href="../Categorias/listado_categorias.php">Categorías</a></li>
            <li><a href="listado.php">Usuarios</a></li>
            <li><a href="../cerrarSesion.php">Cerrar Sesión</a></li>
        </ul>
    </nav>

    <div class="contenido">
        <h1>Editar Usuario</h1>
        <form action="guardar.php" method="post">
            <input type="hidden" name="id" value="<?php echo $usuario->id; ?>">
            <div>
                <label>Nombre</label>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuario->nombre); ?>" required />
            </div>
            <div>
                <label>Apellido</label>
                <input type="text" name="apellido" value="<?php echo htmlspecialchars($usuario->apellido); ?>" required />
            </div>
            <div>
                <label>Email</label>
                <input type="text" name="email" value="<?php echo htmlspecialchars($usuario->email); ?>" required />
            </div>
            <div>
                <label>Password</label>
                <input type="text" name="password" value="<?php echo htmlspecialchars($usuario->password); ?>" />
            </div>
            <button>Guardar</button>
        </form>
    </div>

</body>
</html>
