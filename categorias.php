<?php   
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php
// Conexión a la base de datos usando mysqli
$servername = "localhost";
$username = "root";
$password = ""; // Coloca tu contraseña aquí
$dbname = "base"; // Cambia el nombre de tu base de datos

// Crear la conexión usando mysqli
$conx = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conx->connect_error) {
    die("Conexión fallida: " . $conx->connect_error);
}

// Obtener las categorías usando stmt
$stmt = $conx->prepare("SELECT id, nombre FROM categorias");
$stmt->execute();
$stmt->store_result(); // Asegúrate de almacenar los resultados
$stmt->bind_result($id_categorias, $nombre);

// Obtener el ID de la categoría seleccionada, si está presente
$selected_category_id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Obtener las noticias según la categoría seleccionada
if ($selected_category_id) {
    // Filtrar noticias por categoría
    $news_stmt = $conx->prepare("SELECT id, titulo, descripcion, imagen FROM noticias WHERE id_categorias = ? ORDER BY fecha DESC LIMIT 6");
    $news_stmt->bind_param("i", $selected_category_id);
} else {
    // Obtener todas las noticias si no hay categoría seleccionada
    $news_stmt = $conx->prepare("SELECT id, titulo, descripcion, imagen FROM noticias ORDER BY fecha DESC LIMIT 6");
}

$news_stmt->execute();
$news_stmt->bind_result($id_noticia, $titulo, $descripcion, $imagen);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias Chacabuco</title>
    <link rel="stylesheet" href="includes/CSS/frontends.css"> <!-- Ruta al CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
    <style>
        /* Estilos generales del cuerpo */
        body  .news-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin: 20px;
        }
        .news-item {
            flex: 1 1 calc(30% - 20px);
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .news-item:hover {
            transform: scale(1.02);
        }
        .news-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .news-item h3 {
            margin: 10px 0;
            font-size: 1.2em;
            padding: 0 10px;
        }
        .news-item p {
            padding: 0 10px 10px;
            font-size: 0.9em;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background-color: #f1f1f1;
            border-top: 1px solid #ddd;
        }
        .footer p {
            margin: 0;
            font-size: 0.8em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="frontend.php">
        <img src="logo-UTN-1.png" alt="Logo UTN" class="logo">
        </a>
        <div class="title">NOTICIAS CHACABUCO</div>
        <div class="user-options">
            <a href="#">Iniciar sesión</a>
            <a href="#">Registrarse</a>
        </div>
    </div>

    <div class="main-content">
        <div class="sidebar">
            <p id="toggle-categorias">Categorías</p>
            <ul id="categorias-list" style="display: none;">
                <?php
                // Mostrar las categorías usando stmt
                while ($stmt->fetch()) {
                    echo '<li><a href="categorias.php?id=' . $id_categorias . '">' . htmlspecialchars($nombre) . '</a></li>';
                }
                ?>
            </ul>
        </div>

        <div class="news-container">
            <?php
            // Mostrar las noticias
            while ($news_stmt->fetch()) {
                echo '<div class="news-item">';
                echo '<a href="detalles.php?id=' . $id_noticia . '"><img src="Panel/Noticias/' . htmlspecialchars($imagen) . '" alt="' . htmlspecialchars($titulo) . '"></a>'; // Enlace en la imagen
                echo '<h3><a href="detalles.php?id=' . $id_noticia . '">' . htmlspecialchars($titulo) . '</a></h3>'; // Enlace en el título
                echo '<p>' . htmlspecialchars($descripcion) . '</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#toggle-categorias').on('click', function() {
                $('#categorias-list').slideToggle(); // Efecto deslizable
            });
        });
    </script>

    <!-- Sección de derechos reservados -->
    <div class="footer">
        <p>&copy; <?php echo date("Y"); ?> Braian Zalvania. Todos los derechos reservados.</p>
    </div>
</body>
</html>

<?php
$stmt->close(); // Cerrar el statement
$news_stmt->close(); // Cerrar el statement de noticias
$conx->close(); // Cerrar la conexión
?>
