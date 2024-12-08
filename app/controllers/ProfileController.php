<?php
class ProfileController extends Controller {

   // In your controller
   public function manageProfile() {
    //session_start();
    $userId = $_SESSION['user_id']; // Get the logged-in user's ID

    $userModel = new UserModel();

    // Fetch the profile data for the user
    $profile = $userModel->getUserProfile($userId);

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $age = $_POST['age'];
        $birthday = $_POST['birthday'];
        $place = $_POST['place'];
        $jobExperience = $_POST['job_experience'];
        $relatedJobs = $_POST['related_jobs'];

        // Handle profile picture upload
        $profilePicture = $profile['profile_picture'] ?? null; // Use existing picture if no new one is uploaded
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/public/uploads/profile_pictures/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = uniqid() . '_' . basename($_FILES['profile_picture']['name']);
            $uploadFile = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFile)) {
                $profilePicture = '/public/uploads/profile_pictures/' . $fileName; // Save relative path
            } else {
                echo "Failed to upload profile picture.";
            }
        }

        // Insert or update the profile in the database
        if ($profile) {
            $userModel->updateProfile($userId, $name, $age, $birthday, $place, $jobExperience, $relatedJobs, $profilePicture);
        } else {
            $userModel->createProfile($userId, $name, $age, $birthday, $place, $jobExperience, $relatedJobs, $profilePicture);
        }

        // Redirect to refresh the page
        header("Location: /profile");
        exit();
    }

    // Render the profile page
    $this->view('editprofile', ['profile' => $profile]);
}

   

    

}