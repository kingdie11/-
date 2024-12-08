<?php
class JobController extends Controller {

    public function applyJob()
{

    // Check if user_id exists in the session
    if (!isset($_SESSION['user_id'])) {
        echo "You must be logged in to apply for a job.";
        return; // Stop the execution if the user is not logged in
    }

    // Now that we know the user is logged in, we can safely access user_id
    $userId = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $jobId = $_POST['job_id'];

        // Handle file upload
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'public/uploads/attachments/';
            $fileName = basename($_FILES['attachment']['name']);
            $uploadFile = $uploadDir . uniqid() . '_' . $fileName;

            // Move uploaded file
            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadFile)) {
                $attachment = $uploadFile;
            } else {
                $attachment = null;
                echo "Failed to upload file.";
            }
        } else {
            $attachment = null; // No attachment uploaded
        }

        // Set the application status to 'pending'
        $status = 'pending';

        // Call the model to apply for the job
        $userModel = new UserModel();
        $result = $userModel->applyJob($jobId, $userId, $attachment, $status);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Application submitted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to apply for the job. Please try again.']);
        }
    }
}

public function editJob()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the form data
        $jobId = $_POST['job_id'];
        $jobName = $_POST['job_name'];
        $description = $_POST['description'];
        $vacancies = $_POST['vacancies'];
        $rate = $_POST['rate'];
        $location = $_POST['location'];
        $status = $_POST['status'];

        // Initialize the JobModel
        $userModel = new UserModel();

        // Call the updateJob method
        $result = $userModel->updateJob($jobId, $jobName, $description, $vacancies, $rate, $location, $status);

        if ($result) {
            // Redirect back to the admin home on success
            header("Location: /adminhome");
            exit;
        } else {
            // Handle failure (e.g., show an error message)
            echo "Failed to update the job. Please try again.";
        }
    }
}

public function updateApplicationStatus()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the application_id and status from the form submission
        $applicationId = $_POST['application_id'] ?? die("Error: Application ID is missing.");
        $status = $_POST['status'];  // This will be either 'accepted' or 'declined'

        // Call the model to update the status in the database
        $userModel = new UserModel();

        try {
            $result = $userModel->updateApplyStatus($applicationId, $status);  // Call the updateStatus method from the model

            if ($result) {
                echo "Application status updated successfully.";
                header("Location: /adminhome");  // Redirect to admin home page after update
            } else { var_dump($_POST); 
               // echo "Error updating application status."   ;
            }
        } catch (PDOException $e) {
            // Display the exact error message
            die("Error updating application status: " . $e->getMessage());
        }
    }
}



}