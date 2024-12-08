<?php
// Database connection details
$host = 'localhost';
$db = 'emailnauth';
$user = 'kingd';
$pass = 'kingd';

try {
    // Connect to the database using PDO
    $mydb = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $mydb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch jobs directly
    $query = "SELECT * FROM job WHERE status = 'open'";
    $stmt = $mydb->prepare($query);
    $stmt->execute();
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
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

    <title>Job List</title>

    <link rel="stylesheet" type="text/css" href="public/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="public/css/font-awesome.css">

    <link rel="stylesheet" href="public/css/style.css">

    </head>
    <style>
        .job-item {
    margin-bottom: 20px; /* Adds space between job items */
}

.pagination {
    margin-top: 20px;
    display: inline-flex;
    justify-content: center;
}

.page-item a {
    color: #007bff;
    margin: 0 5px;
    text-decoration: none;
    padding: 5px 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.page-item a:hover {
    background-color: #007bff;
    color: white;
}

    </style>
    
    <body>
    
    <!-- ***** Preloader Start ***** -->
   <!-- <div id="js-preloader" class="js-preloader">
      <div class="preloader-inner">
        <span class="dot">
        <div class="dots">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
    </div> -->
    <!-- ***** Preloader End ***** -->
    
    
    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="index.html" class="logo">Job Agency<em> Website</em></a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li><a href="email">Home</a></li>
                            
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

    <!-- ***** Call to Action Start ***** -->
    <section class="section section-bg" id="call-to-action" style="background-image: url(public/images/banner-image-1-1920x500.jpg)">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="cta-content">
                        <br>
                        <br>
                        <h2>Our <em>Jobs</em></h2>
                        <p>Ut consectetur, metus sit amet aliquet placerat, enim est ultricies ligula</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Call to Action End ***** -->

    <!-- ***** Fleet Starts ***** -->
    <section class="section" id="trainers">
        <div class="container">
                <div class="col-md-12">
                    <div class="row">
                    <div class="input-group mb-6">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search jobs by name, location, or description" aria-label="Search">
                </div>
                <div class="row" id="jobResults" style="display: none;"></div>
                <?php foreach ($jobs as $index => $job): ?>
                <div class="col-md-4 job-item mb-4" 
                     data-name="<?php echo htmlspecialchars($job['job_name']); ?>" 
                     data-location="<?php echo htmlspecialchars($job['location']); ?>" 
                     data-description="<?php echo htmlspecialchars($job['description']); ?>"
                     data-index="<?php echo $index; ?>"> <!-- Add index for pagination -->
                    <div class="trainer-item">
                        <div class="down-content">
                            <h4><?php echo htmlspecialchars($job['job_name']); ?></h4>
                            <p style="display: none;">Job ID: <?php echo htmlspecialchars($job['id']); ?></p> 
                            <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                            <p><strong>Description:</strong> <?php echo htmlspecialchars($job['description']); ?></p>
                            <p><strong>Rate:</strong> <?php echo htmlspecialchars($job['rate']); ?></p>
                            <p><strong>Vacancies:</strong> <?php echo htmlspecialchars($job['vacancies']); ?></p>
                            <ul class="social-icons">
                                        <!-- Button to trigger the modal -->
                                        <li><a href="javascript:void(0);" data-toggle="modal" data-target="#applyModal" data-job-id="<?php echo $job['id']; ?>" class="apply-btn">+ Apply Now</a></li>
                                    </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
                       
                    </div>
                </div>
                </div>

                <!-- Modal for applying to a job -->
                <div class="modal fade" id="applyModal" tabindex="-1" role="dialog" aria-labelledby="applyModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="applyModalLabel">Apply for Job</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="applyForm" method="POST" action="applyjob/submit" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <!-- Job ID will be dynamically set -->
                                    <input type="hidden" id="jobId" name="job_id" value="">

                                    <div class="form-group">
                                        <label for="attachment">Upload Your Resume</label>
                                        <input type="file" class="form-control" name="attachment" id="attachment">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Submit Application</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                    

    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const jobItems = document.querySelectorAll('.job-item');
    const jobResults = document.getElementById('jobResults');
    const pagination = document.getElementById('pagination');
    const itemsPerPage = 5;

    function showPage(page) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        jobItems.forEach((item, index) => {
            if (item.style.display !== 'none') {
                if (index >= start && index < end) {
                    item.style.display = 'block'; // Show items for the current page
                } else {
                    item.style.display = 'none'; // Hide items not on the current page
                }
            }
        });

        // Display the job results section
        jobResults.style.display = 'block';
    }

    function updatePagination(totalItems) {
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        pagination.innerHTML = '';

        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement('li');
            li.classList.add('page-item');
            li.innerHTML = `<a href="javascript:void(0);" class="page-link">${i}</a>`;
            li.addEventListener('click', () => showPage(i));
            pagination.appendChild(li);
        }
    }

    function filterJobs() {
        const searchTerm = searchInput.value.toLowerCase();
        let filteredCount = 0;

        jobItems.forEach(item => {
            const jobName = item.getAttribute('data-name').toLowerCase();
            const jobLocation = item.getAttribute('data-location').toLowerCase();
            const jobDescription = item.getAttribute('data-description').toLowerCase();

            // Check if the search term matches any field
            if (!searchTerm || jobName.includes(searchTerm) || jobLocation.includes(searchTerm) || jobDescription.includes(searchTerm)) {
                item.style.display = 'block'; // Show matching items
                filteredCount++;
            } else {
                item.style.display = 'none'; // Hide non-matching items
            }
        });

        // Update pagination
        updatePagination(filteredCount);

        // Show the first page of results if filtered results exist
        if (filteredCount > 0) {
            showPage(1);
        }
    }

    // Trigger filtering and pagination on typing
    searchInput.addEventListener('input', filterJobs);

    // Initialize pagination for all items and show the first page
    updatePagination(jobItems.length);
    showPage(1);
});
    </script>

                <script>
                    document.getElementById('applyForm').addEventListener('submit', function (e) {
                        e.preventDefault(); // Prevent default form submission

                        const formData = new FormData(this); // Collect form data

                        fetch('/applyjob/submit', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                showCustomAlert(data.message); // Show success modal
                                setTimeout(() => {
                                document.getElementById('customAlertModal').style.display = 'none';
                                window.location.href = '/job'; // Adjust the URL to your jobs page
                            }, 3000); // 3000ms = 3 seconds
                            } else {
                                showCustomAlert(data.message); // Show error modal
                            }
                        })
                        .catch(error => {
                            showCustomAlert('An unexpected error occurred. Please try again.');
                            console.error('Error:', error);
                        });
                    });
                </script>

                <div id="customAlertModal" class="custom-modal">
                    <div class="custom-modal-content">
                        <span class="close-btn" onclick="closeCustomAlert(window.location.href = '/job')">&times;</span>
                        <p id="customAlertMessage"></p>
                    </div>
                </div>

                <style>
                    .custom-modal {
                        display: none; /* Hidden by default */
                        position: fixed;
                        z-index: 9999;
                        left: 0;
                        top: 0;
                        width: 100%;
                        height: 100%;
                        background-color: rgba(0, 0, 0, 0.5); /* Black with opacity */
                    }

                    .custom-modal-content {
                        background-color: #fff;
                        margin: 15% auto;
                        padding: 20px;
                        border-radius: 8px;
                        text-align: center;
                        width: 80%;
                        max-width: 400px;
                        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
                    }

                    .close-btn {
                        float: right;
                        font-size: 1.5rem;
                        font-weight: bold;
                        color: #aaa;
                        cursor: pointer;
                    }

                    .close-btn:hover {
                        color: #000;
                    }
                </style>

                <script>
                    function showCustomAlert(message) {
                    document.getElementById('customAlertMessage').innerText = message;
                    document.getElementById('customAlertModal').style.display = 'block';
                    
                }

                function closeCustomAlert() {
                    document.getElementById('customAlertModal').style.display = 'none';
                    
                }
                </script>




                <!-- JavaScript to handle modal job id -->
                <script>
                    // Wait for DOM to load
                    document.addEventListener('DOMContentLoaded', function() {
                        // Add click event listener to all Apply Now buttons
                        document.querySelectorAll('.apply-btn').forEach(button => {
                            button.addEventListener('click', function() {
                                const jobId = this.getAttribute('data-job-id'); // Get the job ID
                                document.getElementById('jobId').value = jobId; // Set it in the modal's hidden input
                            });
                        });
                    });
                </script>

                

                

                

                

            <br>
                
            <nav>
             <!-- Pagination Section -->
        <div class="row">
            <div class="col-lg-12 text-center">
                <nav>
                    <ul class="pagination" id="pagination"></ul>
                </nav>
            </div>
        </div>
    </div>
            </nav>

        </div>
    </section>
    <!-- ***** Fleet Ends ***** -->

    
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