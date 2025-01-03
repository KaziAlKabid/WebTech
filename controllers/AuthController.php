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
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $role = $_POST['role'];

            // Hash the password for security
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Use the UserModel to save the user
            require_once 'models/UserModel.php';
            $userModel = new UserModel();

            $isCreated = $userModel->createUser($username, $hashedPassword, $role,$email);

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
        require_once 'views/auth/login.php';
    }
    
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form data
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            // Use the UserModel to check user credentials
            require_once 'models/UserModel.php';
            $userModel = new UserModel();
            $user = $userModel->getUserByEmail($email);
    
            if ($user && password_verify($password, $user['password'])) {
                // Password is correct, set session variables
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_name'] = $user['name'];
    
                // Redirect based on role
                if ($user['role'] === 'admin') {
                    header("Location: router.php?controller=admin&action=dashboard");
                } else {
                    header("Location: router.php?controller=auth&action=login"); // Or a client/lawyer dashboard if available
                }
                exit;
            } else {
                // Invalid credentials, reload login with error
                $error = "Invalid username or password.";
                require_once 'views/auth/login.php';
            }
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
    
    
    
}
