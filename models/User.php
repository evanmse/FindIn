<?php
// models/User.php - VERSION SQLITE CORRIGÉE
require_once 'models/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function login($email) {
        $sql = "SELECT * FROM utilisateurs WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();
        
        return $user;
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM utilisateurs ORDER BY nom, prenom";
        return $this->db->query($sql)->fetchAll();
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM utilisateurs WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function updateProfile($id, $data) {
        $sql = "UPDATE utilisateurs SET 
                prenom = :prenom, 
                nom = :nom, 
                departement = :departement 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':prenom' => $data['prenom'],
            ':nom' => $data['nom'],
            ':departement' => $data['departement'],
            ':id' => $id
        ]);
    }

    public function setUserRole($userId, $role) {
        $sql = "UPDATE utilisateurs SET role = :role WHERE id = :user_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user_id' => $userId,
            ':role' => $role
        ]);
    }

    public function getUsersByDepartment($department) {
        $sql = "SELECT * FROM utilisateurs WHERE departement = :department ORDER BY nom, prenom";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':department' => $department]);
        return $stmt->fetchAll();
    }

    public function getDepartments() {
        $sql = "SELECT DISTINCT departement FROM utilisateurs WHERE departement IS NOT NULL ORDER BY departement";
        return $this->db->query($sql)->fetchAll();
    }
}
?>
