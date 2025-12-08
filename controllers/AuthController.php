<?php
// controllers/AuthController.php - SANS REDIRECTION FORCÉE
class AuthController {
    
    public function login() {
        // Si déjà connecté, montrer directement le dashboard
        if (isset($_SESSION['user_id'])) {
            $this->showDashboard();
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            require_once 'models/Database.php';
            $stmt = Database::query('SELECT * FROM utilisateurs WHERE email = ?', [$email]);
            $user = $stmt->fetch();

            if ($user) {
                // Si mot de passe vide en base, accepter et enregistrer le hash
                $stored = $user['mot_de_passe'] ?? ($user['mot_de_passe'] ?? null);
                if (empty($stored)) {
                    // Accepter connexion et set mot de passe
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    Database::query('UPDATE utilisateurs SET mot_de_passe = ? WHERE email = ?', [$hash, $email]);
                } else {
                    if (!password_verify($password, $stored)) {
                        // Mauvais mot de passe -> afficher login
                        $data['error'] = 'Email ou mot de passe invalide.';
                        require_once 'views/auth/login.php';
                        return;
                    }
                }

                // Set session
                $_SESSION['user_id'] = $user['id_utilisateur'] ?? $user['id'] ?? time();
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = trim(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')) ?: $user['email'];
                $_SESSION['user_role'] = $user['role'] ?? 'employe';
                $_SESSION['departement'] = $user['departement'] ?? ($user['id_departement'] ?? null);

                $this->showDashboard();
                return;
            } else {
                // Aucun utilisateur -> créer automatiquement (comportement MVP existant)
                $hash = password_hash($password, PASSWORD_DEFAULT);
                if (defined('DB_TYPE') && DB_TYPE === 'mysql') {
                    $id = $this->generateUUID();
                    Database::query('INSERT INTO utilisateurs (id_utilisateur, email, prenom, nom, mot_de_passe, role) VALUES (?, ?, ?, ?, ?, ?)', [$id, $email, '', '', $hash, 'employe']);
                    $_SESSION['user_id'] = $id;
                } else {
                    Database::query('INSERT INTO utilisateurs (email, prenom, nom, mot_de_passe, role) VALUES (?, ?, ?, ?, ?)', [$email, '', '', $hash, 'employe']);
                    $db = Database::getInstance();
                    $_SESSION['user_id'] = $db->lastInsertId();
                }

                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $email;
                $_SESSION['user_role'] = 'employe';

                $this->showDashboard();
                return;
            }
        }
        
        // Afficher la page de login
        require_once 'views/auth/login.php';
    }
    
    public function logout() {
        // Détruire la session
        session_destroy();
        
        // Afficher directement la page de login
        require_once 'views/auth/login.php';
    }

    public function register() {
        // Si déjà connecté, afficher dashboard
        if (isset($_SESSION['user_id'])) {
            $this->showDashboard();
            return;
        }

        // POST -> création
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prenom = trim($_POST['prenom'] ?? '');
            $nom = trim($_POST['nom'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';
            $departement = $_POST['id_departement'] ?? null;

            if (empty($prenom) || empty($nom) || empty($email) || empty($password)) {
                $data['error'] = 'Veuillez remplir tous les champs requis.';
                require_once 'views/auth/register.php';
                return;
            }

            if ($password !== $confirm) {
                $data['error'] = 'Les mots de passe ne correspondent pas.';
                require_once 'views/auth/register.php';
                return;
            }

            // Vérifier existence
            require_once 'models/Database.php';
            $stmt = Database::query('SELECT * FROM utilisateurs WHERE email = ?', [$email]);
            $user = $stmt->fetch();

            if ($user) {
                $data['error'] = 'Un compte existe déjà avec cet e-mail.';
                require_once 'views/auth/register.php';
                return;
            }

            // Hash mot de passe
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // Générer identifiant si MySQL
            if (defined('DB_TYPE') && DB_TYPE === 'mysql') {
                // uuid simple
                $id = $this->generateUUID();
                Database::query('INSERT INTO utilisateurs (id_utilisateur, email, prenom, nom, mot_de_passe, id_departement, role) VALUES (?, ?, ?, ?, ?, ?, ?)', [$id, $email, $prenom, $nom, $hash, $departement, 'employe']);
                $_SESSION['user_id'] = $id;
            } else {
                Database::query('INSERT INTO utilisateurs (email, prenom, nom, mot_de_passe, departement, role) VALUES (?, ?, ?, ?, ?, ?)', [$email, $prenom, $nom, $hash, $departement, 'employe']);
                $db = Database::getInstance();
                $_SESSION['user_id'] = $db->lastInsertId();
            }

            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $prenom . ' ' . $nom;
            $_SESSION['user_role'] = 'employe';

            $this->showDashboard();
            return;
        }

        // Sinon afficher le formulaire
        require_once 'views/auth/register.php';
    }

    private function generateUUID() {
        // Générateur simple v4
        $data = random_bytes(16);
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
    
    private function showDashboard() {
        // Afficher directement le dashboard
        require_once 'controllers/DashboardController.php';
        $dashboard = new DashboardController();
        $dashboard->index();
    }
}
?>
