<?php    
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "base"; 

$conx = new mysqli($servername, $username, $password, $dbname);

if ($conx->connect_error) {
    die("Conexión fallida: " . $conx->connect_error);
}


$stmt = $conx->prepare("SELECT id, nombre FROM categorias");
$stmt->execute();
$stmt->store_result(); 
$stmt->bind_result($id_categorias, $nombre);


$categoria_id = isset($_GET['id']) ? intval($_GET['id']) : 0;


if ($categoria_id > 0) {
    $news_stmt = $conx->prepare("SELECT id, titulo, descripcion, imagen FROM noticias WHERE id_categorias = ? ORDER BY fecha DESC LIMIT 6");
    $news_stmt->bind_param('i', $categoria_id); // Vincular el parámetro de la categoría seleccionada
} else {
    $news_stmt = $conx->prepare("SELECT id, titulo, descripcion, imagen FROM noticias ORDER BY fecha DESC LIMIT 6");
}
$news_stmt->execute();
$news_stmt->store_result(); 
$news_stmt->bind_result($id_noticia, $titulo, $descripcion, $imagen);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias Chacabuco</title>
    <link rel="stylesheet" href="includes/css/frontends.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery para el efecto -->
    <style>
        .news-container {
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
            <?php if (isset($_SESSION['usuario_nombre']) && isset($_SESSION['usuario_apellido'])): ?>
                <span>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_nombre'] . ' ' . $_SESSION['usuario_apellido']); ?></span>
                <a href="Panel/Registro/logout.php">Cerrar sesión</a>
            <?php else: ?>
                <a href="Panel/Registro/login.php">Iniciar sesión</a>
                <a href="Panel/Registro/registro.php">Registrarse</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="main-content">
        <div class="sidebar">
            <p id="toggle-categorias">Categorías</p>
            <ul id="categorias-list" style="display: none;">
                <?php
                if ($stmt->num_rows > 0) {
                    while ($stmt->fetch()) {
                        echo '<li><a href="frontend.php?id=' . $id_categorias . '">' . htmlspecialchars($nombre) . '</a></li>';
                    }
                } else {
                    echo '<li>No hay categorías disponibles.</li>';
                }
                ?>
            </ul>
        </div>

        <div class="news-container">
            <?php
            if ($news_stmt->num_rows > 0) {
                while ($news_stmt->fetch()) {
                    echo '<div class="news-item">';
                    echo '<a href="detalles.php?id=' . $id_noticia . '"><img src="Panel/Noticias/' . htmlspecialchars($imagen) . '" alt="' . htmlspecialchars($titulo) . '"></a>';
                    echo '<h3><a href="detalles.php?id=' . $id_noticia . '">' . htmlspecialchars($titulo) . '</a></h3>';
                    echo '<p>' . htmlspecialchars($descripcion) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No hay noticias disponibles para esta categoría.</p>';
            }
            ?>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#toggle-categorias').on('click', function() {
                $('#categorias-list').slideToggle();
            });
        });
    </script>

    <div class="footer">
        <p>&copy; <?php echo date("Y"); ?> Braian Zalvania. Todos los derechos reservados.</p>
    </div>
</body>
</html>

<?php
$stmt->close();
$news_stmt->close();
$conx->close();
?>
