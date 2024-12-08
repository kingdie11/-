<?php
// Start session to access admin ID
//session_start();

// Ensure the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    die("Access denied. Please log in as an admin.");
}

// Database connection
$host = 'localhost';
$db = 'emailnauth';
$user = 'kingd';
$pass = 'kingd';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // Fetch jobs for the logged-in admin
    $adminId = $_SESSION['admin_id'];
    $stmt = $pdo->prepare("SELECT * FROM job WHERE admin_id = :admin_id");
    $stmt->bindParam(':admin_id', $adminId, PDO::PARAM_INT);
    $stmt->execute();

    $jobs = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // Fetch applicants for jobs posted by the logged-in admin
    $adminId = $_SESSION['admin_id'];
    $stmt = $pdo->prepare("
            SELECT 
            a.job_id AS application_job_id,
            a.application_id AS application_id, 
            a.user_id, 
            a.attachment, 
            a.status, 
            j.job_name, 
            j.location, 
            j.admin_id, 
            u.email AS applicant_email,
            p.name AS employee_name,
            p.age, 
            p.birthday, 
            p.place, 
            p.job_experience, 
            p.related_jobs
        FROM 
            jobapply a
        JOIN 
            job j ON a.job_id = j.id
        JOIN 
            users u ON a.user_id = u.id
        JOIN 
            profiles p ON u.id = p.user_id
        WHERE 
            j.admin_id = :admin_id
    ");
    $stmt->bindParam(':admin_id', $adminId, PDO::PARAM_INT);
    $stmt->execute();

    $applicants = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}


?>


<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

    <title>QuickStart</title>

    <link rel="stylesheet" type="text/css" href="public/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="public/css/font-awesome.css">

    <link rel="stylesheet" href="public/css/style.css">

    <link rel="stylesheet" href="public/css/modals.css">

    </head>
    
    <body>
    
    <!-- ***** Preloader Start ***** -->
    <div id="js-preloader" class="js-preloader">
      <div class="preloader-inner">
        <span class="dot"></span>
        <div class="dots">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
    </div> 
    <!-- ***** Preloader End ***** -->
    
    
    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="index.html" class="logo">QUICK START<em> Website</em></a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li><a href="adminprofile">Edit</a></li>
                            <li><a href="/adminlogout">Logout</a></li>
                        </ul>        
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <!-- ***** Main Banner Area Start ***** -->
    <div class="main-banner" id="top">
        <video autoplay muted loop id="bg-video">
            <source src="public/images/video.mp4" type="video/mp4" />
        </video>

        <div class="video-overlay header-text">
            <div class="caption">
                <h6>Lorem ipsum dolor sit amet</h6>
                <h2>Find the perfect <em>Job</em></h2>
                <div class="main-button">
                    <a href="/viewpostjob">Post Job</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->

    <div class="job-table-container">
    <h2>My Jobs</h2>
    <table class="styled-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Job Name</th>
                <th>Description</th>
                <th>Vacancies</th>
                <th>Rate</th>
                <th>Location</th>
                <th>Status</th>
                <th>Actions</th>
                <!--<th>Created At</th>-->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jobs as $index => $job): ?>
                <tr>
                    <td><?php echo htmlspecialchars($index + 1); ?></td>
                    <td><?php echo htmlspecialchars($job['job_name']); ?></td>
                    <td><?php echo htmlspecialchars($job['description']); ?></td>
                    <td><?php echo htmlspecialchars($job['vacancies']); ?></td>
                    <td><?php echo htmlspecialchars($job['rate']); ?></td>
                    <td><?php echo htmlspecialchars($job['location']); ?></td>
                    <td>
                        <span class="status <?php echo strtolower($job['status']); ?>">
                            <?php echo htmlspecialchars($job['status']); ?>
                        </span>
                    </td>
                    <!--<td><?php echo htmlspecialchars($job['created_at']); ?></td>-->
                    <td>
                        <button 
                            class="edit-btn" 
                            onclick="openEditModal(<?php echo htmlspecialchars(json_encode($job)); ?>)">
                            Edit
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>

<!-- Edit Modal -->
<div id="editModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2>Edit Job</h2>
        <form id="editJobForm" method="POST" action="/editjob/submit">
            <input type="hidden" name="job_id" id="edit-job-id">
            <label for="edit-job-name">Job Name:</label>
            <input type="text" name="job_name" id="edit-job-name" required>

            <label for="edit-description">Description:</label>
            <textarea name="description" id="edit-description" required></textarea>

            <label for="edit-vacancies">Vacancies:</label>
            <input type="number" name="vacancies" id="edit-vacancies" required>

            <label for="edit-rate">Rate:</label>
            <input type="text" name="rate" id="edit-rate" required>

            <label for="edit-location">Location:</label>
            <input type="text" name="location" id="edit-location" required>

            <label for="edit-status">Status:</label>
            <select name="status" id="edit-status" required>
                <option value="open">Open</option>
                <option value="closed">Closed</option>
            </select>

            <button type="submit" class="main-button">Save Changes</button>
        </form>
    </div>
</div>

<body>
<div class="applicant-table-container">
    <h2>Applicants for My Jobs</h2>
    <table class="styled-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Job Name</th>
                <th>Applicant Name</th>
                <th>Applicant Email</th>
                <th>Location</th>
                <th>Attachment</th>
                <th>Status</th>
                <th>Actions</th>
                
            </tr>
        </thead>
        <tbody>
            <?php foreach ($applicants as $index => $applicant): ?>
                <tr>
                    <td><?php echo htmlspecialchars($index + 1); ?></td>
                    <td><?php echo htmlspecialchars($applicant['job_name']); ?></td>
                    <td><?php echo htmlspecialchars($applicant['employee_name']); ?></td>
                    <td><?php echo htmlspecialchars($applicant['applicant_email']); ?></td>
                    <td><?php echo htmlspecialchars($applicant['location']); ?></td>
                    <td>
                        <?php if (!empty($applicant['attachment'])): ?>
                            <a href="<?php echo htmlspecialchars($applicant['attachment']); ?>" target="_blank">View Attachment</a>
                        <?php else: ?>
                            No Attachment
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($applicant['status']); ?></td>
                    <td>
                        <!-- Review Button -->
                        <button class="review-btn" onclick="openReviewModal(<?php echo htmlspecialchars(json_encode($applicant)); ?>)">
                            Review
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>

<!-- Modal to Review Applicant Details -->
<div id="reviewModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeReviewModal()">&times;</span>
        <h2>Applicant Details</h2>
        <form method="POST" action="/updateapplystatus/submit">
            
            <input type="hidden" name="application_id" id="review-application-id" value="">
            <div>
                <label>Name:</label>
                <p id="review-name"></p>
            </div>
            <div>
                <label>Age:</label>
                <p id="review-age"></p>
            </div>
            <div>
                <label>Birthday:</label>
                <p id="review-birthday"></p>
            </div>
            <div>
                <label>Place:</label>
                <p id="review-place"></p>
            </div>
            <div>
                <label>Job Experience:</label>
                <p id="review-job-experience"></p>
            </div>
            <div>
                <label>Related Jobs:</label>
                <p id="review-related-jobs"></p>
            </div>
            <div>
                <label>Email:</label>
                <p id="review-email"></p>
            </div>
            <div>
                <label>Attachment:</label>
                <a href="" id="review-attachment" target="_blank">View Attachment</a>
            </div>
            
            <!-- Accept Button -->
            <button type="submit" name="status" value="accepted">Accept</button>
            <!-- Decline Button -->
            <button type="submit" name="status" value="rejected">Decline</button>
            
        </form>
    </div>
</div>



   

    
    
    <!-- ***** Footer Start ***** -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p>
                        Copyright © 2024 Quickstart
                        - Template by: <a href="https://www.phpjabbers.com/">PHPJabbers.com</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="public/js/jquery-2.1.0.min.js"></script>

    <!-- Bootstrap -->
    <script src="public/js/popper.js"></script>
    <script src="public/js/bootstrap.min.js"></script>

    <!-- Plugins -->
    <script src="public/js/scrollreveal.min.js"></script>
    <script src="public/js/waypoints.min.js"></script>
    <script src="public/js/jquery.counterup.min.js"></script>
    <script src="public/js/imgfix.min.js"></script> 
    <script src="public/js/mixitup.js"></script> 
    <script src="public/js/accordions.js"></script>
    
    <!-- Global Init -->
    <script src="public/js/custom.js"></script>

    <script>
    function openEditModal(job) {
        // Populate modal fields with job data
        document.getElementById('edit-job-id').value = job.id;
        document.getElementById('edit-job-name').value = job.job_name;
        document.getElementById('edit-description').value = job.description;
        document.getElementById('edit-vacancies').value = job.vacancies;
        document.getElementById('edit-rate').value = job.rate;
        document.getElementById('edit-location').value = job.location;
        document.getElementById('edit-status').value = job.status;

        // Show the modal
        document.getElementById('editModal').style.display = 'block';
    }

    function closeEditModal() {
        // Hide the modal
        document.getElementById('editModal').style.display = 'none';
    }

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        const modal = document.getElementById('editModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>

<script>
    function openReviewModal(applicant) {
        // Fill the modal with the applicant data
        document.getElementById('review-application-id').value = applicant.application_id;
        document.getElementById('review-name').innerText = applicant.employee_name;
        document.getElementById('review-age').innerText = applicant.age;
        document.getElementById('review-birthday').innerText = applicant.birthday;
        document.getElementById('review-place').innerText = applicant.place;
        document.getElementById('review-job-experience').innerText = applicant.job_experience;
        document.getElementById('review-related-jobs').innerText = applicant.related_jobs;
        document.getElementById('review-email').innerText = applicant.applicant_email;

        if (applicant.attachment) {
            document.getElementById('review-attachment').href = 'uploads/attachments/' + applicant.attachment;
        } else {
            document.getElementById('review-attachment').innerText = 'No Attachment';
        }

        // Display the modal
        document.getElementById('reviewModal').style.display = 'block';
    }

    function closeReviewModal() {
        // Hide the modal
        document.getElementById('reviewModal').style.display = 'none';
    }

    function updateStatus(status) {
        var applicationId = document.getElementById('review-application-id').value;

        // Send an AJAX request to update the status
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/updateApplicationStatus", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Close the modal after updating
                closeReviewModal();
                alert("Application " + status + " successfully.");
                location.reload(); // Reload the page to reflect changes
            } else {
                alert("Error updating application status.");
            }
        };
        xhr.send("application_id=" + applicationId + "&status=" + status);
    }
</script>


  </body>
</html>