<?php
class UserModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createUser($username, $password, $role,$email,$address,$phone,$license,$experience,$specialization) {
        $query = "INSERT INTO users (name, password, role, email,address,phone, creation_date,license,experience,specialization) VALUES (:username, :password, :role,:email,:address,:phone, NOW(),:license,:experience,:specialization)";
        $stmt = $this->db->prepare($query);

        // Bind parameters to prevent SQL injection
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':license', $license);
        $stmt->bindParam(':experience', $experience);
        $stmt->bindParam(':specialization', $specialization);

        return $stmt->execute();
    }
    public function getUserByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Returns an associative array or false
    }
     

    // Update the password and clear the reset token
    public function updatePassword($email, $hashedPassword) {
        $query = "UPDATE users SET password = :password WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);
    
        if (!$stmt->execute()) {
            error_log("Password Update Error: " . implode(', ', $stmt->errorInfo()));
            return false;
        }
    
        return true;
    }
    

    // Clear reset token after password update
    public function clearResetToken($token) {
        $query = "DELETE FROM password_resets WHERE token = :token";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
    }
    
    public function emailExists($email) {
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        // Return true if email exists, false otherwise
        return $stmt->fetchColumn() > 0;
    }
    public function phoneExists($phone) {
        $query = "SELECT COUNT(*) FROM users WHERE phone = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$phone]);
        return $stmt->fetchColumn() > 0;
    }
    public function getUserByResetToken($token) {
        $query = "SELECT email FROM password_resets WHERE token = :token AND expiry > NOW()";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':token', $token);
    
        if (!$stmt->execute()) {
            error_log("SQL Error: " . implode(', ', $stmt->errorInfo()));
            return false;
        }
    
        return $stmt->fetch(PDO::FETCH_ASSOC); // Return email if token is valid
    }
    
    
    
    
    
    
    
    public function storePasswordResetToken($email, $token, $expiry) {
        $query = "INSERT INTO password_resets (email, token, expiry) 
                  VALUES (:email, :token, :expiry)
                  ON DUPLICATE KEY UPDATE token = :token, expiry = :expiry";
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
  
    public function deletePasswordResetToken($token) {
        $query = "DELETE FROM password_resets WHERE token = :token";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':token', $token);
        return $stmt->execute();
    }
    public function updateUserProfile($userId, $name, $email, $address, $phone, $specialization, $role) {
        $query = "UPDATE users SET name = :name, email = :email, address = :address, phone = :phone";
    
        // Only update specialization if the user is a lawyer
        if ($role === 'lawyer') {
            $query .= ", specialization = :specialization";
        }
    
        $query .= " WHERE id = :user_id";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':address', $address, PDO::PARAM_STR);
        $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
    
        if ($role === 'lawyer') {
            $stmt->bindValue(':specialization', $specialization, PDO::PARAM_STR);
        }
    
        $stmt->bindValue(':user_id', (int)$userId, PDO::PARAM_INT);
    
        return $stmt->execute();
    }
    public function getClientCount() {
        $query = "SELECT COUNT(*) AS total FROM users WHERE role = 'client'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    public function getLawyerCount() {
        $query = "SELECT COUNT(*) AS total FROM users WHERE role = 'lawyer'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
   //get only user count
       public function getUserCount() {
        $query = "SELECT COUNT(*) AS total FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];}
        
   
    
    
    
    
    
    
    
}
