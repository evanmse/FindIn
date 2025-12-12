<?php
// router.php - AVEC PAGE D'ACCUEIL
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Autoload
spl_autoload_register(function ($class) {
    $paths = [
        'controllers/' . $class . '.php',
        'models/' . $class . '.php'
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Routes
$path = $_SERVER['REQUEST_URI'] ?? '/';
$path = strtok($path, '?'); // Enlever query string
$path = trim($path, '/');

// Mapping des routes
$routes = [
    '' => ['HomeController', 'index'],
    'login' => ['AuthController', 'login'],
    'logout' => ['AuthController', 'logout'],
    'register' => ['AuthController', 'register'],
    'dashboard' => function() { require 'views/dashboard_new.php'; },
    
    // Dashboard routes
    'competences' => function() { require 'views/competences.php'; },
    'profile' => function() { require 'views/profile.php'; },
    'admin_users' => function() { require 'views/admin_users.php'; },
    'admin_competences' => function() { require 'views/admin_competences.php'; },
    'admin_settings' => function() { require 'views/settings.php'; },
    'search' => function() { require 'views/search_advanced.php'; },
    
    // Static pages
    'product' => function() { require 'views/product.php'; },
    'features' => function() { require 'views/features.php'; },
    'about' => function() { require 'views/about.php'; },
    'contact' => function() { require 'views/contact.php'; },
    'faq' => function() { require 'views/faq.php'; },
    'pricing' => function() { require 'views/pricing.php'; },
    'security' => function() { require 'views/security.php'; },
    'roadmap' => function() { require 'views/roadmap.php'; },
    'documentation' => function() { require 'views/documentation.php'; },
    'blog' => function() { require 'views/blog.php'; },
    'tutorials' => function() { require 'views/tutorials.php'; },
    'community' => function() { require 'views/community.php'; },
    'privacy' => function() { require 'views/privacy.php'; },
    'terms' => function() { require 'views/terms.php'; },
    'cookies' => function() { require 'views/cookies.php'; },
    'accessibility' => function() { require 'views/accessibility.php'; },
    'setup_database' => function() { require 'setup_database.php'; },
    
    // Other routes
    'search' => ['SearchController', 'index'],
    'admin' => ['AdminController', 'dashboard'],
    'init_database' => function() {
        require_once 'init_database.php';
        exit;
    }
];

// Trouver la route
if (isset($routes[$path])) {
    $route = $routes[$path];
    
    if (is_callable($route)) {
        $route();
    } elseif (is_array($route)) {
        $controllerName = $route[0];
        $methodName = $route[1];
        
        if (class_exists($controllerName)) {
            $controller = new $controllerName();
            if (method_exists($controller, $methodName)) {
                $controller->$methodName();
            } else {
                show404();
            }
        } else {
            show404();
        }
    }
} else {
    // Essayer de servir un fichier statique
    if (file_exists($path) && !is_dir($path)) {
        return false;
    }
    show404();
}

function show404() {
    http_response_code(404);
    echo '<!DOCTYPE html>
    <html>
    <head>
        <title>404 - FindIN</title>
        <style>
            body { 
                font-family: -apple-system, sans-serif; 
                text-align: center; 
                padding: 100px 20px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }
            h1 { font-size: 4rem; margin-bottom: 1rem; }
            p { font-size: 1.2rem; opacity: 0.9; margin-bottom: 2rem; }
            a { 
                color: white; 
                text-decoration: none;
                padding: 12px 24px;
                background: rgba(255,255,255,0.2);
                border-radius: 8px;
                border: 1px solid rgba(255,255,255,0.3);
                transition: all 0.3s ease;
            }
            a:hover {
                background: rgba(255,255,255,0.3);
                transform: translateY(-2px);
            }
        </style>
    </head>
    <body>
        <h1>🔍 404</h1>
        <p>La page demandée n\'existe pas.</p>
        <a href="/">Retour à l\'accueil</a>
    </body>
    </html>';
    exit;
}
?>
