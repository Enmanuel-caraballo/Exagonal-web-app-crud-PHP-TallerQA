<?php
// Router para el servidor integrado de PHP.
// Si el archivo solicitado existe (CSS, JS, imágenes), lo sirve directamente.
// Si no existe, redirige todo a index.php (Front Controller).
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $path;

if ($path !== '/' && file_exists($file) && !is_dir($file)) {
    return false; // Servir el archivo estático directamente
}

require_once __DIR__ . '/index.php';
