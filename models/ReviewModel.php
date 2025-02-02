<?php
class ReviewModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Insert a new review
    public function addReview($clientId, $caseId, $lawyerId, $rating, $reviewText) {
        // Check if client_id exists in users table
        $query = "SELECT id FROM users WHERE id = :client_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':client_id', $clientId);
        $stmt->execute();
        
        if ($stmt->rowCount() == 0) {
            error_log("Error: Client ID ($clientId) does not exist in users table.");
            return false; // Prevent insertion
        }
    
        // Insert review into the reviews table
        $query = "INSERT INTO reviews (client_id, case_id, lawyer_id, rating, review_text, created_at) 
                  VALUES (:client_id, :case_id, :lawyer_id, :rating, :review_text, NOW())";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':client_id', $clientId);
        $stmt->bindParam(':case_id', $caseId);
        $stmt->bindParam(':lawyer_id', $lawyerId);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':review_text', $reviewText);
        $result = $stmt->execute();
        
        return $result;
    }
    
    public function getReviewsByClient($clientId) {
        $query = "SELECT r.*, c.title AS case_title, u.name AS lawyer_name 
                  FROM reviews r
                  JOIN cases c ON r.case_id = c.id
                  JOIN users u ON r.lawyer_id = u.id
                  WHERE r.client_id = :client_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':client_id', $clientId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Get reviews by lawyer
    public function getReviewsByLawyer($lawyerId) {
        $query = "SELECT r.*, c.title AS case_title, u.name AS lawyer_name 
                  FROM reviews r
                  JOIN cases c ON r.case_id = c.id
                  JOIN users u ON r.lawyer_id = u.id
                  WHERE r.lawyer_id = :lawyer_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':lawyer_id', $lawyerId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Get review by ID
    public function getReviewById($reviewId) {
        $query = "SELECT * FROM reviews WHERE id = :review_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':review_id', $reviewId);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // update review
    public function updateReview($reviewId, $rating, $reviewText) {
        try {
            $query = "UPDATE reviews SET rating = :rating, review_text = :review_text WHERE id = :review_id";
            $stmt = $this->db->prepare($query);
        
            $stmt->bindValue(':rating', (int) $rating, PDO::PARAM_INT);
            $stmt->bindValue(':review_text', (string) $reviewText, PDO::PARAM_STR);
            $stmt->bindValue(':review_id', (int) $reviewId, PDO::PARAM_INT);
        
            if (!$stmt->execute()) {
                throw new Exception("Update failed: " . implode(", ", $stmt->errorInfo()));
            }
        
            return true;
        } catch (Exception $e) {
            error_log("Update Review Error: " . $e->getMessage());
            return false;
        }
        
    }
    // Delete a review
    public function deleteReview($reviewId) {
        $query = "DELETE FROM reviews WHERE id = :review_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':review_id', $reviewId);
        return $stmt->execute();
    }
    
    

    
}
