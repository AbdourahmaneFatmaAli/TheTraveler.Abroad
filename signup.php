<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body.signup-page {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url(paysage_africain.png);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            padding: 20px 0;
        }

        body.signup-page::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.1);
        }

        .signup-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 50px 60px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 450px;
            width: 90%;
            position: relative;
            z-index: 1;
            margin: 20px 0;
        }

        .signup-container h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 40px;
            color: #333;
            font-weight: 700;
        }

        .message {
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 0.95rem;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background-color: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
            font-size: 1rem;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"] {
            padding: 15px 20px;
            border: none;
            border-radius: 10px;
            background-color: #c8e89e;
            font-size: 1rem;
            color: #333;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-group input::placeholder {
            color: #999;
        }

        .form-group input:focus {
            background-color: #bde08a;
            box-shadow: 0 0 0 3px rgba(156, 204, 101, 0.3);
        }

        .password-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 43px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.3rem;
            padding: 5px;
            line-height: 1;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }

        .password-toggle:hover {
            opacity: 1;
        }

        .form-group.button-container {
            margin-top: 10px;
        }

        .form-group button[type="submit"] {
            padding: 15px 30px;
            background: linear-gradient(135deg, #5dade2 0%, #3498db 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .form-group button[type="submit"]:hover {
            background: linear-gradient(135deg, #4a9fd8 0%, #2980b9 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        }

        .form-group button[type="submit"]:active {
            transform: translateY(0);
        }

        .form-group p {
            text-align: center;
            color: #555;
            margin-top: 10px;
            font-size: 0.95rem;
        }

        .form-group p a {
            color: #8b4513;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .form-group p a:hover {
            color: #a0522d;
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .signup-container {
                padding: 40px 30px;
            }
            
            .signup-container h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body class="signup-page">
    <div class="signup-container">
        <h2>Sign Up</h2>

        <?php if (isset($_SESSION['signup_success'])): ?>
            <div class="message success">
                <?= $_SESSION['signup_success']; unset($_SESSION['signup_success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['signup_error'])): ?>
            <div class="message error">
                <?= $_SESSION['signup_error']; unset($_SESSION['signup_error']); ?>
            </div>
        <?php endif; ?>

        <form action="process_signup.php" method="POST" class="form-container">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter username" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group password-container">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"
                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]{8,}$"
                    title="Password must be at least 8 characters, include uppercase, lowercase, a number, and a special character."
                    placeholder="Enter your password" required>
                <button type="button" class="password-toggle">👁️</button>
            </div>

            <div class="form-group password-container">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm password" required>
                <button type="button" class="password-toggle">👁️</button>
            </div>

            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" placeholder="First Name" required>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" placeholder="Last Name" required>
            </div>

            <div class="form-group button-container">
                <button type="submit">Sign Up</button>
            </div>

            <div class="form-group">
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </form>
    </div>

    <script>
        const toggleBtns = document.querySelectorAll('.password-toggle');
        toggleBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const input = btn.previousElementSibling;
                if(input.type === 'password'){
                    input.type = 'text';
                    btn.textContent = '🙈';
                } else {
                    input.type = 'password';
                    btn.textContent = '👁️';
                }
            });
        });
    </script>
</body>
</html>