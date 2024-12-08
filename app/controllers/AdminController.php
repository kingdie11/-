<?php
class AdminController extends Controller {

    // In AdminController.php

public function manageAdmin() {
    //session_start();
    $adminId = $_SESSION['admin_id'];  // Get the logged-in admin ID

    $userModel = new UserModel();

    $companyProfile = $userModel->getCompanyProfile($adminId);

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $companyName = $_POST['company_name'];
        $address = $_POST['company_address'];
        $email = $_POST['contact_email'];
        $phone = $_POST['contact_phone'];
        $website = $_POST['website_url'];
        $description = $_POST['description'];

        // Handle company logo upload
        $companyLogo = $companyProfile['company_logo'] ?? null;  // Use existing logo if no new one uploaded
        if (isset($_FILES['company_logo']) && $_FILES['company_logo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/uploads/company_logos/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = uniqid() . '_' . basename($_FILES['company_logo']['name']);
            $uploadFile = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['company_logo']['tmp_name'], $uploadFile)) {
                $companyLogo = 'uploads/company_logos/' . $fileName; // Save the relative path
            } else {
                echo "Failed to upload company logo.";
            }
        }

        // Insert or update the company profile in the database
        if ($companyProfile) {
            // Update existing profile
            $userModel->updateCompanyProfile($companyProfile['id'], $companyName, $address, $email, $phone, $website, $description, $companyLogo);
        } else {
            // Create a new profile
            $userModel->createCompanyProfile($adminId, $companyName, $address, $email, $phone, $website, $description, $companyLogo);
        }

        // Redirect to the profile page after saving
        header("Location: /adminprofile");
        exit();
    }

    // Render the view
    $this->view('editadmin', ['companyProfile' => $companyProfile]);
}


}