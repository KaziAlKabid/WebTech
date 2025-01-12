<?php
class LawyerController {
    public function __construct() {
        // Restrict access to lawyer only
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'lawyer') {
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
        require_once 'views/Lawyer/dashboard.php';
    }
}
