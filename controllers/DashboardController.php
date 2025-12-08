<?php
// controllers/DashboardController.php - VERSION CORRIGÉE
require_once 'models/User.php';
require_once 'models/Competence.php';

class DashboardController {
    private $userModel;
    private $competenceModel;

    public function __construct() {
        // Ne pas démarrer la session ici
        try {
            $this->userModel = new User();
            $this->competenceModel = new Competence();
        } catch (Exception $e) {
            // Log l'erreur mais continuer
            error_log("Erreur initialisation DashboardController: " . $e->getMessage());
        }
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        
        $userId = $_SESSION['user_id'];
        
        // Données par défaut
        $data = [
            'user' => ['email' => $_SESSION['user_email'], 'prenom' => 'Utilisateur', 'nom' => 'FindIN'],
            'competences' => [],
            'all_competences' => [],
            'stats' => [
                'total_competences' => 0,
                'validated_competences' => 0,
                'pending_validation' => 0
            ],
            'user_role' => $_SESSION['user_role'] ?? 'employe'
        ];
        
        // Essayer de récupérer les données
        try {
            if ($this->userModel) {
                $user = $this->userModel->getUserById($userId);
                if ($user) {
                    $data['user'] = $user;
                }
            }
            
            if ($this->competenceModel) {
                $userCompetences = $this->competenceModel->getUserCompetences($userId);
                $allCompetences = $this->competenceModel->getAllCompetences();
                
                $data['competences'] = $userCompetences;
                $data['all_competences'] = $allCompetences;
                
                // Calculer les statistiques
                if (!empty($userCompetences)) {
                    $data['stats']['total_competences'] = count($userCompetences);
                    $data['stats']['validated_competences'] = count(array_filter($userCompetences, function($c) {
                        return isset($c['niveau_valide']) && $c['niveau_valide'] !== null;
                    }));
                    $data['stats']['pending_validation'] = count(array_filter($userCompetences, function($c) {
                        return (!isset($c['niveau_valide']) || $c['niveau_valide'] === null) && 
                               isset($c['niveau_declare']) && $c['niveau_declare'] !== null;
                    }));
                }
            }
        } catch (Exception $e) {
            // En cas d'erreur, on garde les données par défaut
            error_log("Erreur Dashboard: " . $e->getMessage());
        }
        
        // Afficher la vue
        $this->view('dashboard/index', $data);
    }

    private function view($view, $data = []) {
        extract($data);
        $viewFile = "views/$view.php";
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            // Vue d'erreur
            echo "<h1>Erreur : Vue non trouvée</h1>";
            echo "<p>La vue '$view' n'existe pas.</p>";
            echo '<a href="/">Retour à l\'accueil</a>';
        }
    }
}
?>
