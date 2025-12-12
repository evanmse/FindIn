<?php
// models/Database.php - VERSION ULTRA SIMPLE
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        try {
            // Support SQLite ou MySQL selon config
            if (defined('DB_TYPE') && DB_TYPE === 'mysql') {
                $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_PORT, DB_NAME);
                $this->connection = new PDO($dsn, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } else {
                // Par défaut SQLite
                $dbPath = defined('DB_PATH') ? DB_PATH : (__DIR__ . '/../database.sqlite');

                // Créer le fichier si il n'existe pas
                if (!file_exists($dbPath)) {
                    touch($dbPath);
                }

                // Connexion SQLite
                $this->connection = new PDO("sqlite:$dbPath");
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            }

            // Créer les tables minimales
            $this->createMinimalTables();

        } catch (PDOException $e) {
            // Message d'erreur simple
            if (defined('DEBUG_MODE') && DEBUG_MODE) {
                die("Erreur DB: " . $e->getMessage());
            } else {
                die("Erreur de connexion à la base de données.");
            }
        }
    }

    private function createMinimalTables() {
        // Table utilisateurs (minimale)
        if (defined('DB_TYPE') && DB_TYPE === 'mysql') {
            $sql = "CREATE TABLE IF NOT EXISTS utilisateurs (
                id_utilisateur CHAR(36) NOT NULL PRIMARY KEY,
                email VARCHAR(255) UNIQUE NOT NULL,
                prenom VARCHAR(100),
                nom VARCHAR(100),
                mot_de_passe VARCHAR(255),
                id_departement CHAR(36) DEFAULT NULL,
                role VARCHAR(50) DEFAULT 'employe',
                cree_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
            $this->connection->exec($sql);
            
            // Migrate: Add mot_de_passe column if it doesn't exist (MySQL)
            try {
                $checkCol = $this->connection->query("SHOW COLUMNS FROM utilisateurs LIKE 'mot_de_passe'")->fetch();
                if (!$checkCol) {
                    // Try different positions
                    try {
                        $this->connection->exec("ALTER TABLE utilisateurs ADD COLUMN mot_de_passe VARCHAR(255) AFTER email");
                    } catch (Exception $e1) {
                        try {
                            $this->connection->exec("ALTER TABLE utilisateurs ADD COLUMN mot_de_passe VARCHAR(255)");
                        } catch (Exception $e2) {
                            // Already exists, ignore
                        }
                    }
                }
            } catch (Exception $e) {
                // Column might already exist, continue
            }
        } else {
            $sql = "CREATE TABLE IF NOT EXISTS utilisateurs (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                email TEXT UNIQUE NOT NULL,
                prenom TEXT,
                nom TEXT,
                mot_de_passe TEXT,
                departement TEXT,
                role TEXT DEFAULT 'employe'
            );";
            $this->connection->exec($sql);
            
            // Migrate: Add mot_de_passe column if it doesn't exist (SQLite)
            try {
                $checkCol = $this->connection->query("PRAGMA table_info(utilisateurs)")->fetchAll();
                $hasPassword = false;
                foreach ($checkCol as $col) {
                    if ($col['name'] === 'mot_de_passe') {
                        $hasPassword = true;
                        break;
                    }
                }
                if (!$hasPassword) {
                    $this->connection->exec("ALTER TABLE utilisateurs ADD COLUMN mot_de_passe TEXT");
                }
            } catch (Exception $e) {
                // Column might already exist, continue
            }
        }

        // Table competences (minimale)
        $sql = (defined('DB_TYPE') && DB_TYPE === 'mysql') ?
            "CREATE TABLE IF NOT EXISTS competences (
                id_competence CHAR(36) NOT NULL PRIMARY KEY,
                nom VARCHAR(255) UNIQUE NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
            :
            "CREATE TABLE IF NOT EXISTS competences (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nom TEXT UNIQUE NOT NULL
            );";
        $this->connection->exec($sql);

        // Table competences_utilisateurs (minimale)
        if (defined('DB_TYPE') && DB_TYPE === 'mysql') {
            $sql = "CREATE TABLE IF NOT EXISTS competences_utilisateurs (
                id_comp_utilisateur CHAR(36) NOT NULL PRIMARY KEY,
                id_utilisateur CHAR(36),
                id_competence CHAR(36),
                niveau TINYINT DEFAULT 1,
                FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur),
                FOREIGN KEY (id_competence) REFERENCES competences(id_competence)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        } else {
            $sql = "CREATE TABLE IF NOT EXISTS competences_utilisateurs (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                utilisateur_id INTEGER,
                competence_id INTEGER,
                niveau INTEGER DEFAULT 1,
                FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id),
                FOREIGN KEY (competence_id) REFERENCES competences(id)
            );";
        }
        $this->connection->exec($sql);

        // Table messages/contact (minimale)
        if (defined('DB_TYPE') && DB_TYPE === 'mysql') {
            $sql = "CREATE TABLE IF NOT EXISTS messages (
                id_message CHAR(36) NOT NULL PRIMARY KEY,
                nom VARCHAR(255),
                email VARCHAR(255),
                message TEXT,
                cree_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        } else {
            $sql = "CREATE TABLE IF NOT EXISTS messages (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nom TEXT,
                email TEXT,
                message TEXT,
                cree_le DATETIME DEFAULT CURRENT_TIMESTAMP
            );";
        }
        try {
            $this->connection->exec($sql);
        } catch (Exception $e) {
            // ignore
        }

        // Insérer l'admin si nécessaire
        $stmt = $this->connection->query("SELECT COUNT(*) as count FROM utilisateurs");
        $row = $stmt->fetch();
        $count = isset($row['count']) ? $row['count'] : (isset($row[0]) ? $row[0] : 0);

        if ($count == 0) {
            // Insérer un utilisateur admin de test
            if (defined('DB_TYPE') && DB_TYPE === 'mysql') {
                $this->connection->exec("INSERT INTO utilisateurs (id_utilisateur, email, prenom, nom, role) VALUES 
                    (UUID(), 'admin@findin.com', 'Admin', 'FindIN', 'admin')");
            } else {
                $this->connection->exec("INSERT INTO utilisateurs (email, prenom, nom, role) VALUES 
                    ('admin@findin.com', 'Admin', 'FindIN', 'admin')");
            }

            // Insert quelques compétences
            if (defined('DB_TYPE') && DB_TYPE === 'mysql') {
                $this->connection->exec("INSERT INTO competences (id_competence, nom) VALUES 
                    (UUID(), 'PHP'), (UUID(), 'JavaScript'), (UUID(), 'Python'), (UUID(), 'Communication')");
            } else {
                $this->connection->exec("INSERT INTO competences (nom) VALUES 
                    ('PHP'), ('JavaScript'), ('Python'), ('Communication')");
            }
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->connection;
    }

    public static function query($sql, $params = []) {
        $db = self::getInstance();
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
?>
