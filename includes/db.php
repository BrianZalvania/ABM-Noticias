<?php
$conx = new mysqli("localhost", "root", '', "base");

if ($conx->connect_errno) {
    echo "ERROR DE CONEXION: " . $conx->connect_error;
}
?>
