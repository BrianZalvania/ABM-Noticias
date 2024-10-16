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

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT n.titulo, n.descripcion, n.texto, n.fecha, n.imagen, c.nombre AS categoria, u.nombre AS autor_nombre, u.apellido AS autor_apellido 
        FROM noticias n 
        JOIN categorias c ON n.id_categorias = c.id 
        JOIN usuarios u ON n.id_usuarios = u.id 
        WHERE n.id = ?";
$stmt = $conx->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$noticia = $resultado->fetch_assoc();

if (!$noticia) {
    echo "Noticia no encontrada.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($noticia['titulo']); ?></title>
    <link rel="stylesheet" href="includes/css/frontends.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .news-container {
            margin: 20px;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            background-color: #f9f9f9;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .news-header {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .category {
            font-size: 1.2em;
            color: #007bff;
            display: block;
            margin-bottom: 5px;
        }
        .title {
            font-size: 1.8em;
            font-weight: bold;
        }
        .date {
            font-size: 0.9em;
            color: #777;
            margin-top: 5px;
            display: block;
        }
        .news-description {
            font-size: 1em;
            margin-bottom: 15px;
            color: #555;
        }
        .news-image {
            text-align: center;
            margin-bottom: 20px;
        }
        .news-image img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .news-text {
            font-size: 1.1em;
            line-height: 1.6;
            color: #333;
        }
        .news-author {
            font-size: 0.9em;
            color: #777;
            margin-top: 10px;
            font-style: italic;
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
                $cat_stmt = $conx->prepare("SELECT id, nombre FROM categorias");
                $cat_stmt->execute();
                $cat_stmt->bind_result($id_categorias, $nombre);
                while ($cat_stmt->fetch()) {
                    echo '<li><a href="categorias.php?id=' . $id_categorias . '">' . htmlspecialchars($nombre) . '</a></li>';
                }
                $cat_stmt->close();
                ?>
            </ul>
        </div>

        <div class="news-container">
            <div class="news-header">
                <span class="category"><?php echo htmlspecialchars($noticia['categoria']); ?></span>
                <span class="title"><?php echo htmlspecialchars($noticia['titulo']); ?></span>
                <span class="date"><?php echo htmlspecialchars($noticia['fecha']); ?></span>
            </div>
            <p class="news-description"><?php echo htmlspecialchars($noticia['descripcion']); ?></p>
            <div class="news-image">
                <img src="Panel/Noticias/<?php echo htmlspecialchars($noticia['imagen']); ?>" alt="<?php echo htmlspecialchars($noticia['titulo']); ?>">
            </div>
            <div class="news-text">
                <p><?php echo nl2br(htmlspecialchars($noticia['texto'])); ?></p>
            </div>
            <div class="news-author">
                Subido por: <?php echo htmlspecialchars($noticia['autor_nombre']) . ' ' . htmlspecialchars($noticia['autor_apellido']); ?>
            </div>
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
       
    </div>
</body>
</html>

<?php
$conx->close();
?>
