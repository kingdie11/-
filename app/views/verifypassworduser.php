<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    form {
        max-width: 400px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
    input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
    }
    button {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        border: none;
        color: white;
        border-radius: 5px;
        cursor: pointer;
    }
    button:hover {
        background-color: #0056b3;
    }
</style>
<body>
<form method="POST" action="/resetpassword/submit">
    <h2>Update Password</h2>
    
    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">

    <div>
        <label for="new_password">New Password</label>
        <input type="password" name="new_password" placeholder="Enter new password" required>
    </div>

    <div>
        <label for="confirm_password">Confirm Password</label>
        <input type="password" name="confirm_password" placeholder="Confirm password" required>
    </div>

    <button type="submit">Reset Password</button>
</form>
    
</body>
</html>