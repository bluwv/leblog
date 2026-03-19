<?php

// require_once 'router.php';

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/' :
    case '' :
    case '/index.php' :
        require __DIR__ . '/home.php';
        break;
    case '/post' :
        require __DIR__ . '/post.php';
        break;
    http_response_code(404);
        require __DIR__ . '/error.php';
        break;
}
