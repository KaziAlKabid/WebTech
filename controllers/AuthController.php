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
    public function processForgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
    
            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
                exit;
            }
    
            // Check if email exists
            $userModel = new UserModel();
            if (!$userModel->emailExists($email)) {
                echo json_encode(['success' => false, 'message' => 'No account found with this email.']);
                exit;
            }
    
            // Generate a unique token
            $token = bin2hex(random_bytes(32));
            $userModel->storePasswordResetToken($email, $token);
    
            // Generate the reset link
            $resetLink = BASE_URL . "/router.php?controller=auth&action=resetPassword&token=$token";
    
            // Return JSON response with the reset link
            echo json_encode(['success' => true, 'resetLink' => $resetLink]);
            exit;
        }
    }
    
    
    
    public function store() {
        header('Content-Type: application/json');
    
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
    
            // Validate fields
            if (!$name || !$email || !$password || !$role || !$address || !$phone) {
                echo json_encode([
                    'success' => false,
                    'message' => 'All fields are required.'
                ]);
                return;
            }
    
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
            // Save user to database
            $userModel = new UserModel();
            $isCreated = $userModel->createUser($name, $hashedPassword, $role, $email, $address, $phone);
    
            if ($isCreated) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Registration successful!'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Registration failed. Please try again.'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'An unexpected error occurred on the server.'
            ]);
        }
    }
    
    public function checkPhone() {
        header('Content-Type: application/json');
    
        $phone = $_GET['phone'] ?? null;
    
        if (!$phone) {
            echo json_encode(['exists' => false, 'message' => 'No phone number provided.']);
            return;
        }
    
        $userModel = new UserModel();
        $exists = $userModel->phoneExists($phone);
    
        echo json_encode(['exists' => $exists]);
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
        echo json_encode(['success' => true, 'redirect' => 'router.php?controller=admin&action=dashboard']);
        exit;
        
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
        // Get the email from the request
     try{   $email = $_POST['email'] ?? $_GET['email'] ?? null;

    
        // Validate the email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['exists' => false, 'message' => 'Invalid email format.']);
            exit;
        }
    
      
        $userModel = new UserModel();
        $emailExists = $userModel->emailExists($email);
    
      
        echo json_encode(['exists' => $emailExists]);
        exit;
    }catch (Exception $e) {
        echo json_encode(['exists' => false, 'message' => 'Server error.']);
        exit;
    
    }
    }
}