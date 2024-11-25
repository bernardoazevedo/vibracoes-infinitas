<?php

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/' :
        require __DIR__ . '/src/views/index.php';
        break;
    case '/login' :
        require __DIR__ . '/src/views/login.php';
        break;
    case '/register' :
        require __DIR__ . '/src/views/register.php';
        break;
    case '/home' :
        require __DIR__ . '/src/views/home.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/src/views/404.php';
        break;
}