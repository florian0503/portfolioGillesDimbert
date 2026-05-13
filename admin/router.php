<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Symfony static assets (bundles)
if (preg_match('#^/bundles/#', $uri)) {
    $file = __DIR__ . '/public' . $uri;
    if (is_file($file)) {
        $mimes = [
            'css'   => 'text/css',
            'js'    => 'application/javascript',
            'png'   => 'image/png',
            'jpg'   => 'image/jpeg',
            'svg'   => 'image/svg+xml',
            'ico'   => 'image/x-icon',
            'woff'  => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf'   => 'font/ttf',
            'map'   => 'application/json',
        ];
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        header('Content-Type: ' . ($mimes[$ext] ?? 'application/octet-stream'));
        readfile($file);
        return true;
    }
}

// Fichiers statiques dans public/ (css, js, img, logos…)
$publicFile = __DIR__ . '/public' . $uri;
if ($uri !== '/' && is_file($publicFile)) {
    $mimes = [
        'css'   => 'text/css',
        'js'    => 'application/javascript',
        'json'  => 'application/json',
        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'gif'   => 'image/gif',
        'svg'   => 'image/svg+xml',
        'ico'   => 'image/x-icon',
        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf',
        'webp'  => 'image/webp',
        'mp4'   => 'video/mp4',
    ];
    $ext = strtolower(pathinfo($publicFile, PATHINFO_EXTENSION));
    header('Content-Type: ' . ($mimes[$ext] ?? 'application/octet-stream'));
    readfile($publicFile);
    return true;
}

// Tout le reste → Symfony
$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/public';
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/public/index.php';
require __DIR__ . '/public/index.php';
return true;
