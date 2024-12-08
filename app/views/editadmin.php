<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
    
    .container {
    margin-top: 50px;
    font-family: 'Poppins', sans-serif;
    color: #333;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
    color: #555;
}

input, textarea, .form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 14px;
}

button {
    cursor: pointer;
}

button:hover {
    opacity: 0.9;
}

.btn-secondary {
    background: #6c757d;
    border: none;
    font-size: 14px;
}

.btn-secondary:hover {
    background: #5a6268;
}

.profile-picture img {
    margin-bottom: 20px;
}

.profile-picture img {
    width: 150px;
    height: 150px;
    border-radius: 50%; /* Make the image circular */
    object-fit: cover; /* Ensure proper cropping */
    border: 2px solid #ddd; /* Optional border */
    margin-bottom: 20px;
}


    </style>

</head>
<body>
<div class="container">
<div style="margin-bottom: 20px;">
        <a href="/adminhome" class="btn btn-secondary" style="text-decoration: none; color: white; padding: 10px 15px; border-radius: 5px;">←</a>
    </div>
    <h2 style="text-align: center; margin-bottom: 20px;">Manage Company Profile</h2>

    <!-- Company Logo -->
    <div class="profile-picture" style="text-align: center; margin-bottom: 20px;">
        <img src="<?php echo !empty($companyProfile['company_logo']) ? '/' . $companyProfile['company_logo'] : '/default-company-logo.png'; ?>" 
             alt="Company Logo" 
             style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 2px solid #ddd;">
    </div>

    <!-- Add/Edit Company Profile Form -->
    <form method="POST" action="/createAdmin/submit" enctype="multipart/form-data" style="max-width: 600px; margin: auto; background: #f9f9f9; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <div class="form-group">
            <label for="company_name" style="font-weight: bold;">Company Name:</label>
            <input type="text" id="company_name" name="company_name" class="form-control" value="<?php echo htmlspecialchars($companyProfile['company_name'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="company_address" style="font-weight: bold;">Company Address:</label>
            <input type="text" id="company_address" name="company_address" class="form-control" value="<?php echo htmlspecialchars($companyProfile['company_address'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="contact_email" style="font-weight: bold;">Contact Email:</label>
            <input type="email" id="contact_email" name="contact_email" class="form-control" value="<?php echo htmlspecialchars($companyProfile['contact_email'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="contact_phone" style="font-weight: bold;">Contact Phone:</label>
            <input type="text" id="contact_phone" name="contact_phone" class="form-control" value="<?php echo htmlspecialchars($companyProfile['contact_phone'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="website_url" style="font-weight: bold;">Website URL:</label>
            <input type="url" id="website_url" name="website_url" class="form-control" value="<?php echo htmlspecialchars($companyProfile['website_url'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="description" style="font-weight: bold;">Description:</label>
            <textarea id="description" name="description" class="form-control"><?php echo htmlspecialchars($companyProfile['description'] ?? ''); ?></textarea>
        </div>
        <div class="form-group">
            <label for="company_logo" style="font-weight: bold;">Upload Company Logo:</label>
            <input type="file" id="company_logo" name="company_logo" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary btn-block" style="background: #5cb85c; border: none; padding: 10px 15px; font-size: 16px; border-radius: 5px;">
            <?php echo $companyProfile ? 'Edit Profile' : 'Create Profile'; ?>
        </button>
    </form>
</div>


</body>
</html>
