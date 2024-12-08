<?php
class ResetController extends Controller {

    public function verifyEmail() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $userModel = new UserModel();
            $user = $userModel->getUserByEmail($email);
    
            if ($user) {
                // Pass the user to the view
                return $this->view('verifyquestionuser', ['user' => $user]);
            } else {
                // Redirect to an error page or show an error message
                header('Location: /forgotpassword/error?message=Email not found.');
                exit();
            }
        } else {
            // Render the initial email verification form if it's not a POST request
            return $this->view('verify_email');
        }
    }

    public function verifyAnswer() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? $_SESSION['email']; // Try to get the email from POST or session
            $securityAnswer = $_POST['security_answer'];
    
            if ($email) {
                try {
                    $userModel = new UserModel();
                    $user = $userModel->getUserBySecurityAnswer($email, $securityAnswer); // Using POST directly for security answer
    
                    if ($user) {
                        // Store the user ID in session for further steps
                        $_SESSION['user_id'] = $user['id'];
                        return $this->view('verifypassworduser', ['user' => $user]);
                        // Redirect to the password reset page
                    
                    } else {
                        // Log error details
                        error_log("Security answer mismatch for email: $email, given answer: $securityAnswer");
                        // Redirect back with an error
                        header('Location: /forgotpassword?error=Incorrect answer.');
                        exit();
                    }
                } catch (Exception $e) {
                    // Log the error for debugging
                    error_log("Error verifying security answer: " . $e->getMessage());
                    header('Location: /forgotpassword?error=An unexpected error occurred. Please try again.');
                    exit();
                }
            } else {
                // Redirect if email is not provided in POST or session
                header('Location: /forgotpassword');
                exit();
            }
        }
    }
    
    public function updatePassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id']; // Get user ID from hidden field
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];
    
            if ($newPassword === $confirmPassword) {
                try {
                    $userModel = new UserModel();
                    $result = $userModel->updatePassword($userId, $newPassword);
    
                    if ($result) {
                        $_SESSION['success_message'] = "Your password has been reset successfully. Log in now to continue.";
                    header('Location: /login');
                    exit();
                    } else {
                        // Redirect with an error if the update fails
                        header('Location: /password-reset/update?error=Failed to update password.');
                        exit();
                    }
                } catch (Exception $e) {
                    // Log the error
                    error_log("Error updating password: " . $e->getMessage());
                    header('Location: /password-reset/update?error=An unexpected error occurred. Please try again.');
                    exit();
                }
            } else {
                // Redirect back with an error if passwords do not match
                header('Location: /password-reset/update?error=Passwords do not match.');
                exit();
            }
        } else {
            // Redirect if accessed without POST request
            header('Location: /password-reset');
            exit();
        }
    }
}