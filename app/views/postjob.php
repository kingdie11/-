<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* Form Styling */
form {
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 300px;
    text-align: center;
}

h2 {
    margin-bottom: 20px;
    color: #333;
}

input {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #5cb85c;
    border: none;
    border-radius: 4px;
    color: white;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background-color: #4cae4c;
}

/* Footer Link */
.footer {
    margin-top: 15px;
}

.footer a {
    color: #5cb85c;
    text-decoration: none;
}

.footer a:hover {
    text-decoration: underline;
}

/* About Section */
.about-section {
    margin-top: 50px;
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 80%;
    max-width: 900px;
    text-align: center;
}

.about-section h3 {
    color: #333;
}

.about-section p {
    color: #666;
    font-size: 18px;
    line-height: 1.6;
}
</style>

</head>
<body>
<form method="POST" action="/postjob/submit" enctype="multipart/form-data">
    <h2>Post a Job</h2>
    <input type="text" name="job_name" placeholder="Job Name" required />
    <textarea name="description" placeholder="Job Description" required></textarea>
    <input type="number" name="vacancies" placeholder="Vacancies" required />
    <input type="text" name="rate" placeholder="Rate (e.g., per hour, per project)" required />
    <input type="text" name="location" placeholder="Location" required />
    <input type="file" name="job_file" accept=".pdf,.doc,.docx" /> <!-- Optional attachment -->
    <button type="submit">Post Job</button>
</form>
</body>
</html>
