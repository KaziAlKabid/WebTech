<?php
class UserModel {
    private $db;

    public function __construct() {
        require_once 'config/db.php';
        $database = new Database();
        $this->db = $database->connect();
    }

    public function createUser($username, $password, $role,$email,$address,$phone) {
        $query = "INSERT INTO users (name, password, role, email,address,phone, creation_date) VALUES (:username, :password, :role,:email,:address,:phone, NOW())";
        $stmt = $this->db->prepare($query);

        // Bind parameters to prevent SQL injection
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phone', $phone);

        return $stmt->execute();
    }
    public function getUserByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Returns an associative array or false
    }
    public function emailExists($email) {
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        // Return true if email exists, false otherwise
        return $stmt->fetchColumn() > 0;
    }
    
    
    
}
