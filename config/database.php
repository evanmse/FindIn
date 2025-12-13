<?php
// config/database.php
// Support MySQL (XAMPP) or SQLite. Change DB_TYPE to 'mysql' when using XAMPP.
// Examples:
//  - SQLite (default): DB_TYPE = 'sqlite' -> uses file database.sqlite in project root
//  - MySQL (XAMPP): DB_TYPE = 'mysql' -> configure host, name, user, pass below

// Switch here when using XAMPP/MySQL:
define('DB_TYPE', getenv('DB_TYPE') ?: 'mysql'); // 'mysql' or 'sqlite'

// MySQL / XAMPP connection defaults (overridable via environment variables)
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_NAME', getenv('DB_NAME') ?: 'gestion_competences');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');

// SQLite settings (used when DB_TYPE == 'sqlite')
define('DB_PATH', __DIR__ . '/../database.sqlite');

// Rôles utilisateurs
define('ROLE_EMPLOYEE', 'employe');
define('ROLE_MANAGER', 'manager');
define('ROLE_RH', 'rh');
define('ROLE_ADMIN', 'admin');

// Configuration
define('APP_NAME', 'FindIN');
// If using XAMPP with Apache on port 80, APP_URL can be http://localhost
define('APP_URL', getenv('APP_URL') ?: 'http://localhost:8000');
define('DEBUG_MODE', true);

// Fonction de débogage
function debug($data) {
    if (DEBUG_MODE) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}

// Vérifier si SQLite est disponible
// Basic checks
if (DB_TYPE === 'sqlite') {
    if (!extension_loaded('pdo_sqlite')) {
        die("L'extension PDO SQLite n'est pas chargée. Activez-la dans php.ini ou installez php-sqlite3.");
    }
} elseif (DB_TYPE === 'mysql') {
    if (!extension_loaded('pdo_mysql')) {
        die("L'extension PDO MySQL n'est pas chargée. Activez-la dans php.ini (extension=pdo_mysql)");
    }
} else {
    die("DB_TYPE inconnu. Utilisez 'sqlite' ou 'mysql'.");
}
?>
