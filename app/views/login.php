<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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

    .password-container {
    position: relative;
    width: 100%;
    margin-bottom: 15px;
}

.password-container input {
    width: calc(100% - 40px);
    padding-right: 40px;
}

.toggle-password {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    border: none;
    background: none;
    cursor: pointer;
    font-size: 18px;
}

.forgot-password {
    text-align: right;
    margin-top: 5px;
}

.forgot-password a {
    font-size: 14px;
    text-decoration: none;
    color: #007bff;
}

.forgot-password a:hover {
    text-decoration: underline;
}

.modal-header .close {
    font-size: 1.5rem;
}

.modal-dialog-centered {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh; /* Full height */
}

/* Style modal content */
.modal-content {
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Adjust the close button */
.modal-header .close {
    font-size: 1.5rem;
    color: #000;
    opacity: 0.7;
}

.modal-header .close:hover {
    opacity: 1;
}

/* Add some padding inside the modal */
.modal-body {
    padding: 20px;
}

/* Customize buttons */
.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

/* For smooth animation */
.modal.fade .modal-dialog {
    transition: transform 0.3s ease-out, opacity 0.3s ease-out;
}
    </style>

</head>
<body>
<div class="login-container">
    <form method="POST" action="/log" class="login-form">
    <h2 class="form-heading">Login</h2>
    
    <!-- Email Field -->
    <input type="email" name="email" placeholder="Email" required class="form-input" />

    <!-- Password Field with Toggle -->
    <div class="password-container">
        <input type="password" name="password" id="password" placeholder="Password" required class="form-input" />
        <button type="button" class="toggle-password" onclick="togglePassword()">👁</button>
    </div>

    <!-- Forgot Password Link -->
    <div class="forgot-password">
        <a href="/forgotpassword">Forgot Password?</a>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="main-button">Login</button>

    <!-- Footer -->
    <div class="form-footer">
    <p>
    Don't have an account? 
    <a href="/register" id="secret-log-link">Register here</a>
</p>

<script>
    const secretLogLink = document.getElementById('secret-log-link');
    let pressTimer;

    secretLogLink.addEventListener('mousedown', () => {
        // Start the timer on mouse down
        pressTimer = setTimeout(() => {
            // Redirect to /adminlog if pressed for 3 seconds
            window.location.href = '/adminlog';
        }, 3000); // 3000 milliseconds = 3 seconds
    });

    secretLogLink.addEventListener('mouseup', () => {
        // Clear the timer if the mouse is released before 3 seconds
        clearTimeout(pressTimer);
    });

    secretLogLink.addEventListener('mouseleave', () => {
        // Clear the timer if the mouse leaves the link before 3 seconds
        clearTimeout(pressTimer);
    });
</script>
    </div>
    </form>
</div>





<script>
    function togglePassword() {
    const passwordField = document.getElementById('password');
    const passwordToggle = document.querySelector('.toggle-password');

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        passwordToggle.textContent = '🙈'; // Change icon
    } else {
        passwordField.type = 'password';
        passwordToggle.textContent = '👁'; // Change icon
    }
}
</script>

<script>
    


</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
