<?php
// index.php - TOUT EN UN SIMPLE
session_start();

// Configuration
error_reporting(E_ALL);
ini_set('display_errors', 1);

// =========================
// SECURITY HEADERS (HTTPS)
// =========================
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: camera=(), microphone=(), geolocation=()');

// HSTS header si HTTPS
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
}

// Redirection HTTPS en production (décommenter si nécessaire)
// if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'http') {
//     header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], true, 301);
//     exit;
// }
// Charger la configuration (DB, constantes)
require_once __DIR__ . '/config/database.php';

// Page demandée
$path = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($path, PHP_URL_PATH); // Enlever query string
$path = trim($path, '/');

// Pages spéciales qui ne nécessitent pas de redirection
$special_pages = ['init_database', 'test', 'assets', 'favicon.ico'];

foreach ($special_pages as $special) {
    if (strpos($path, $special) === 0) {
        // Servir directement sans redirection
        if ($path === 'init_database' || $path === 'init_database.php') {
            require_once 'init_database.php';
            exit;
        }
        if ($path === 'test') {
            require_once 'test.php';
            exit;
        }
        // Pour les assets, laisser PHP les servir directement
        return false;
    }
}

// Routes principales
switch ($path) {
    case '':
    case 'index.php':
        // Page d'accueil
        // Remarque: la vue d'accueil est fournie dans `views/index.php`
        require_once 'views/index.php';
        exit;
        
    case 'login':
        require_once 'controllers/AuthController.php';
        $auth = new AuthController();
        $auth->login();
        exit;
        
    case 'register':
        require_once 'controllers/AuthController.php';
        $auth = new AuthController();
        $auth->register();
        exit;
        
    case 'logout':
        require_once 'controllers/AuthController.php';
        $auth = new AuthController();
        $auth->logout();
        exit;
        
    case 'dashboard':
        // Vérifier la session sans redirection forcée
        if (!isset($_SESSION['user_id'])) {
            // Afficher directement la page de login
            require_once 'views/auth/login.php';
            exit;
        }
        require_once 'controllers/DashboardController.php';
        $dashboard = new DashboardController();
        $dashboard->index();
        exit;

    case 'dashboard_manager':
        require_once 'views/dashboard_manager.php';
        exit;

    case 'dashboard_rh':
        require_once 'views/dashboard_rh.php';
        exit;

    case 'dashboard_employee':
        require_once 'views/dashboard_employee.php';
        exit;

    case 'admin_messages':
        require_once 'views/admin_messages.php';
        exit;

    case 'about':
        require_once 'views/about.php';
        exit;

    case 'contact':
        require_once 'views/contact.php';
        exit;

    case 'faq':
        require_once 'views/faq.php';
        exit;

    // Pages légales
    case 'privacy':
    case 'privacy.php':
        require_once 'views/privacy.php';
        exit;

    case 'terms':
    case 'terms.php':
        require_once 'views/terms.php';
        exit;

    case 'cgu':
    case 'cgu.php':
        require_once 'views/cgu.php';
        exit;

    case 'mentions_legales':
    case 'mentions_legales.php':
        require_once 'views/mentions_legales.php';
        exit;

    // Pages entreprise
    case 'pricing':
        require_once 'views/pricing.php';
        exit;

    case 'carrieres':
        require_once 'views/carrieres.php';
        exit;

    case 'presse':
        require_once 'views/presse.php';
        exit;

    case 'security':
        require_once 'views/security.php';
        exit;

    // Pages ressources
    case 'documentation':
        require_once 'views/documentation.php';
        exit;

    case 'roadmap':
        require_once 'views/roadmap.php';
        exit;

    case 'blog':
        require_once 'views/blog.php';
        exit;

    case 'features':
        require_once 'views/features.php';
        exit;

    case 'tutorials':
        require_once 'views/tutorials.php';
        exit;

    case 'community':
        require_once 'views/community.php';
        exit;

    case 'cookies':
        require_once 'views/cookies.php';
        exit;

    case 'accessibility':
        require_once 'views/accessibility.php';
        exit;

    // Dashboard sub-pages
    case 'dashboard/competences':
        if (!isset($_SESSION['user_id'])) { header('Location: /login'); exit; }
        require_once 'views/dashboard/competences.php';
        exit;

    case 'dashboard/certifications':
        if (!isset($_SESSION['user_id'])) { header('Location: /login'); exit; }
        require_once 'views/dashboard/certifications.php';
        exit;

    case 'dashboard/mon-espace':
        if (!isset($_SESSION['user_id'])) { header('Location: /login'); exit; }
        require_once 'views/dashboard/mon-espace.php';
        exit;

    case 'dashboard/cvs':
        if (!isset($_SESSION['user_id'])) { header('Location: /login'); exit; }
        require_once 'views/dashboard/cvs.php';
        exit;

    case 'dashboard/reunions':
        if (!isset($_SESSION['user_id'])) { header('Location: /login'); exit; }
        require_once 'views/dashboard/reunions.php';
        exit;

    case 'dashboard/tests':
        if (!isset($_SESSION['user_id'])) { header('Location: /login'); exit; }
        require_once 'views/dashboard/tests.php';
        exit;

    case 'dashboard/bilan':
        if (!isset($_SESSION['user_id'])) { header('Location: /login'); exit; }
        require_once 'views/dashboard/bilan.php';
        exit;

    case 'dashboard/projets':
        if (!isset($_SESSION['user_id'])) { header('Location: /login'); exit; }
        require_once 'views/dashboard/projets.php';
        exit;

    case 'dashboard/equipe':
        if (!isset($_SESSION['user_id'])) { header('Location: /login'); exit; }
        require_once 'views/dashboard/equipe.php';
        exit;

    case 'dashboard/parametres':
        if (!isset($_SESSION['user_id'])) { header('Location: /login'); exit; }
        require_once 'views/dashboard/parametres.php';
        exit;
        
    default:
        // Essayer de servir un fichier existant
        if (file_exists($path) && !is_dir($path)) {
            return false; // Laisser PHP servir le fichier
        }
        
        // Page non trouvée
        http_response_code(404);
        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>404 - FindIN</title>
            <style>
                body { 
                    font-family: sans-serif; 
                    padding: 100px 20px;
                    text-align: center;
                    background: #f8fafc;
                    color: #1e293b;
                }
                h1 { color: #2563eb; margin-bottom: 20px; }
                a { 
                    color: #2563eb; 
                    text-decoration: none;
                    padding: 10px 20px;
                    border: 2px solid #2563eb;
                    border-radius: 5px;
                    display: inline-block;
                    margin-top: 20px;
                }
                a:hover { background: #2563eb; color: white; }
            </style>
        </head>
        <body>
            <h1>🔍 404 - Page non trouvée</h1>
            <p>La page <strong>/' . htmlspecialchars($path) . '</strong> n\'existe pas.</p>
            <a href="/">Retour à l\'accueil</a>
        </body>
        </html>';
        exit;
}
?>
