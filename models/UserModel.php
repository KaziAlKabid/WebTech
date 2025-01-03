<?php
class UserModel {
    private $db;

    public function __construct() {
        require_once 'config/db.php';
        $database = new Database();
        $this->db = $database->connect();
    }

    public function createUser($username, $password, $role,$email) {
        $query = "INSERT INTO users (name, password, role, email, creation_date) VALUES (:username, :password, :role,:email, NOW())";
        $stmt = $this->db->prepare($query);

        // Bind parameters to prevent SQL injection
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':email', $email);

        return $stmt->execute();
    }
    public function getUserByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Returns an associative array or false
    }
    
    
}
