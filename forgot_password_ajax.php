<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$email = trim($_POST['email'] ?? '');

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address']);
    exit;
}

try {
    // Check if email exists
    $stmt = $pdo->prepare("SELECT user_id, username FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        // Generate reset token
        $reset_token = bin2hex(random_bytes(32));
        $token_expiry = date('Y-m-d H:i:s', time() + (60 * 60)); // 1 hour expiry
        
        // Store token in database
        $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE user_id = ?");
        $stmt->execute([$reset_token, $token_expiry, $user['user_id']]);
        
        // In a real application, you would send an email here
        // For demo purposes, we'll just return success
        $reset_link = "http://localhost/travel-website/reset_password.php?token=" . $reset_token;
        // TODO: Implement email sending
        // mail($email, "Password Reset Request", "Click here to reset your password: " . $reset_link);
        
        echo json_encode([
            'success' => true, 
            'message' => 'Password reset link has been sent to your email. For demo: ' . $reset_link
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No account found with this email address']);
    }
} catch (PDOException $e) {
    error_log("Forgot password error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again.']);
}
?>