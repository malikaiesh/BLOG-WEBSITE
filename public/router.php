<?php
$uri = $_SERVER['REQUEST_URI'];
$path = parse_url($uri, PHP_URL_PATH);

if ($path === '/sitemap.xml') {
    require 'sitemap.xml.php';
    exit;
}

if (preg_match('/^\/admin\/assets\/(.+)$/', $path, $matches)) {
    $file = __DIR__ . '/../admin/assets/' . $matches[1];
    if (file_exists($file)) {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $mimeTypes = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2'
        ];
        header('Content-Type: ' . ($mimeTypes[$ext] ?? 'application/octet-stream'));
        readfile($file);
        return true;
    }
}

if (preg_match('/\.(?:css|js|png|jpg|jpeg|gif|ico|webp|svg|woff|woff2)$/', $path)) {
    return false;
}

require __DIR__ . '/index.php';
