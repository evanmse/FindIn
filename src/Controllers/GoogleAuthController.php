<?php
// controllers/GoogleAuthController.php
// Gère l'authentification via Google OAuth 2.0

class GoogleAuthController {
    private $config;
    
    public function __construct() {
        $this->config = require __DIR__ . '/../config/google_oauth.php';
    }
    
    /**
     * Redirige vers la page de connexion Google
     */
    public function redirect() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Générer un state pour la sécurité CSRF
        $state = bin2hex(random_bytes(16));
        $_SESSION['google_oauth_state'] = $state;
        
        // Construire l'URL d'autorisation Google
        $params = [
            'client_id' => $this->config['client_id'],
            'redirect_uri' => $this->config['redirect_uri'],
            'response_type' => 'code',
            'scope' => implode(' ', $this->config['scopes']),
            'state' => $state,
            'access_type' => 'offline',
            'prompt' => 'consent'
        ];
        
        $authUrl = $this->config['auth_url'] . '?' . http_build_query($params);
        
        header('Location: ' . $authUrl);
        exit;
    }
    
    /**
     * Traite le callback de Google après authentification
     */
    public function callback() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Vérifier les erreurs
        if (isset($_GET['error'])) {
            $_SESSION['login_error'] = 'Connexion Google annulée ou refusée.';
            header('Location: /login');
            exit;
        }
        
        // Vérifier le state CSRF
        if (!isset($_GET['state']) || $_GET['state'] !== ($_SESSION['google_oauth_state'] ?? '')) {
            $_SESSION['login_error'] = 'Erreur de sécurité. Veuillez réessayer.';
            header('Location: /login');
            exit;
        }
        
        // Vérifier le code d'autorisation
        if (!isset($_GET['code'])) {
            $_SESSION['login_error'] = 'Code d\'autorisation manquant.';
            header('Location: /login');
            exit;
        }
        
        try {
            // Échanger le code contre un token d'accès
            $tokenData = $this->getAccessToken($_GET['code']);
            
            if (!$tokenData || !isset($tokenData['access_token'])) {
                throw new Exception('Impossible d\'obtenir le token d\'accès.');
            }
            
            // Récupérer les informations utilisateur
            $userInfo = $this->getUserInfo($tokenData['access_token']);
            
            if (!$userInfo || !isset($userInfo['email'])) {
                throw new Exception('Impossible de récupérer les informations utilisateur.');
            }
            
            // Créer ou connecter l'utilisateur
            $this->handleUser($userInfo);
            
        } catch (Exception $e) {
            $_SESSION['login_error'] = 'Erreur de connexion Google: ' . $e->getMessage();
            header('Location: /login');
            exit;
        }
    }
    
    /**
     * Échange le code d'autorisation contre un token d'accès
     */
    private function getAccessToken($code) {
        $postData = [
            'client_id' => $this->config['client_id'],
            'client_secret' => $this->config['client_secret'],
            'redirect_uri' => $this->config['redirect_uri'],
            'grant_type' => 'authorization_code',
            'code' => $code
        ];
        
        $ch = curl_init($this->config['token_url']);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($postData),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded']
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            return null;
        }
        
        return json_decode($response, true);
    }
    
    /**
     * Récupère les informations de l'utilisateur Google
     */
    private function getUserInfo($accessToken) {
        $ch = curl_init($this->config['userinfo_url']);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $accessToken]
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            return null;
        }
        
        return json_decode($response, true);
    }
    
    /**
     * Gère la création/connexion de l'utilisateur
     */
    private function handleUser($googleUser) {
        require_once __DIR__ . '/../models/Database.php';
        require_once __DIR__ . '/../models/User.php';
        
        $db = Database::getInstance();
        $email = $googleUser['email'];
        
        // Vérifier si l'utilisateur existe déjà
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            // Utilisateur existant - Mettre à jour le google_id si nécessaire
            if (empty($user['google_id'])) {
                $updateStmt = $db->prepare("UPDATE users SET google_id = ?, updated_at = NOW() WHERE id = ?");
                $updateStmt->execute([$googleUser['sub'], $user['id']]);
            }
        } else {
            // Nouvel utilisateur - Créer le compte
            $prenom = $googleUser['given_name'] ?? '';
            $nom = $googleUser['family_name'] ?? '';
            $avatar = $googleUser['picture'] ?? null;
            
            $insertStmt = $db->prepare("
                INSERT INTO users (email, prenom, nom, google_id, avatar_url, role, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, 'employe', NOW(), NOW())
            ");
            $insertStmt->execute([$email, $prenom, $nom, $googleUser['sub'], $avatar]);
            
            // Récupérer le nouvel utilisateur
            $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        // Connecter l'utilisateur
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'prenom' => $user['prenom'],
            'nom' => $user['nom'],
            'role' => $user['role'],
            'avatar_url' => $user['avatar_url'] ?? null
        ];
        
        // Nettoyer le state
        unset($_SESSION['google_oauth_state']);
        
        // Rediriger vers le dashboard
        header('Location: /dashboard');
        exit;
    }
}
