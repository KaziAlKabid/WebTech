<?php

class CaseModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createCase($title, $description, $clientEmail) {
        $query = "INSERT INTO cases (title, description, client_email,lawyer_email) VALUES (:title, :description, :client_email,null)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':client_email', $clientEmail);
        return $stmt->execute();
    }
    public function getCasesByClient($clientEmail) {
        $query = "SELECT * FROM cases WHERE client_email = :client_email ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':client_email', $clientEmail);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCaseById($caseId) {
        $query = "SELECT * FROM cases WHERE id = :case_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':case_id', $caseId);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single row
    }
    
    public function getUnassignedCases() {
        $query = "SELECT * FROM cases WHERE status = 'Pending' AND assigned_lawyer_id IS NULL";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update a case to mark it as accepted and assign the lawyer
    public function acceptCase($caseId, $lawyerId,$lawyerIEmail) {
        $query = "UPDATE cases SET status = 'Accepted', assigned_lawyer_id = :lawyer_id,lawyer_email=:lawyer_email WHERE id = :case_id AND status = 'Pending'";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':lawyer_id', $lawyerId);
        $stmt->bindParam(':case_id', $caseId);
        $stmt->bindParam(':lawyer_email', $lawyerIEmail);
        return $stmt->execute();
    }
    public function getAssignedCases($lawyerId) {
        $query = "SELECT * FROM cases WHERE assigned_lawyer_id = :lawyerId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':lawyerId', $lawyerId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function markCaseAsCompleted($caseId, $lawyerId) {
        $query = "UPDATE cases SET status = 'completed' WHERE id = :id AND assigned_lawyer_id = :lawyer_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $caseId);
        $stmt->bindParam(':lawyer_id', $_SESSION['user_id']);
        return $stmt->execute();
    }
    public function getCompletedCasesByClient($clientEmail) {
        $query = "SELECT c.*, u.name AS lawyer_name 
                  FROM cases c
                  JOIN users u ON c.assigned_lawyer_id = u.id
                  WHERE c.client_email = :client_email AND c.status = 'completed'";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':client_email', $clientEmail);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCaseCount() {
        $query = "SELECT COUNT(*) AS total FROM cases";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    public function getCasesByStatus($status) {
        $query = "SELECT c.*, 
                         u.name AS client_name, 
                         u2.name AS lawyer_name 
                  FROM cases c
                  INNER JOIN users u ON c.client_email = u.email  -- Join on email instead of ID
                  LEFT JOIN users u2 ON c.assigned_lawyer_id = u2.id  -- Lawyer still uses ID
                  WHERE c.status = :status";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getRecentCases() {
        $stmt = $this->db->query("SELECT id, client_email, lawyer_email, status FROM cases ORDER BY created_at DESC LIMIT 5");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCasesCountByStatus($status) {
        $query = "SELECT COUNT(*) AS total FROM cases WHERE status = :status";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];  // Fetch only the count
    }
    
    
    

    
    
    
    
    
  
    
    
}
