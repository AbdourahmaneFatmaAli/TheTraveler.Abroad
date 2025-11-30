<?php 
session_start();
include 'config.php';

$error ='';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = trim($_POST['username']);
    $password = $_POST['password'];
   
    $stmt = $pdo->prepare('SELECT user_id, username, password FROM users WHERE username = ? OR email = ?');
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch();
    
    if ($user) {

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['loggedin'] = true;



            header('Location: index.html');
            exit();

        } else {
            $error = 'Invalid password';
        }

    } else {
        $error = 'No registered found. Please sign up first';
    }

}
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width" initial-scale="1.0">
        <title>Login Page</title>
        <link rel="stylesheet" href="styles.css">


    </head>
    <body class="login-page">
        <div class="login-container">
            <h2>Login</h2>

            <?php if (!empty($error)): ?>
                <div style="color:red; margin-bottom: 15px; font-weight: bold;">
                    <?php echo $error; ?>

                </div>
                <?php endif; ?>

                
            
                <form  method="POST">
                <label for="username">Username or Email: </label>
            <input type="text" id="username" name="username" placeholder="Enter username or email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <button type="submit">Login</button>

            <p style="color:white; font-weight: bold;">
                Don't have an account? 
                <a href="signup.php">Sign up here</a>
            </p>
        </form>
    </div>
</body>
</html>