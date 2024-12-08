<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
    *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: #f7f7f7;
        padding: 20px; 
    }

    /* Styling the login form */
    .login-form {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 30px;
        width: 100%;
        max-width: 400px;
        text-align: center;
    }

    /* Form heading */
    .form-heading {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #232d39;
    }

    /* Form inputs */
    .form-input {
        width: 100%;
        padding: 12px 15px;
        margin-bottom: 20px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f9f9f9;
        outline: none;
        color: #232d39;
        display: block;
    }

    .form-input:focus {
        border-color: #ed563b;
        background-color: #fff;
    }

    /* Button styling */
    .main-button {
        display: inline-block;
        width: 100%;
        padding: 12px;
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        text-transform: uppercase;
        background-color: #ed563b;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .main-button:hover {
        background-color: #f9735b;
    }

    /* Footer with register link */
    .form-footer {
        margin-top: 15px;
        font-size: 13px;
        color: #7a7a7a;
    }

    .form-footer a {
        color: #ed563b;
        text-decoration: none;
    }

    .form-footer a:hover {
        color: #f9735b;
    }

</style>

</head>
<body>
    <div class="login-container">
    <form method="POST" action="register/submit" class="login-form">
    <h2 class="form-heading">Register</h2>
    <input type="text" name="username" placeholder="Username" required class="form-input"/>
    <input type="email" name="email" placeholder="Email" required class="form-input"/>
    <input type="password" name="password" placeholder="Password" required class="form-input"/>
    <select name="security_question" required class="form-input">
        <option value="">Select a Security Question</option>
        <option value="What is your pet's name?">What is your pet's name?</option>
        <option value="What is your favorite color?">What is your favorite color?</option>
        <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
    </select>
    <input type="text" name="security_answer" placeholder="Answer to Security Question" required class="form-input"/>
        <button type="submit" class="main-button">Register</button>
        <div class="form-footer">
            <p>Already have an account? <a href="/login">Login here</a></p>
        </div>
    </div>    
    </form>
</body>
</html>
class="form-input"