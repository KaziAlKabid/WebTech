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
    public function storePasswordResetToken($email, $token) {
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expires in 1 hour
        $query = "INSERT INTO password_resets (email, token, expiry) VALUES (:email, :token, :expiry)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expiry', $expiry);
        return $stmt->execute();
    }
    public function validatePasswordResetToken($token) {
        $query = "SELECT email FROM password_resets WHERE token = :token AND expiry > NOW() LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['email'] : false;
    }
    public function updatePassword($email, $hashedPassword) {
        $query = "UPDATE users SET password = :password WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }
    public function deletePasswordResetToken($token) {
        $query = "DELETE FROM password_resets WHERE token = :token";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':token', $token);
        return $stmt->execute();
    }
    
    
    
    
}
