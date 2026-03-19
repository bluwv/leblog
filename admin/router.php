<?php

/**
 * Router simple pour l'admin
 * Gère les routes et charge les controllers/views correspondants
 */

require_once "includes/session.php";
require_once "../config/database.php";

// Récupère la route demandée (par défaut: dashboard)
$page = $_GET['page'] ?? 'dashboard';

// Définition des routes disponibles
$routes = [
    'dashboard' => [
        'controller' => '../controllers/dashboard_controller.php',
        'view' => '../views/dashboard.php'
    ],
    'posts' => [
        'controller' => '../controllers/post_controller.php',
        'view' => '../views/posts/list.php'
    ],
    'edit' => [
        'controller' => '../controllers/post_controller.php',
        'view' => '../views/posts/edit.php'
    ],
    'users' => [
        'controller' => '../controllers/user_controller.php',
        'view' => '../views/users/list.php'
    ],
    'categories' => [
        'controller' => '../controllers/categorie_controller.php',
        'view' => '../views/categories/list.php'
    ]
];

// Vérifie si la route existe
if (isset($routes[$page])) {
    $route = $routes[$page];

    // Inclut le controller
    if (file_exists($route['controller'])) {
        require_once $route['controller'];
    }

    // Inclut la view
    if (file_exists($route['view'])) {
        require_once $route['view'];
    }
} else {
    // Route non trouvée
    header("Location: ?page=dashboard");
    exit;
}
