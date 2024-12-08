<?php
class AuthController extends Controller {
    
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $securityQuestion = $_POST['security_question'];
            $securityAnswer = $_POST['security_answer'];
    
            $userModel = new UserModel();
            if ($userModel->register($username, $email, $password, $securityQuestion, $securityAnswer)) {
                // Registration success
                echo "<script>alert('Registration successful!'); window.location='/login';</script>";
            } else {
                echo "<script>alert('Registration failed. Try again.'); window.location='/register';</script>";
            }
        } else {
            $this->view('register');
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            $userModel = new UserModel();
            $user = $userModel->login($email, $password);
    
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                // Redirect to the email page after successful login
                header("Location: /email");
                exit;
            } else {
                echo "Login failed!";
            }
        }
    
        $this->view('login');
    }


    public function getuserid()
    {
        // Check if the user is logged in
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            // Redirect to login if no user is logged in
            header("Location: /login");
            exit;
        }

        // Fetch user data for display
        $userModel = new UserModel();
        $user = $userModel->getUserById($userId);

        // Render the home page with user data
        return $this->view('send', ['user' => $user]);
    }

    public function logout()
    {
        //session_start(); // Start the session

        // Destroy all session data
        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session

        // Redirect to the login page
        header("Location: /log");
        exit();
        
    }

    public function adminlogout()
    {
        //session_start(); // Start the session

        // Destroy all session data
        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session

        // Redirect to the login page
        header("Location: /adminlog");
        exit();
        
    }

    public function adminregister()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data
        $email = $_POST['email'];
        $password = $_POST['password'];
        $companyName = $_POST['company_name'];

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Call the model to save the admin details
        $userModel = new UserModel();
        $isRegistered = $userModel->registerAdmin($email, $hashedPassword, $companyName);

        if ($isRegistered) {
            // Registration successful
            header('Location: adminlogin');
            exit();
        } else {
            // Handle registration failure
            echo "Registration failed. Please try again.";
        }
    }

    // Load the registration view
    $this->view('adminregister');
}

public function adminlogin()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Call the model to validate admin credentials
        $userModel = new UserModel();
        $admin = $userModel->adminlogin($email);

        if ($admin && password_verify($password, $admin['password'])) {
            // Start a session and store admin details
            //session_start();
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_email'] = $admin['email'];

            // Redirect to the admin dashboard
            header('Location: /adminhome');
            exit();
        } else {
            // Handle login failure
            echo "Invalid email or password. Please try again.";
        }
    }

    // Load the login view
    $this->view('adminlogin');
}

}

