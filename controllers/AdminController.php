<?php
class AdminController {
    public function __construct() {
        // Restrict access to admin only
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: router.php?controller=auth&action=login");
            exit;
        }
    }
    public function profile() {
        require_once 'models/UserModel.php';
        $userModel = new UserModel();
        $user = $userModel->getUserByEmail($_SESSION['user_email']);

        if (!$user) {
            echo "Error: User not found.";
            exit;
        }

        // Load the profile view
        require_once 'views/profile.php';
    }

    public function Dashboard() {
        $userModel = new UserModel();
        $caseModel = new CaseModel();
        $reviewModel = new ReviewModel();
    
        $clientCount = $userModel->getClientCount();
        $lawyerCount = $userModel->getLawyerCount();
        $caseCount = $caseModel->getCaseCount();
        $userCount = $userModel->getUserCount();
        $reviewCount = $reviewModel->getTotalReviews();
        $adminCount = $userModel->getTotalAdmins();
        
        // Case Lists (Full details)
        $pendingCasesList = $caseModel->getCasesByStatus('pending');  // Array of pending cases
        $ongoingCasesList = $caseModel->getCasesByStatus('ongoing');  // Array of ongoing cases
        $completedCasesList = $caseModel->getCasesByStatus('completed');  // Array of completed cases
        
        // Case Counts (Numbers only)
        $pendingCasesCount = $caseModel->getCasesCountByStatus('pending');  
        $ongoingCasesCount = $caseModel->getCasesCountByStatus('ongoing');  
        $completedCasesCount = $caseModel->getCasesCountByStatus('completed');  
        
        // Recent Activity
        $recentUsers = $userModel->getRecentUsers();
        $recentCases = $caseModel->getRecentCases();
        

    
        require_once 'views/admin/dashboard.php'; // Pass values to the view
    }
    

    public function manageUsers() {
        require_once 'views/admin/manage_users.php';
    }

    public function manageLawyers() {
        require_once 'views/admin/manage_lawyers.php';
    }

    public function manageCases() {
        require_once 'views/admin/manage_cases.php';
    }
}
