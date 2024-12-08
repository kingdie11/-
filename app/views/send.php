<?php
// Start session to access admin ID
//session_start();

// Ensure the admin is logged in
if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please log in as an user.");
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
    $userId = $_SESSION['user_id'];

    // Query to fetch applications for the logged-in user
    $query = "
        SELECT 
            ja.application_id AS application_id,
            ja.status,
            ja.attachment,
            j.job_name,
            j.location,
            j.rate
        FROM 
            jobapply ja
        JOIN 
            job j ON ja.job_id = j.id
        WHERE 
            ja.user_id = :user_id
    ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    $applications = $stmt->fetchAll(); // Fetch all applications
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

    <title>Home</title>

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
                        <a href="index.html" class="logo">QuickStart<em> Website</em></a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li><a href="email" class="active">Home</a></li>
                            <li><a href="job">Jobs</a></li>
                            <li><a href="bout">About Us</a></li>
                            <li><a href="contact">Contact</a></li> 
                            <li><a href="profile">Edit</a></li>
                            <li><a href="/logout">Logout</a></li>
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
                <h6>Getting rusty recently?</h6>
                <h2>Get a Job at <em>QuickStart</em></h2>
                <div class="main-button">
                    <a href="job">Browse Job</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->

    <div class="job-table-container">
    <h2>Your Applications</h2>
    <?php if (empty($applications)): ?>
        <p>No applications found.</p>
    <?php else: ?>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Job Name</th>
                    <th>Location</th>
                    <th>Rate</th>
                    <th>Status</th>
                    <th>Attachment</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $application): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($application['job_name']); ?></td>
                        <td><?php echo htmlspecialchars($application['location']); ?></td>
                        <td><?php echo htmlspecialchars($application['rate']); ?></td>
                        <td>
                            <span class="status <?php echo strtolower($application['status']); ?>">
                                <?php echo htmlspecialchars($application['status']); ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($application['attachment']): ?>
                                <a href="uploads/attachments/<?php echo htmlspecialchars($application['attachment']); ?>" target="_blank">View Resume</a>
                            <?php else: ?>
                                No Attachment
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<style>
    /* General table styling */
    .table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }
    .table th, .table td {
        padding: 12px;
        text-align: left;
    }
    .table-bordered th, .table-bordered td {
        border: 1px solid #ddd;
    }

    /* Status-specific colors */
    .status {
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 5px;
    }
    .status.pending {
        background-color: yellow;
        color: #000;
    }
    .status.accepted {
        background-color: green;
        color: #fff;
    }
    .status.rejected {
        background-color: red;
        color: #fff;
    }
</style>

   

    


    
    
    
    <!-- ***** Footer Start ***** -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p>
                        Copyright © 2024 QuickStart
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

  </body>
</html>