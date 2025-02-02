<?php

class CaseController {
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $clientEmail = $_SESSION['user_email']; // Assuming the user's email is stored in the session

            $caseModel = new CaseModel();
            $result = $caseModel->createCase($title, $description, $clientEmail);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Case created successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create case.']);
            }
            exit;
        }
    }
    public function viewUnassignedCases() {
        // Ensure the user is a lawyer
        if ($_SESSION['user_role'] !== 'lawyer') {
            header('Location: router.php?controller=auth&action=login');
            exit;
        }

        // Fetch unassigned cases
       
        $caseModel = new CaseModel();
        $cases = $caseModel->getUnassignedCases();

        // Load the view
        require_once 'views/lawyer/viewUnassignedCases.php';
    }

    // Accept a case
    public function acceptCase() {
        header('Content-Type: application/json');
        if ($_SESSION['user_role'] !== 'lawyer') {
            echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
            exit;
        }
    
        $caseId = $_POST['id'] ?? null;
    
        if (!$caseId) {
            echo json_encode(['success' => false, 'message' => 'Invalid case ID.']);
            exit;
        }
    
        $caseModel = new CaseModel();
        $lawyerId = $_SESSION['user_id'];
        $lawyerEmail = $_SESSION['user_email'];
    
        $result = $caseModel->acceptCase($caseId, $lawyerId,$lawyerEmail);
    
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Case accepted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to accept the case.']);
        }
    
        exit;
    }
    public function viewAssignedCases() {
        // Ensure the user is a lawyer
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'lawyer') {
            header('Location: router.php?controller=auth&action=login');
            exit;
        }
    
        // Get the logged-in lawyer's ID
        $lawyerId = $_SESSION['user_id'];
    
        // Fetch assigned cases
        $caseModel = new CaseModel();
        $assignedCases = $caseModel->getAssignedCases($lawyerId);
    
        // Load the view and pass data
        require_once 'views/lawyer/viewAssignedCases.php';
    }
    public function completeCase() {
        header('Content-Type: application/json');
        // Ensure the user is a lawyer
        if ($_SESSION['user_role'] !== 'lawyer') {
            echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
            exit;
        }
    
        // Get case ID from the request
        $caseId = $_POST['id'] ?? null;
        if (!$caseId) {
            echo json_encode(['success' => false, 'message' => 'Invalid case ID.']);
            exit;
        }
    
        // Mark case as completed
        $caseModel = new CaseModel();
        $lawyerId = $_SESSION['user_id'];
    
        $result = $caseModel->markCaseAsCompleted($caseId, $lawyerId);
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Case marked as completed.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update case.']);
        }
        exit;
    }
    
    
    
   
    
}
