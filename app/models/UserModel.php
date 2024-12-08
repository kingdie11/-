<?php

class UserModel extends Model {
    

    public function register($username, $email, $password, $securityQuestion, $securityAnswer) {
        $userData = [
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'security_question' => $securityQuestion,
            'security_answer' => $securityAnswer,
        ];
    
        try {
            return $this->db->table('users')->insert($userData);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function login($email, $password) {
        $user = $this->db->table('users')->where('email', $email)->get();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }


    public function registerAdmin($email, $hashedPassword, $companyName)
{
    return $this->db->table('admins')->insert([
        'email' => $email,
        'password' => $hashedPassword,
        'company_name' => $companyName,
    ]);
}

    protected $table = 'users'; // Your users table

    public function getUserById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createProfile($userId, $name, $age, $birthday, $place, $jobExperience, $relatedJobs, $profilePicture) {
        return $this->db->table('profiles')->insert([
            'user_id' => $userId,
            'name' => $name,
            'age' => $age,
            'birthday' => $birthday,
            'place' => $place,
            'job_experience' => $jobExperience,
            'related_jobs' => $relatedJobs,
            'profile_picture' => $profilePicture,
        ]);
    }
    
    public function updateProfile($userId, $name, $age, $birthday, $place, $jobExperience, $relatedJobs, $profilePicture) {
        return $this->db->table('profiles')->where('user_id', $userId)->update([
            'name' => $name,
            'age' => $age,
            'birthday' => $birthday,
            'place' => $place,
            'job_experience' => $jobExperience,
            'related_jobs' => $relatedJobs,
            'profile_picture' => $profilePicture,
        ]);
    }
    
    public function getUserProfile($userId) {
        return $this->db->table('profiles')->where('user_id', $userId)->get();
    }
    

    // Method to get user profile information
    /*public function getUserProfile($userId)
    {
        // Fetch the user's profile data from the 'users' table based on their user_id
        return $this->db->table('users')
            ->where('id', $userId)
            ->get();
    }*/

    public function adminlogin($email)
{
    return $this->db->table('admins')->where('email', $email)->get();
}

public function postJob($jobName, $description, $vacancies, $rate, $location, $jobFile, $adminId)
{
    $this->db->table('job')->insert([
        'job_name' => $jobName,
        'description' => $description,
        'vacancies' => $vacancies,
        'rate' => $rate,
        'location' => $location,
        'job_file' => $jobFile,
        'admin_id' => $adminId,
    ]);
}

public function applyJob($jobId, $userId, $attachment, $status = 'pending')
{
    // Prepare the data for insertion
    $applicationData = [
        'job_id' => $jobId,
        'user_id' => $userId,
        'attachment' => $attachment,
        'status' => $status
    ];

    // Insert data into job_applications table
    try {
        // Using the insert method provided by the database abstraction layer
        return $this->db->table('jobapply')->insert($applicationData);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

public function updateJob($jobId, $jobName, $description, $vacancies, $rate, $location, $status)
{
    // Prepare the data for updating
    $jobData = [
        'job_name' => $jobName,
        'description' => $description,
        'vacancies' => $vacancies,
        'rate' => $rate,
        'location' => $location,
        'status' => $status
    ];

    try {
        // Use the database abstraction layer to update the job in the 'jobs' table
        return $this->db->table('job')
                        ->where('id', $jobId)
                        ->update($jobData);  // This assumes `update` works like `insert` but modifies existing records
    } catch (PDOException $e) {
        die("Error updating job: " . $e->getMessage());
    }
}

public function updateApplyStatus($applicationId, $status)
{
    // Prepare the data for updating the application status
    $applicationData = [
        'status' => $status  // Only updating the status in the 'jobapply' table
    ];

    try {
        // Using the database abstraction layer to update the 'jobapply' table
        return $this->db->table('jobapply')  // Targeting the 'jobapply' table
                        ->where('application_id', $applicationId)  // Filter by application_id
                        ->update($applicationData);  // Update the status field
    } catch (PDOException $e) {
        die("Error updating application status: " . $e->getMessage());
    }
}

public function getCompanyProfile($adminId) {
    return $this->db->table('company_profile')->where('admin_id', $adminId)->get();
}

// Create a new company profile
public function createCompanyProfile($adminId, $companyName, $address, $email, $phone, $website, $description, $logo)
{
    return $this->db->table('company_profile')->insert([
        'admin_id' => $adminId,
        'company_name' => $companyName,
        'company_address' => $address,
        'contact_email' => $email,
        'contact_phone' => $phone,
        'website_url' => $website,
        'description' => $description,
        'company_logo' => $logo
    ]);
}

// Update an existing company profile
public function updateCompanyProfile($companyId, $companyName, $address, $email, $phone, $website, $description, $logo)
{
    return $this->db->table('company_profile')->where('id', $companyId)->update([
        'company_name' => $companyName,
        'company_address' => $address,
        'contact_email' => $email,
        'contact_phone' => $phone,
        'website_url' => $website,
        'description' => $description,
        'company_logo' => $logo
    ]);
}

public function getUserByEmail($email) {
    return $this->db->table('users')
                    ->where('email', $email)
                    ->get();
                    
}

public function getUserBySecurityAnswer($email, $securityAnswer) {
    try {
        // Fetch the user by email and security answer
        $user = $this->db->table('users')
                         ->where('email', $email)
                         ->where('security_answer', $securityAnswer) // Ensure answer matches
                         ->get();
                          // Fetch the first matching result

        return $user ? $user : false; // Return false if no user is found
    } catch (Exception $e) {
        // Log the error for debugging
        error_log("Error fetching user by security answer: " . $e->getMessage());
        return false;
    }
}

public function updatePassword($userId, $newPassword) {
    try {
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the password in the database
        return $this->db->table('users')
                        ->where('id', $userId)
                        ->update(['password' => $hashedPassword]);
    } catch (Exception $e) {
        // Log the error
        error_log("Error updating password: " . $e->getMessage());
        return false;
    }
}

}


