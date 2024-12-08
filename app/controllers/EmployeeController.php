<?php
class EmployeeController extends Controller {

    public function postJob()
    {
        //session_start(); // Start the session to access admin_id
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminId = $_SESSION['admin_id']; // Retrieve the admin's ID from the session
            $jobName = $_POST['job_name'];
            $description = $_POST['description'];
            $vacancies = $_POST['vacancies'];
            $rate = $_POST['rate'];
            $location = $_POST['location'];
    
            // Handle file upload
            $jobFile = null;
            if (!empty($_FILES['job_file']['name'])) {
                $targetDir = 'uploads/jobs/';
                $fileName = time() . '_' . $_FILES['job_file']['name'];
                $targetFile = $targetDir . $fileName;
                if (move_uploaded_file($_FILES['job_file']['tmp_name'], $targetFile)) {
                    $jobFile = $fileName;
                } else {
                    echo "Failed to upload file.";
                    exit();
                }
            }
    
            // Call the model to save job details with admin_id
            $userModel = new UserModel();
            $userModel->postJob($jobName, $description, $vacancies, $rate, $location, $jobFile, $adminId);
    
            // Redirect to the job management page or show a success message
            header('Location: /adminhome');
            exit();
        }
    
        // Load the job posting form
        $this->view('postjob');
    }
    


}