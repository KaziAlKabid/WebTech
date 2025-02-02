<?php
class ClientController {
    public function __construct() {
        // Restrict access to client only
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'client') {
            header("Location: router.php?controller=auth&action=login");
            exit;
        }
    }
    public function profile() {
        $userModel = new UserModel();
        $user = $userModel->getUserByEmail($_SESSION['user_email']);

        if (!$user) {
            echo "Error: User not found.";
            exit;
        }

        // Load the profile view
        require_once 'views/profile.php';
    }

    public function dashboard() {
        require_once 'views/client/dashboard.php';
    }
   
    public function createCase() {
        // Load the create case view
        require_once 'views/client/create_case.php';
    }
    public function viewCases() {
        // Ensure the user is logged in
        if (!isset($_SESSION['user_email'])) {
            header('Location: router.php?controller=auth&action=login');
            exit;
        }
    
        // Get the logged-in user's email
        $clientEmail = $_SESSION['user_email'];
    
        // Fetch cases from the database using CaseModel
        require_once 'models/CaseModel.php';
        $caseModel = new CaseModel();
        $cases = $caseModel->getCasesByClient($clientEmail);
    
        // Load the view and pass the cases
        require_once 'views/client/viewCases.php';
    }
    public function viewCompletedCases() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'client') {
            header('Location: router.php?controller=auth&action=login');
            exit;
        }
    
        $clientEmail = $_SESSION['user_email']; 
        
        
        
        $caseModel = new CaseModel();
        $cases = $caseModel->getCompletedCasesByClient($clientEmail);
        $reviewModel = new ReviewModel();
        $reviews = $reviewModel->getReviewsByClient($clientEmail);
    
        require_once 'views/client/viewCompletedCases.php';
    }
    public function submitReview(){
        require_once 'views/client/submitReview.php';
    }
    public function viewReviews() {
        // Ensure the client is logged in
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'client') {
            header('Location: router.php?controller=auth&action=login');
            exit;
        }
    
        $clientId = $_SESSION['user_id']; // Using client_id instead of email
    
      
        $reviewModel = new ReviewModel();
        $reviews = $reviewModel->getReviewsByClient($clientId);
    
        // Load the view and pass the reviews
        require_once 'views/client/viewReviews.php';
    }
    //edit review
    public function editReview(){
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'client') {
            header('Location: router.php?controller=auth&action=login');
            exit;
        }

        $reviewId = $_GET['review_id'] ;
        $reviewModel = new ReviewModel();
        $review = $reviewModel->getReviewById($reviewId);
        if (!$review) {
            echo "Error: Review not found.";
            exit;
        }

        require_once 'views/client/editReview.php';
    }
    
    
    
    
}
