<?php 
session_start();
include 'config.php';

$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare('SELECT user_id, username, password FROM users WHERE username = ? OR email = ?');
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['loggedin'] = true;

            header('Location: index.php');
            exit();
        } else {
            $error = 'Invalid password';
        }
    } else {
        $error = 'No account found. Please sign up first.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body.login-page {
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
           
            
        }

        body.login-page::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.1);
            
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 50px 60px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 450px;
            width: 90%;
            position: relative;
            z-index: 1;
        }

        .login-container h2 {
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
            .login-container {
                padding: 40px 30px;
            }
            
            .login-container h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body class="login-page">
    <div class="login-container">
        <h2>Login</h2>

        <?php if (!empty($error)): ?>
            <div class="message error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" class="form-container">
            <div class="form-group">
                <label for="username">Username or Email</label>
                <input type="text" id="username" name="username" placeholder="Enter username or email" required>
            </div>

            <div class="form-group password-container">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                <button type="button" class="password-toggle">👁️</button>
            </div>

            <div class="form-group button-container">
                <button type="submit">Login</button>
            </div>

            <div class="form-group">
                <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
            </div>
        </form>
    </div>

    <script>
        const toggleBtn = document.querySelector('.password-toggle');
        const passwordInput = document.getElementById('password');

        toggleBtn.addEventListener('click', () => {
            if(passwordInput.type === 'password'){
                passwordInput.type = 'text';
                toggleBtn.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleBtn.textContent = '👁️';
            }
        });
    </script>
</body>
</html>
