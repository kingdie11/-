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
    <!-- Back to Home Button -->
    <div style="margin-bottom: 20px;">
        <a href="/email" class="btn btn-secondary" style="text-decoration: none; color: white; padding: 10px 15px; border-radius: 5px;">←</a>
    </div>

    <h2 style="text-align: center; margin-bottom: 20px;">Manage Profile</h2>

    <!-- Profile Picture Section -->
    <div class="profile-picture" style="text-align: center; margin-bottom: 20px;">
        <img src="<?php echo !empty($profile['profile_picture']) ? '/' . $profile['profile_picture'] : '/default-profile.png'; ?>" 
             alt="Profile Picture" 
             style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 2px solid #ddd;">
    </div>

    <!-- Add/Edit Profile Form -->
    <form method="POST" action="/createProfile/submit" enctype="multipart/form-data" style="max-width: 600px; margin: auto; background: #f9f9f9; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <div class="form-group">
            <label for="name" style="font-weight: bold;">Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($profile['name'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="age" style="font-weight: bold;">Age:</label>
            <input type="number" id="age" name="age" class="form-control" value="<?php echo htmlspecialchars($profile['age'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="birthday" style="font-weight: bold;">Birthday:</label>
            <input type="date" id="birthday" name="birthday" class="form-control" value="<?php echo htmlspecialchars($profile['birthday'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="place" style="font-weight: bold;">Place:</label>
            <input type="text" id="place" name="place" class="form-control" value="<?php echo htmlspecialchars($profile['place'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="job_experience" style="font-weight: bold;">Job Experience:</label>
            <textarea id="job_experience" name="job_experience" class="form-control"><?php echo htmlspecialchars($profile['job_experience'] ?? ''); ?></textarea>
        </div>
        <div class="form-group">
            <label for="related_jobs" style="font-weight: bold;">Related Jobs:</label>
            <textarea id="related_jobs" name="related_jobs" class="form-control"><?php echo htmlspecialchars($profile['related_jobs'] ?? ''); ?></textarea>
        </div>
        <div class="form-group">
            <label for="profile_picture" style="font-weight: bold;">Profile Picture:</label>
            <input type="file" id="profile_picture" name="profile_picture" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary btn-block" style="background: #5cb85c; border: none; padding: 10px 15px; font-size: 16px; border-radius: 5px;">
            <?php echo $profile ? 'Edit Profile' : 'Create Profile'; ?>
        </button>
    </form>
</div>

</body>
</html>
