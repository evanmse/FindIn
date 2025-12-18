<?php
// models/Competence.php - VERSION SQLITE CORRIGÉE
require_once __DIR__ . '/Database.php';

class Competence {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAllCompetences() {
        $sql = "SELECT c.*, cc.nom as categorie 
                FROM competences c
                LEFT JOIN categories_competences cc ON c.id_categorie = cc.id
                ORDER BY cc.nom, c.nom";
        
        try {
            return $this->db->query($sql)->fetchAll();
        } catch (Exception $e) {
            // En cas d'erreur, retourner une liste simple
            $sql = "SELECT * FROM competences ORDER BY nom";
            return $this->db->query($sql)->fetchAll();
        }
    }

    public function getUserCompetences($userId) {
        $sql = "SELECT cu.*, c.nom as competence_nom, c.type_competence, 
                       cc.nom as categorie
                FROM competences_utilisateurs cu
                JOIN competences c ON cu.id_competence = c.id
                LEFT JOIN categories_competences cc ON c.id_categorie = cc.id
                WHERE cu.id_utilisateur = :user_id
                ORDER BY cc.nom, c.nom";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':user_id' => $userId]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            // Version simplifiée si les jointures échouent
            $sql = "SELECT cu.*, c.nom as competence_nom 
                    FROM competences_utilisateurs cu
                    JOIN competences c ON cu.id_competence = c.id
                    WHERE cu.id_utilisateur = :user_id
                    ORDER BY c.nom";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':user_id' => $userId]);
            return $stmt->fetchAll();
        }
    }

    public function addUserCompetence($userId, $competenceId, $niveauDeclare) {
        $sql = "INSERT INTO competences_utilisateurs 
                (id_utilisateur, id_competence, niveau_declare, date_validation) 
                VALUES (:user_id, :competence_id, :niveau, datetime('now'))";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user_id' => $userId,
            ':competence_id' => $competenceId,
            ':niveau' => $niveauDeclare
        ]);
    }

    public function updateCompetenceValidation($compUserId, $niveauValide, $managerId) {
        $sql = "UPDATE competences_utilisateurs SET 
                niveau_valide = :niveau_valide,
                id_manager_validateur = :manager_id,
                date_validation = datetime('now')
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':niveau_valide' => $niveauValide,
            ':manager_id' => $managerId,
            ':id' => $compUserId
        ]);
    }

    public function searchByCompetence($searchTerm, $filters = []) {
        $sql = "SELECT DISTINCT u.id, u.prenom, u.nom, u.email, 
                u.departement,
                c.nom as competence_nom,
                cu.niveau_valide as niveau
                FROM utilisateurs u
                JOIN competences_utilisateurs cu ON u.id = cu.id_utilisateur
                JOIN competences c ON cu.id_competence = c.id
                WHERE c.nom LIKE :search 
                OR u.prenom LIKE :search 
                OR u.nom LIKE :search";
        
        // Ajouter des filtres
        if (!empty($filters['departement'])) {
            $sql .= " AND u.departement = :departement";
        }
        
        if (!empty($filters['niveau_min'])) {
            $sql .= " AND cu.niveau_valide >= :niveau_min";
        }
        
        $stmt = $this->db->prepare($sql);
        
        $params = [':search' => '%' . $searchTerm . '%'];
        
        if (!empty($filters['departement'])) {
            $params[':departement'] = $filters['departement'];
        }
        
        if (!empty($filters['niveau_min'])) {
            $params[':niveau_min'] = $filters['niveau_min'];
        }
        
        try {
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            // Version simplifiée en cas d'erreur
            error_log("Erreur recherche: " . $e->getMessage());
            return [];
        }
    }

    public function getCompetenceById($id) {
        $sql = "SELECT * FROM competences WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function getAllCategories() {
        $sql = "SELECT * FROM categories_competences ORDER BY nom";
        return $this->db->query($sql)->fetchAll();
    }
}
?>
