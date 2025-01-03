<?php
class AdminController {
    public function __construct() {
        // Restrict access to admin only
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: router.php?controller=auth&action=login");
            exit;
        }
    }

    public function dashboard() {
        require_once 'views/admin/dashboard.php';
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
