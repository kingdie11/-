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
<form id="verifySecurityForm" method="POST" action="/verifyanswer/submit">
    <h2>Verify Security Answer</h2>
    <h2>Security Question</h2>
    <input type="text" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"readonly>
    <div>
        <label for="security_question">Security Question</label>
        <input type="text" id="security_question" value="<?php echo htmlspecialchars($user['security_question']); ?>" readonly>
    </div>

    <div>
        <label for="security_answer">Your Answer</label>
        <input type="text" name="security_answer" placeholder="Enter your answer" required>
    </div>
    
    <button type="submit">Next</button>
</form>
</body>
</html>