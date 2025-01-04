<?php
class AuthController {
    public function register() {
        // Load the registration view
        require_once 'views/auth/register.php';
    }
    public function store() {
        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form data
            $name = $_POST['name'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];

            // Hash the password for security
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Use the UserModel to save the user
            require_once 'models/UserModel.php';
            $userModel = new UserModel();

            $isCreated = $userModel->createUser($name, $hashedPassword, $role,$email,$address,$phone);

            if ($isCreated) {
                // Redirect to login page after successful registration
                header("Location: router.php?controller=auth&action=login");
                exit;
            } else {
                // Reload the registration page with an error message
                $error = "Registration failed. Please try again.";
                require_once 'views/auth/register.php';
            }
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
       

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Example: Validate credentials using UserModel
        require_once 'models/UserModel.php';
        $userModel = new UserModel();
        $user = $userModel->getUserByEmail($email);
        

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_id'] = $user['id'];

            // Return success JSON response
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'redirect' => 'router.php?controller=admin&action=dashboard']);
        } else {
            // Return failure JSON response
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
        }
        exit;
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
        $email = $_GET['email'] ?? null;
    
        // Validate the email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['exists' => false, 'message' => 'Invalid email format.']);
            exit;
        }
    
        // Use UserModel to check email existence
        require_once 'models/UserModel.php';
        $userModel = new UserModel();
        $emailExists = $userModel->emailExists($email);
    
        // Return JSON response
        echo json_encode(['exists' => $emailExists]);
        exit;
    }
    
    
    
    
}
