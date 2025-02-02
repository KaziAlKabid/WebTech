<?php
class ReviewController {
    public function submitReview() {
        header('Content-Type: application/json');
    
        if ($_SESSION['user_role'] !== 'client') {
            echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
            exit;
        }
    
        $clientId = $_SESSION['user_id'] ?? null; // Fix: Use ID instead of email
        $caseId = $_POST['case_id'] ?? null;
        $rating = $_POST['rating'] ?? null;
        $reviewText = $_POST['review_text'] ?? null;
        
        if (!$clientId || !$caseId || !$rating || !$reviewText) {
            echo json_encode(['success' => false, 'message' => 'All fields are required.']);
            exit;
        }
    
        $caseModel = new CaseModel();
        $case = $caseModel->getCaseById($caseId);
    
        if (!$case || $case['client_email'] !== $_SESSION['user_email'] || $case['status'] !== 'completed') {
            echo json_encode(['success' => false, 'message' => 'Invalid case or case not completed.']);
            exit;
        }
    
        $lawyerId = $case['assigned_lawyer_id'];
    
       
    
        $reviewModel = new ReviewModel();
        $result = $reviewModel->addReview($clientId, $caseId, $lawyerId, $rating, $reviewText);
    
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Review submitted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to submit review.']);
        }
        exit;
    }
    public function updateReview() {
        header('Content-Type: application/json');
    
        if ($_SESSION['user_role'] !== 'client') {
            echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
            exit;
        }
        $reviewId = $_POST['id'] ?? null;
        if (!$reviewId) {
            echo json_encode(['success' => false, 'message' => 'Review ID is required.']);
            exit;
        }
        $rating = $_POST['rating'] ?? null;
        
        $reviewText = $_POST['review_text'] ?? null;
        
        //update review
        $reviewModel = new ReviewModel();
        $review = $reviewModel->getReviewById($reviewId);
        if (!$review) {
            echo json_encode(['success' => false, 'message' => 'Review not found.']);
            exit;
        }
        $result = $reviewModel->updateReview($reviewId, $rating, $reviewText);
        //check if review is updated
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Review updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update review.']);
        }
        exit;
       }
       //delete review
    public function deleteReview(){
        header('Content-Type: application/json');
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'client') {
            header('Location: router.php?controller=auth&action=login');
            exit;
        }

        $reviewId = $_POST['review_id'] ;
        $reviewModel = new ReviewModel();
        $review = $reviewModel->getReviewById($reviewId);
        if (!$review) {
            echo "Error: Review not found.";
            exit;
        }

        $result = $reviewModel->deleteReview($reviewId);
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Review deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete review.']);
        }
       
    }
}
    