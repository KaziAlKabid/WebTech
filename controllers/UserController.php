<?php
class UserController{
    public function updateProfile() {
        header('Content-Type: application/json');
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized request.']);
            exit;
        }
    
        $userId = $_SESSION['user_id'];
        $userRole = $_SESSION['user_role'];
    
        // Collect only the fields that exist in the form
        $name = $_POST['name'] ?? null;
       
        $address = $_POST['address'] ?? null;
        $phone = $_POST['phone'] ?? null;
        $specialization = $_POST['specialization'] ?? null;
    
        // Validate required fields
        if (!$name || !$phone) {
            echo json_encode(['success' => false, 'message' => 'Name and Phone are required.']);
            exit;
        }
    
        // Call model function to update the profile
        $userModel = new UserModel();
        $success = $userModel->updateUserProfile($userId, $name, $address, $phone, $specialization, $userRole);
    
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Profile updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update profile.']);
        }
        exit;
    }
    
}