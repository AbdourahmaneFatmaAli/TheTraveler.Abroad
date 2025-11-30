<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$new_password = $_POST['new_password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$token = $_POST['token'] ?? '';

// Validation
if (empty($new_password) || empty($confirm_password) || empty($token)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

if ($new_password !== $confirm_password) {
    echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
    exit;
}

if (strlen($new_password) < 6) {
    echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters long']);
    exit;
}

try {
    // Verify token is valid and not expired
    $stmt = $pdo->prepare("SELECT user_id FROM users WHERE reset_token = ? AND token_expiry > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'Invalid or expired reset token. Please request a new password reset link.']);
        exit;
    }
    
    // Hash new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    
    // Update password and clear reset token
    $stmt = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expiry = NULL WHERE user_id = ?");
    $stmt->execute([$hashed_password, $user['user_id']]);
    
    // Clear any existing sessions for this user (optional security measure)
    // This would require a sessions table in a real application
    
    echo json_encode([
        'success' => true, 
        'message' => 'Password reset successfully! You can now login with your new password.'
    ]);
    
} catch (PDOException $e) {
    error_log("Password reset error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again.']);
}
?>