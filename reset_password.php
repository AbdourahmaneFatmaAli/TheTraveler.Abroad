<?php
session_start();
require_once 'config.php';

$token = $_GET['token'] ?? '';
$valid_token = false;
$error = '';

// Validate the reset token
if (!empty($token)) {
    try {
        $stmt = $pdo->prepare("SELECT user_id, token_expiry FROM users WHERE reset_token = ? AND token_expiry > NOW()");
        $stmt->execute([$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            $valid_token = true;
            $_SESSION['reset_user_id'] = $user['user_id'];
            $_SESSION['reset_token'] = $token;
        } else {
            $error = "Invalid or expired reset token. Please request a new password reset link.";
        }
    } catch (PDOException $e) {
        $error = "An error occurred. Please try again.";
    }
} else {
    $error = "No reset token provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Travel Website</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="form-container">
            <h2>Reset Your Password</h2>
            
            <?php if ($error): ?>
                <div class="message error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
                <div style="text-align: center; margin-top: 20px;">
                    <a href="login.html" class="btn btn-primary">Back to Login</a>
                </div>
            <?php elseif ($valid_token): ?>
                <div id="message-container"></div>
                
                <form id="reset-password-form" method="POST">
                    <div class="form-group">
                        <label for="new_password">New Password:</label>
                        <input type="password" id="new_password" name="new_password" placeholder="Enter new password" required minlength="6">
                        <div class="password-toggle">
                            <i class="fas fa-eye" id="toggle-new-password"></i>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required minlength="6">
                        <div class="password-toggle">
                            <i class="fas fa-eye" id="toggle-confirm-password"></i>
                        </div>
                    </div>

                    <div class="button-container">
                        <button type="submit" id="reset-password-btn">
                            <span class="btn-text">Reset Password</span>
                            <span class="btn-loading" style="display: none;">
                                <i class="fas fa-spinner fa-spin"></i> Resetting...
                            </span>
                        </button>
                    </div>
                </form>
                
                <div style="text-align: center; margin-top: 15px;">
                    <a href="login.html">Back to Login</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Password Toggle Visibility
        document.getElementById('toggle-new-password')?.addEventListener('click', function() {
            const passwordInput = document.getElementById('new_password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        document.getElementById('toggle-confirm-password')?.addEventListener('click', function() {
            const passwordInput = document.getElementById('confirm_password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Reset Password Form
        document.getElementById('reset-password-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            // Client-side validation
            if (newPassword.length < 6) {
                showMessage('Password must be at least 6 characters long', 'error');
                return;
            }
            
            if (newPassword !== confirmPassword) {
                showMessage('Passwords do not match', 'error');
                return;
            }
            
            const resetBtn = document.getElementById('reset-password-btn');
            const btnText = resetBtn.querySelector('.btn-text');
            const btnLoading = resetBtn.querySelector('.btn-loading');
            
            // Show loading state
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
            resetBtn.disabled = true;
            
            // AJAX request
            fetch('reset_password_ajax.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'new_password': newPassword,
                    'confirm_password': confirmPassword,
                    'token': '<?php echo $token; ?>'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage(data.message, 'success');
                    setTimeout(() => {
                        window.location.href = 'login.html';
                    }, 2000);
                } else {
                    showMessage(data.message, 'error');
                }
            })
            .catch(error => {
                showMessage('An error occurred. Please try again.', 'error');
                console.error('Error:', error);
            })
            .finally(() => {
                // Reset button state
                btnText.style.display = 'inline';
                btnLoading.style.display = 'none';
                resetBtn.disabled = false;
            });
        });

        function showMessage(message, type) {
            const messageContainer = document.getElementById('message-container');
            messageContainer.innerHTML = `
                <div class="message ${type}">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                    ${message}
                </div>
            `;
            messageContainer.style.display = 'block';
        }
    </script>
</body>
</html>