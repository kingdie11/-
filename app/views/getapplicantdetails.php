// This should be part of your controller or standalone script
public function getApplicantDetails()
{
    // Ensure that the application_id is passed via GET
    if (isset($_GET['application_id'])) {
        $applicationId = $_GET['application_id'];

        // Database connection details
        $host = 'localhost';
        $db = 'emailnauth';
        $user = 'kingd';
        $pass = 'kingd';
        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

        try {
            // Create PDO connection
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);

            // Prepare SQL to join jobapply, jobs, users, and profiles tables
            $stmt = $pdo->prepare("
                SELECT 
                    ja.id AS application_id, 
                    ja.user_id, 
                    ja.attachment, 
                    ja.status, 
                    j.job_name, 
                    j.location, 
                    j.admin_id, 
                    u.email AS applicant_email, 
                    p.name AS applicant_name, 
                    p.age, 
                    p.birthday, 
                    p.place, 
                    p.job_experience, 
                    p.related_jobs
                FROM 
                    jobapply ja
                JOIN 
                    jobs j ON ja.job_id = j.id
                JOIN 
                    users u ON ja.user_id = u.id
                JOIN 
                    profiles p ON u.id = p.user_id
                WHERE 
                    ja.id = :application_id
            ");

            // Bind the application ID to the SQL query
            $stmt->bindParam(':application_id', $applicationId, PDO::PARAM_INT);

            // Execute the query
            $stmt->execute();

            // Fetch the result
            $applicant = $stmt->fetch();

            // Return the data as a JSON response
            echo json_encode($applicant);

        } catch (PDOException $e) {
            echo json_encode(["error" => "Database error: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["error" => "Application ID not provided."]);
    }
}
