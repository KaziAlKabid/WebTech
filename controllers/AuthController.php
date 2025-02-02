<?php
class AuthController {
    public function register() {
        // Load the registration view
        require_once 'views/auth/register.php';
    }
    public function forgot_password() {
        // Load the forgot password view
        require_once 'views/auth/forgot_password.php';
    }
    public function processResetPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            $token = $_POST['token'] ?? '';
            $password = $_POST['password'] ?? '';
    
            // Validate inputs
            if (empty($token) || empty($password)) {
                echo json_encode(['success' => false, 'message' => 'Token or password is missing.']);
                exit;
            }
    
            $userModel = new UserModel();
            $resetRequest = $userModel->getUserByResetToken($token);
    
            // Validate token
            if (!$resetRequest) {
                echo json_encode(['success' => false, 'message' => 'Invalid or expired token.']);
                exit;
            }
    
            // Hash the new password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $email = $resetRequest['email'];
    
            // Update the password
            if ($userModel->updatePassword($email, $hashedPassword)) {
                // Clear the token after successful password reset
                $userModel->clearResetToken($token);
    
                echo json_encode(['success' => true, 'message' => 'Password reset successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to reset password.']);
            }
            exit;
        }}
    

    
    
        public function processForgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            $email = $_POST['email'] ?? '';
    
            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
                exit;
            }
    
            // Check if email exists
            $userModel = new UserModel();
            $user = $userModel->getUserByEmail($email);
    
            if (!$user) {
                echo json_encode(['success' => false, 'message' => 'No account found with this email.']);
                exit;
            }
    
            // Generate token and expiry
            $token = bin2hex(random_bytes(32));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
            // Store the reset token
            $userModel->storePasswordResetToken($email, $token, $expiry);
    
            // Generate the reset link
            $resetLink = SITE_URL . "/router.php?controller=auth&action=resetPassword&token=$token";
    
            // For localhost, display the reset link
            echo json_encode(['success' => true, 'resetLink' => $resetLink]);
            exit;
        }
    }
    
    public function resetPassword() {
        $token = $_GET['token'] ?? '';
    
        if (empty($token)) {
            echo "Token is missing.";
            exit;
        }
    
        $userModel = new UserModel();
        $resetRequest = $userModel->getUserByResetToken($token);
    
        if (!$resetRequest) {
            echo "Invalid or expired token.";
            exit;
        }
    
        // Load reset password form
        require_once 'views/auth/reset_password.php';
    }
    
    
    
    public function store() {
        header('Content-Type: application/json'); // Ensure JSON response
    
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid request method.'
                ]);
                return;
            }
    
            // Retrieve form data
            $name = $_POST['name'] ?? null;
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
            $role = $_POST['role'] ?? null;
            $address = $_POST['address'] ?? null;
            $phone = $_POST['phone'] ?? null;
            $license = $_POST['license'] ?? null;
            $experience = $_POST['experience'] !== '' ? $_POST['experience'] : null;
$specialization = $_POST['specialization'] !== '' ? $_POST['specialization'] : null;

    
            // Validate common fields
            if($role==='client') {if(!$name || !$email || !$password || !$role|| !$address || !$phone ) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Name, email, password, and role,address,phone are required.'
                ]);
                return;
            }}
    
           
           
    
            else if ($role === 'lawyer') {
                if ($license===null || $experience===null || $specialization===null) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'License, experience, and specialization are required for lawyers.'
                    ]);
                    return;
                }
    
                
    
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid role specified.'
                ]);
                return;
            }
    
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
            // Save user to database
            $userModel = new UserModel();
            $isCreated = $userModel->createUser(
                $name, 
                $hashedPassword, 
                $role, 
                $email, 
                $address, 
                $phone, 
                $license, 
                $experience, 
                $specialization
            );
    
            if ($isCreated) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Registration successful!',
                    'redirect' => 'router.php?controller=auth&action=login'
                ]);
                return;
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to register user.'
                ]);
                return;
            }
        } catch (Exception $e) {
            // Handle unexpected errors
            echo json_encode([
                'success' => false,
                'message' => 'An unexpected error occurred: ' . $e->getMessage()
            ]);
        }
    }
    
    
    
    public function checkPhone() {
        header('Content-Type: application/json');
    
        $phone = $_POST['phone'] ?? null;

    
        if (!$phone) {
            echo json_encode(['exists' => false, 'message' => 'No phone number provided.']);
            return;
        }
        
    
        $userModel = new UserModel();
        $exists = $userModel->phoneExists($phone);
        if ($exists) {
            echo json_encode(['exists' => true]);
        } else {
            echo json_encode(['exists' => false]);
        }
    
       
    }
    
    
    
    

    public function login() {
        
        if (isset($_SESSION['user_id'])) {
            $_SESSION['message'] = 'You are already logged in!';
            header('Location: router.php?controller=admin&action=dashboard');
            exit;
        }
    
        // Load the login view
        require_once 'views/auth/login.php';
    }
    
    public function authenticate() {
       
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
if (empty($email) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Email and password are required.']);
            exit;
        }
        // Validate email
        $userModel = new UserModel();
        $user = $userModel->getUserByEmail($email);
        if (!$user) {
            echo json_encode(['success' => false, 'error' => 'email_not_found', 'message' => 'No account found with this email.']);
            exit;
        }
             // Verify password
             if (!password_verify($password, $user['password'])) {
                echo json_encode(['success' => false, 'error' => 'wrong_password', 'message' => 'Incorrect password.']);
                exit;
            }
                // Login successful
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        if ($user['role'] === 'admin') {
            echo json_encode(['success' => true, 'redirect' => 'router.php?controller=admin&action=dashboard']);
            exit;
        } else if($user['role'] === 'client') {
            echo json_encode(['success' => true, 'redirect' => 'router.php?controller=client&action=dashboard']);
            exit;
        }
        else if($user['role'] === 'lawyer') {
            echo json_encode(['success' => true, 'redirect' => 'router.php?controller=lawyer&action=dashboard']);
            exit;}
        
    }
}
    
    public function logout() {
        // Destroy the session
        session_start();
        session_unset();
        session_destroy();
    
        // Redirect to the login page
        header("Location: router.php?controller=auth&action=login");
        exit;
    }
    public function checkEmail() {
        try {
            // Set content type for JSON response
            header('Content-Type: application/json');
    
            // Retrieve the email from POST or GET
            $email = $_POST['email'] ?? $_GET['email'] ?? null;
    
            // Validate email format
            if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['exists' => false, 'message' => 'Invalid email format.']);
                exit;
            }
    
            // Check if the email exists using the UserModel
            $userModel = new UserModel();
            $emailExists = $userModel->emailExists($email);
    
            // Return JSON response
            echo json_encode(['exists' => $emailExists]);
            exit;
        } catch (Exception $e) {
            // Log the error for debugging
            error_log("Error in checkEmail: " . $e->getMessage());
    
            // Return a generic error message
            echo json_encode(['exists' => false, 'message' => 'Server error.']);
            exit;
        }
    }
    
}